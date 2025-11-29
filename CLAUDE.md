# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**EPİNOM** - Turkish e-commerce platform for digital goods (e-pins, game credits, game money). Built with CodeIgniter 3.x framework.

- **Domain**: epinom.net
- **Language**: Turkish (TR)
- **Environment**: Production

## 🚨 KRİTİK KURALLAR (MUTLAKA UYULMALI)

### 1. YAPI UYUMLULUGU
- **Mevcut yapiyi ASLA bozma** - Tum degisiklikler mevcut sistemle uyumlu olmali
- **Geriye donuk uyumluluk** - Eski kodlar calismaya devam etmeli
- **Kademeli gecis** - Yeni ozellikler eskilerle paralel calismali

### 2. DOSYA ISLEMLERI
- **SADECE /var/www/vhosts/epinom.net/httpdocs dizininde calis**
- Bu dizin disinda HICBIR islem yapma
- Sistem dosyalarina dokunma

### 3. KOD STANDARTLARI
- CodeIgniter 3.x yapisina uy
- Mevcut naming convention kullan
- Turkce URL yapisini koru
- Mevcut helper ve library formatlarini takip et

### 4. VERITABANI
- Mevcut tablolari silme veya yapisini bozma
- Yeni alanlar eklerken NULL veya DEFAULT deger kullan
- Foreign key eklerken mevcut veriyi kontrol et

### 5. TEST
- Degisiklik sonrasi PHP syntax kontrolu yap
- HTTP 200 dondugunu dogrula
- Mevcut route larin calistigini kontrol et

## Architecture

### Directory Structure

```
httpdocs/
├── application/          # Main CI application
│   ├── controllers/      # Request handlers
│   ├── models/           # Database models
│   ├── views/            # PHP templates
│   ├── helpers/          # Custom helper functions
│   ├── libraries/        # Custom libraries
│   ├── config/           # Configuration files
│   ├── cache/sessions/   # Session storage
│   └── logs/             # Application logs
├── system/               # CodeIgniter core (DO NOT MODIFY)
├── assets/               # Frontend assets (CSS, JS, images)
├── public/               # Public uploads (categories, products)
├── 262234_admin/         # Admin panel (separate CI instance)
├── ep_lisans/            # License management system
└── email_templates/      # Email template files
```

### Key Controllers

| Controller | Purpose | Routes |
|------------|---------|--------|
| Main | Homepage | / |
| User_controller | Auth, profile, orders | /uye/* |
| Auth_controller | Yeni guvenli auth | /auth/* |
| Profile_controller | Yeni profil yonetimi | /profil/* |
| Games | Game categories & products | /oyunlar/*, /tum-oyunlar |
| GameMoney | Game currency trading | /oyun-parasi/* |
| Cart | Shopping cart | /sepetim, /siparis-onayi |
| PaymentMethods | Payment processing | /bakiye-yukle, /odeme-yontemleri |
| Callback | Payment gateway callbacks | /api/pay/* |
| Api | AJAX endpoints | /api/* |
| HelpDesk | Support tickets | /destek/* |

### Payment Integrations

Callback controller handles multiple payment gateways:
- iyzico, PayTR, Shopier, GPay
- Payreks, PayBrothers, PayByMe
- Paymes, Paymax, Pinabi

### Helper Functions

Auto-loaded helpers (application/helpers/):

| Helper | Purpose |
|--------|---------|
| tools_helper | getActiveUser(), websiteStatus(), permalink() |
| user_helper | Yeni auth sistemi helper fonksiyonlari |
| payment_helper | Payment processing functions |
| product_helper | Product price calculations |
| frontend_helper | View helpers |
| email_helper | Email sending |
| sms_helper | SMS notifications |

### Models

| Model | Purpose |
|-------|---------|
| Users | Eski kullanici modeli |
| User_model | Yeni genisletilmis kullanici modeli |
| User_balance_model | Bakiye islemleri ve log |
| Categories, Products_model | Urun yonetimi |
| Orders_model | Siparis yonetimi |
| Helpdesk_model | Destek sistemi |

### Custom Libraries

| Library | Purpose |
|---------|---------|
| User/Password_handler | Argon2ID sifreleme (MD5 yerine) |
| User/User_authentication | Session ve rate limiting |
| Custom_cart | Extended cart functionality |
| Paymax_light_api | Paymax integration |

## Database

- **Driver**: mysqli
- **Charset**: utf8mb4
- **Collation**: utf8mb4_general_ci
- **Config**: application/config/database.php

Key tables: users, products, categories, orders, config, balance_logs, login_logs

## Configuration Files

| File | Purpose |
|------|---------|
| config/config.php | Base URL, sessions, CSRF, cookies |
| config/database.php | Database credentials |
| config/routes.php | URL routing (Turkish URLs) |
| config/autoload.php | Auto-loaded resources |
| .htaccess | Apache rewrite rules, HTTPS redirect |

## Development Commands

### View Logs
```bash
tail -f application/logs/log-$(date +%Y-%m-%d).php
```

### Clear Session Cache
```bash
rm -rf application/cache/sessions/*
```

### Check File Permissions
```bash
chown -R epinom.net_t210ezrihns:psacln application/
chmod -R 755 application/
chmod -R 777 application/cache/
chmod -R 777 application/logs/
```

### PHP Syntax Check
```bash
/opt/plesk/php/8.1/bin/php -l dosya.php
```

## Important Notes

### Security Configuration
- CSRF protection: ENABLED
- XSS filtering: Use `->input->post('field', TRUE)`
- Environment: Set via .htaccess `SetEnv CI_ENV production`
- Password: Argon2ID (yeni), MD5 geriye uyumlu

### Session Handling
- Driver: files
- Path: application/cache/sessions/
- Cookie: epindenizi_app_session

### URL Structure
All user-facing URLs are in Turkish:
- /uye/giris-yap (login - eski)
- /auth/giris (login - yeni)
- /uye/kayit-ol (register - eski)
- /auth/kayit (register - yeni)
- /sepetim (cart)
- /oyunlar (games)

### Admin Panel
Separate CodeIgniter instance at /262234_admin/
Has its own application/, system/, and assets/ directories.

## Recent Updates

### Kullanici Modulu Guncellemesi (2024-11)
- MD5 -> Argon2ID sifreleme gecisi
- Rate limiting (5 deneme / 15dk kilit)
- Session hijacking korumasi
- balance_logs ve login_logs tablolari
- Yeni Auth_controller ve Profile_controller

## Code Style

- Controllers extend CI_Controller
- Models extend CI_Model
- Use `->input->post('field', TRUE)` for XSS filtering
- Use Query Builder for database operations
- Turkish variable names in views, English in backend
