<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Password Handler Library
 * 
 * Güvenli şifre yönetimi için Argon2ID algoritması kullanır.
 * MD5'ten geçiş için legacy desteği içerir.
 * 
 * @author Claude Code
 * @version 1.0.0
 */
class Password_handler {
    
    /**
     * Argon2ID ayarları
     */
    private $memory_cost = 65536;  // 64MB
    private $time_cost = 4;
    private $threads = 3;
    
    /**
     * Şifreyi hash'le (Argon2ID)
     * 
     * @param string $password Plain text şifre
     * @return string Hash'lenmiş şifre
     */
    public function hash($password) {
        // PHP 7.2+ için Argon2ID, yoksa bcrypt
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => $this->memory_cost,
                'time_cost' => $this->time_cost,
                'threads' => $this->threads
            ]);
        }
        
        // Fallback: bcrypt
        return password_hash($password, PASSWORD_BCRYPT, [
            'cost' => 12
        ]);
    }
    
    /**
     * Şifreyi doğrula
     * 
     * @param string $password Plain text şifre
     * @param string $hash Veritabanındaki hash
     * @return bool
     */
    public function verify($password, $hash) {
        // Önce modern hash kontrolü
        if (password_verify($password, $hash)) {
            return TRUE;
        }
        
        // Legacy MD5 kontrolü (geçiş dönemi için)
        if (strlen($hash) === 32 && $hash === md5($password)) {
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Hash'in güncellenmesi gerekiyor mu?
     * 
     * @param string $hash Mevcut hash
     * @return bool
     */
    public function needsRehash($hash) {
        // MD5 hash'leri her zaman güncellenmeli
        if (strlen($hash) === 32) {
            return TRUE;
        }
        
        // Modern hash kontrolü
        if (defined('PASSWORD_ARGON2ID')) {
            return password_needs_rehash($hash, PASSWORD_ARGON2ID, [
                'memory_cost' => $this->memory_cost,
                'time_cost' => $this->time_cost,
                'threads' => $this->threads
            ]);
        }
        
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Şifre güvenlik seviyesi kontrolü
     * 
     * @param string $password Plain text şifre
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateStrength($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'Şifre en az 8 karakter olmalıdır.';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Şifre en az 1 küçük harf içermelidir.';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Şifre en az 1 büyük harf içermelidir.';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Şifre en az 1 rakam içermelidir.';
        }
        
        // Yaygın şifre kontrolü
        $common_passwords = ['123456', 'password', 'qwerty', '123456789', 'abc123'];
        if (in_array(strtolower($password), $common_passwords)) {
            $errors[] = 'Bu şifre çok yaygın, lütfen daha güçlü bir şifre seçin.';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Güvenli rastgele şifre üret
     * 
     * @param int $length Şifre uzunluğu
     * @return string
     */
    public function generateSecure($length = 12) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        $max = strlen($chars) - 1;
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $max)];
        }
        
        return $password;
    }
}
