-- ═══════════════════════════════════════════════════════════════
-- EPINOM.NET USER MODULE MIGRATION
-- Guvenlik ve performans iyilestirmeleri icin veritabani guncellemeleri
-- ═══════════════════════════════════════════════════════════════

-- 1. USERS TABLOSU GUNCELLEMELERI
-- ═══════════════════════════════════════════════════════════════

-- Yeni guvenlik alanlari ekle
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS password_changed_at DATETIME NULL AFTER password,
    ADD COLUMN IF NOT EXISTS last_login_at DATETIME NULL,
    ADD COLUMN IF NOT EXISTS last_login_ip VARCHAR(45) NULL,
    ADD COLUMN IF NOT EXISTS failed_login_attempts INT DEFAULT 0,
    ADD COLUMN IF NOT EXISTS locked_until DATETIME NULL,
    ADD COLUMN IF NOT EXISTS reset_token VARCHAR(64) NULL,
    ADD COLUMN IF NOT EXISTS reset_token_expires DATETIME NULL,
    ADD COLUMN IF NOT EXISTS two_factor_enabled TINYINT(1) DEFAULT 0,
    ADD COLUMN IF NOT EXISTS two_factor_secret VARCHAR(32) NULL,
    ADD COLUMN IF NOT EXISTS created_at DATETIME NULL,
    ADD COLUMN IF NOT EXISTS updated_at DATETIME NULL,
    ADD COLUMN IF NOT EXISTS activated_at DATETIME NULL;

-- Indexler ekle (performans icin)
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_user_hash ON users(user_hash);
CREATE INDEX IF NOT EXISTS idx_users_activation ON users(activation_status);
CREATE INDEX IF NOT EXISTS idx_users_reset_token ON users(reset_token);

-- 2. BAKIYE LOG TABLOSU
-- ═══════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS balance_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    type VARCHAR(30) NOT NULL COMMENT 'deposit, withdraw, purchase, refund, bonus, referral, transfer_in, transfer_out',
    description VARCHAR(500) NULL,
    balance_after DECIMAL(12,2) NOT NULL,
    related_order_id INT NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_balance_user_id (user_id),
    INDEX idx_balance_type (type),
    INDEX idx_balance_created (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. LOGIN LOG TABLOSU
-- ═══════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    email VARCHAR(255) NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(500) NULL,
    status ENUM('success', 'failed', 'blocked') NOT NULL,
    failure_reason VARCHAR(100) NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_login_user_id (user_id),
    INDEX idx_login_ip (ip_address),
    INDEX idx_login_created (created_at),
    INDEX idx_login_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. MEVCUT VERILER ICIN GUNCELLEMELER
-- ═══════════════════════════════════════════════════════════════

-- created_at olmayan kullanicilara tarih ekle
UPDATE users SET created_at = NOW() WHERE created_at IS NULL;

-- ═══════════════════════════════════════════════════════════════
-- MIGRATION TAMAMLANDI
-- ═══════════════════════════════════════════════════════════════
