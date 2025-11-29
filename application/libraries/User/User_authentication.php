<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Authentication Library
 * Kullanici oturum yonetimi, rate limiting ve guvenlik kontrolleri.
 */
class User_authentication {
    
    private $CI;
    private $max_login_attempts = 5;
    private $lockout_time = 900;
    private $session_timeout = 1800;
    private $session_key = 'user_auth';
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    
    public function login($user) {
        $this->CI->session->sess_regenerate(TRUE);
        
        $session_data = [
            'user_id' => $user->id,
            'user_hash' => $user->user_hash,
            'email' => $user->email,
            'login_time' => time(),
            'last_activity' => time(),
            'ip_address' => $this->CI->input->ip_address(),
            'user_agent' => substr($this->CI->input->user_agent(), 0, 120)
        ];
        
        $this->CI->session->set_userdata($this->session_key, $session_data);
        $this->logLogin($user->id, 'success');
        
        $this->CI->db->where('id', $user->id)->update('users', [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $this->CI->input->ip_address(),
            'failed_login_attempts' => 0
        ]);
        
        $this->clearRateLimit();
        return TRUE;
    }
    
    public function logout() {
        $this->CI->session->unset_userdata($this->session_key);
        $this->CI->session->sess_destroy();
    }
    
    public function isLoggedIn() {
        $session = $this->CI->session->userdata($this->session_key);
        
        if (empty($session) || !isset($session['user_id'])) {
            return FALSE;
        }
        
        if (time() - $session['last_activity'] > $this->session_timeout) {
            $this->logout();
            return FALSE;
        }
        
        $session['last_activity'] = time();
        $this->CI->session->set_userdata($this->session_key, $session);
        return TRUE;
    }
    
    public function getUser() {
        if (!$this->isLoggedIn()) {
            return NULL;
        }
        
        $session = $this->CI->session->userdata($this->session_key);
        return $this->CI->db
            ->where('id', $session['user_id'])
            ->where('user_hash', $session['user_hash'])
            ->get('users')
            ->row();
    }
    
    public function getUserId() {
        $session = $this->CI->session->userdata($this->session_key);
        return isset($session['user_id']) ? $session['user_id'] : NULL;
    }
    
    public function isRateLimited($identifier = NULL) {
        if ($identifier === NULL) {
            $identifier = $this->CI->input->ip_address();
        }
        $cache_key = 'login_attempts_' . md5($identifier);
        $attempts = $this->CI->session->tempdata($cache_key);
        return ($attempts !== NULL && $attempts >= $this->max_login_attempts);
    }
    
    public function incrementRateLimit($identifier = NULL) {
        if ($identifier === NULL) {
            $identifier = $this->CI->input->ip_address();
        }
        $cache_key = 'login_attempts_' . md5($identifier);
        $attempts = $this->CI->session->tempdata($cache_key);
        $attempts = ($attempts === NULL) ? 1 : $attempts + 1;
        $this->CI->session->set_tempdata($cache_key, $attempts, $this->lockout_time);
    }
    
    public function clearRateLimit($identifier = NULL) {
        if ($identifier === NULL) {
            $identifier = $this->CI->input->ip_address();
        }
        $cache_key = 'login_attempts_' . md5($identifier);
        $this->CI->session->unset_tempdata($cache_key);
    }
    
    public function getRemainingAttempts($identifier = NULL) {
        if ($identifier === NULL) {
            $identifier = $this->CI->input->ip_address();
        }
        $cache_key = 'login_attempts_' . md5($identifier);
        $attempts = $this->CI->session->tempdata($cache_key);
        return ($attempts === NULL) ? $this->max_login_attempts : max(0, $this->max_login_attempts - $attempts);
    }
    
    public function isIpAllowed($user) {
        if (!$user->ip_control) {
            return TRUE;
        }
        $allowed_ips = json_decode($user->ip_addresses, TRUE);
        if (empty($allowed_ips) || !is_array($allowed_ips)) {
            return TRUE;
        }
        return in_array($this->CI->input->ip_address(), $allowed_ips);
    }
    
    public function logLogin($user_id, $status, $reason = NULL) {
        if (!$this->CI->db->table_exists('login_logs')) {
            return;
        }
        $this->CI->db->insert('login_logs', [
            'user_id' => $user_id,
            'ip_address' => $this->CI->input->ip_address(),
            'user_agent' => substr($this->CI->input->user_agent(), 0, 255),
            'status' => $status,
            'failure_reason' => $reason,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function generateHash() {
        return bin2hex(random_bytes(32));
    }
    
    public function generateActivationCode() {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    public function generateResetToken() {
        return bin2hex(random_bytes(32));
    }
    
    public function requireLogin($redirect_url = NULL) {
        if ($this->isLoggedIn()) {
            return TRUE;
        }
        if ($redirect_url === NULL) {
            $redirect_url = current_url();
        }
        redirect('uye/giris-yap?r=' . urlencode($redirect_url));
        return FALSE;
    }
}
