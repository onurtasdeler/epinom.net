<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Helper
 * Yeni guvenlik sistemi ile uyumlu yardimci fonksiyonlar.
 */

if (!function_exists('getActiveUser')) {
    /**
     * Aktif kullaniciyi getir (Yeni auth sistemi ile)
     * @return object|null
     */
    function getActiveUser() {
        $CI =& get_instance();

        // Yeni auth library yukluyse onu kullan
        if (isset($CI->auth) && method_exists($CI->auth, 'getUser')) {
            return $CI->auth->getUser();
        }

        // Fallback: Eski session sistemi
        $user = $CI->session->userdata('user');
        if ($user && isset($user->id)) {
            return $user;
        }

        // user_auth session key kontrolu
        $auth_data = $CI->session->userdata('user_auth');
        if ($auth_data && isset($auth_data['user_id'])) {
            $CI->load->database();
            return $CI->db->where('id', $auth_data['user_id'])->get('users')->row();
        }

        return NULL;
    }
}

if (!function_exists('isLoggedIn')) {
    /**
     * Kullanici giris yapmis mi?
     * @return bool
     */
    function isLoggedIn() {
        return getActiveUser() !== NULL;
    }
}

if (!function_exists('requireLogin')) {
    /**
     * Giris gerektir, yoksa yonlendir
     * @param string $redirect Yonlendirilecek URL (null = current)
     * @return object User objesi
     */
    function requireLogin($redirect = NULL) {
        $user = getActiveUser();
        if (!$user) {
            $CI =& get_instance();
            if ($redirect === NULL) {
                $redirect = current_url();
            }
            redirect('uye/giris-yap?r=' . urlencode($redirect));
            exit;
        }
        return $user;
    }
}

if (!function_exists('getUserBalance')) {
    /**
     * Kullanici bakiyesini getir
     * @param int $userId
     * @return float
     */
    function getUserBalance($userId = NULL) {
        if ($userId === NULL) {
            $user = getActiveUser();
            if (!$user) return 0.00;
            $userId = $user->id;
        }

        $CI =& get_instance();
        $CI->load->database();
        $user = $CI->db->select('balance')->where('id', $userId)->get('users')->row();
        return $user ? (float)$user->balance : 0.00;
    }
}

if (!function_exists('generateUserHash')) {
    /**
     * Guvenli user hash uret
     * @return string
     */
    function generateUserHash() {
        return bin2hex(random_bytes(32));
    }
}

if (!function_exists('generateActivationCode')) {
    /**
     * 6 haneli aktivasyon kodu uret
     * @return string
     */
    function generateActivationCode() {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
