<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Balance Model
 * Kullanici bakiye islemleri ve log yonetimi.
 */
class User_balance_model extends CI_Model {
    
    // Bakiye islem tipleri
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';
    const TYPE_PURCHASE = 'purchase';
    const TYPE_REFUND = 'refund';
    const TYPE_BONUS = 'bonus';
    const TYPE_REFERRAL = 'referral';
    
    public function __construct() {
        parent::__construct();
    }
    
    // ══════════════════════════════════════════
    // BAKIYE ISLEMLERI
    // ══════════════════════════════════════════
    
    public function getBalance($userId) {
        $user = $this->db->select('balance')->where('id', $userId)->get('users')->row();
        return $user ? (float)$user->balance : 0.00;
    }
    
    public function addBalance($userId, $amount, $type, $description = '', $relatedOrderId = NULL) {
        $amount = (float)$amount;
        if ($amount <= 0) {
            return FALSE;
        }
        
        $this->db->trans_start();
        
        // Bakiye guncelle
        $this->db->set('balance', 'balance + ' . $amount, FALSE);
        $this->db->where('id', $userId);
        $this->db->update('users');
        
        // Log kaydet
        $this->logTransaction($userId, $amount, $type, $description, $relatedOrderId);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function deductBalance($userId, $amount, $type, $description = '', $relatedOrderId = NULL) {
        $amount = (float)$amount;
        if ($amount <= 0) {
            return FALSE;
        }
        
        // Bakiye kontrolu
        if ($this->getBalance($userId) < $amount) {
            return FALSE;
        }
        
        $this->db->trans_start();
        
        // Bakiye guncelle
        $this->db->set('balance', 'balance - ' . $amount, FALSE);
        $this->db->where('id', $userId);
        $this->db->update('users');
        
        // Log kaydet (negatif tutar)
        $this->logTransaction($userId, -$amount, $type, $description, $relatedOrderId);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function transferBalance($fromUserId, $toUserId, $amount, $description = '') {
        $amount = (float)$amount;
        if ($amount <= 0) {
            return FALSE;
        }
        
        if ($this->getBalance($fromUserId) < $amount) {
            return FALSE;
        }
        
        $this->db->trans_start();
        
        $this->deductBalance($fromUserId, $amount, 'transfer_out', $description);
        $this->addBalance($toUserId, $amount, 'transfer_in', $description);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    // ══════════════════════════════════════════
    // LOG ISLEMLERI
    // ══════════════════════════════════════════
    
    private function logTransaction($userId, $amount, $type, $description, $relatedOrderId = NULL) {
        // Tablo varsa logla
        if (!$this->db->table_exists('balance_logs')) {
            return;
        }
        
        $this->db->insert('balance_logs', [
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $type,
            'description' => $description,
            'balance_after' => $this->getBalance($userId),
            'related_order_id' => $relatedOrderId,
            'ip_address' => $this->input->ip_address(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function getHistory($userId, $limit = 50, $offset = 0) {
        if (!$this->db->table_exists('balance_logs')) {
            return [];
        }
        
        return $this->db
            ->where('user_id', $userId)
            ->order_by('id', 'DESC')
            ->limit($limit, $offset)
            ->get('balance_logs')
            ->result();
    }
    
    public function getHistoryByType($userId, $type, $limit = 50) {
        if (!$this->db->table_exists('balance_logs')) {
            return [];
        }
        
        return $this->db
            ->where('user_id', $userId)
            ->where('type', $type)
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get('balance_logs')
            ->result();
    }
    
    // ══════════════════════════════════════════
    // ISTATISTIKLER
    // ══════════════════════════════════════════
    
    public function getTotalDeposits($userId) {
        if (!$this->db->table_exists('balance_logs')) {
            return 0;
        }
        
        $result = $this->db
            ->select_sum('amount')
            ->where('user_id', $userId)
            ->where('type', self::TYPE_DEPOSIT)
            ->where('amount >', 0)
            ->get('balance_logs')
            ->row();
        
        return $result->amount ? (float)$result->amount : 0.00;
    }
    
    public function getTotalSpent($userId) {
        if (!$this->db->table_exists('balance_logs')) {
            return 0;
        }
        
        $result = $this->db
            ->select('SUM(ABS(amount)) as total', FALSE)
            ->where('user_id', $userId)
            ->where('type', self::TYPE_PURCHASE)
            ->get('balance_logs')
            ->row();
        
        return $result->total ? (float)$result->total : 0.00;
    }
    
    public function getMonthlyStats($userId, $months = 6) {
        if (!$this->db->table_exists('balance_logs')) {
            return [];
        }
        
        $startDate = date('Y-m-d', strtotime("-{$months} months"));
        
        return $this->db
            ->select("DATE_FORMAT(created_at, '%Y-%m') as month, type, SUM(amount) as total", FALSE)
            ->where('user_id', $userId)
            ->where('created_at >=', $startDate)
            ->group_by(['month', 'type'])
            ->order_by('month', 'ASC')
            ->get('balance_logs')
            ->result();
    }
}
