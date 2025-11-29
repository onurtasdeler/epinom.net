# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**EPİNOM** - Turkish e-commerce platform for digital goods (e-pins, game credits, game money). Built with CodeIgniter 3.x framework.

- **Domain**: epinom.net
- **Language**: Turkish (TR)
- **Environment**: Production

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
| payment_helper | Payment processing functions |
| product_helper | Product price calculations |
| frontend_helper | View helpers |
| email_helper | Email sending |
| sms_helper | SMS notifications |

### Models

Thin model layer - most use CI Query Builder directly:
- Users, Categories, Products_model
- Orders_model, Helpdesk_model
- Pages_model, News, Settings

### Custom Libraries

- Custom_cart - Extended cart functionality
- Paymax_light_api - Paymax integration
- Pinabi - Pinabi integration
- Streamlabs - Donation system
- Turkpin - Turkpin integration

## Database

- **Driver**: mysqli
- **Charset**: utf8mb4
- **Collation**: utf8mb4_general_ci
- **Config**: application/config/database.php

Key tables: users, products, categories, orders, config

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
tail -f application/logs/log-2025-11-29.php
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

## Important Notes

### Security Configuration
- CSRF protection: ENABLED
- XSS filtering: Use `->input->post('field', TRUE)`
- Environment: Set via .htaccess `SetEnv CI_ENV production`

### Session Handling
- Driver: files
- Path: application/cache/sessions/
- Cookie: epindenizi_app_session

### URL Structure
All user-facing URLs are in Turkish:
- /uye/giris-yap (login)
- /uye/kayit-ol (register)
- /sepetim (cart)
- /oyunlar (games)

### Admin Panel
Separate CodeIgniter instance at /262234_admin/
Has its own application/, system/, and assets/ directories.

## Known Issues to Address

1. **Password hashing**: Uses MD5 - should migrate to password_hash()
2. **Log accumulation**: 252MB in logs - implement rotation
3. **Cookie security**: cookie_secure should be TRUE for HTTPS

## Code Style

- Controllers extend CI_Controller
- Models extend CI_Model
- Use `->input->post('field', TRUE)` for XSS filtering
- Use Query Builder for database operations
- Turkish variable names in views, English in backend
