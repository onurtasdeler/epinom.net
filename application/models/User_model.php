<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model (Genisletilmis)
 * Kullanici CRUD islemleri, aktivasyon, sifre yonetimi.
 */
class User_model extends CI_Model {
    
    protected $table = 'users';
    
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname',
        'phone_number', 'tc_no', 'birthyear', 'activation_code',
        'ref_user_id', 'ip_control', 'ip_addresses'
    ];
    
    public function __construct() {
        parent::__construct();
    }
    
    // ══════════════════════════════════════════
    // TEMEL CRUD
    // ══════════════════════════════════════════
    
    public function find($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
    
    public function findByEmail($email) {
        return $this->db->where('email', strtolower(trim($email)))->get($this->table)->row();
    }
    
    public function findByHash($hash) {
        return $this->db->where('user_hash', $hash)->get($this->table)->row();
    }
    
    public function getAll($where = [], $limit = NULL, $offset = 0) {
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }
    
    public function create(array $data) {
        $data = array_intersect_key($data, array_flip($this->fillable));
        $data['email'] = strtolower(trim($data['email']));
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['user_hash'] = $this->generateHash();
        $data['activation_status'] = 0;
        
        if (!isset($data['activation_code'])) {
            $data['activation_code'] = $this->generateActivationCode();
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, array $data) {
        $allowed = array_merge($this->fillable, ['activation_status', 'balance']);
        $data = array_intersect_key($data, array_flip($allowed));
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->where('id', $id)->update($this->table, $data);
    }
    
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    
    // ══════════════════════════════════════════
    // AKTIVASYON
    // ══════════════════════════════════════════
    
    public function activate($id) {
        return $this->db->where('id', $id)->update($this->table, [
            'activation_status' => 1,
            'activated_at' => date('Y-m-d H:i:s'),
            'activation_code' => NULL
        ]);
    }
    
    public function generateActivationCode() {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    public function resetActivationCode($id) {
        $code = $this->generateActivationCode();
        $this->db->where('id', $id)->update($this->table, [
            'activation_code' => $code
        ]);
        return $code;
    }
    
    // ══════════════════════════════════════════
    // HASH YONETIMI
    // ══════════════════════════════════════════
    
    public function generateHash() {
        return bin2hex(random_bytes(32));
    }
    
    public function refreshHash($id) {
        $hash = $this->generateHash();
        $this->db->where('id', $id)->update($this->table, ['user_hash' => $hash]);
        return $hash;
    }
    
    // ══════════════════════════════════════════
    // SIFRE YONETIMI
    // ══════════════════════════════════════════
    
    public function updatePassword($id, $hashedPassword) {
        return $this->db->where('id', $id)->update($this->table, [
            'password' => $hashedPassword,
            'password_changed_at' => date('Y-m-d H:i:s'),
            'user_hash' => $this->generateHash()
        ]);
    }
    
    public function setResetToken($id) {
        $token = bin2hex(random_bytes(32));
        $this->db->where('id', $id)->update($this->table, [
            'reset_token' => $token,
            'reset_token_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);
        return $token;
    }
    
    public function findByResetToken($token) {
        return $this->db
            ->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->get($this->table)
            ->row();
    }
    
    public function clearResetToken($id) {
        return $this->db->where('id', $id)->update($this->table, [
            'reset_token' => NULL,
            'reset_token_expires' => NULL
        ]);
    }
    
    // ══════════════════════════════════════════
    // LOGIN TRACKING
    // ══════════════════════════════════════════
    
    public function recordFailedLogin($id) {
        $this->db->set('failed_login_attempts', 'failed_login_attempts + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->table);
    }
    
    public function clearFailedLogins($id) {
        return $this->db->where('id', $id)->update($this->table, [
            'failed_login_attempts' => 0
        ]);
    }
    
    public function isLocked($user) {
        if (!isset($user->locked_until) || $user->locked_until === NULL) {
            return FALSE;
        }
        return strtotime($user->locked_until) > time();
    }
    
    public function lockAccount($id, $minutes = 15) {
        return $this->db->where('id', $id)->update($this->table, [
            'locked_until' => date('Y-m-d H:i:s', strtotime("+{$minutes} minutes"))
        ]);
    }
    
    // ══════════════════════════════════════════
    // EMAIL KONTROL
    // ══════════════════════════════════════════
    
    public function emailExists($email, $excludeId = NULL) {
        $this->db->where('email', strtolower(trim($email)));
        if ($excludeId !== NULL) {
            $this->db->where('id !=', $excludeId);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
    
    // ══════════════════════════════════════════
    // REFERANS SISTEMI
    // ══════════════════════════════════════════
    
    public function addReferralPoints($userId, $points = 1) {
        $this->db->set('ref_points', 'ref_points + ' . (int)$points, FALSE);
        $this->db->where('id', $userId);
        return $this->db->update($this->table);
    }
    
    public function getReferrals($userId) {
        return $this->db
            ->where('ref_user_id', $userId)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }
}
