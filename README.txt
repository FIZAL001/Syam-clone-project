SYAM WEB PANEL V2

PHP 8+.
Set environment variable SYAM_ADMIN_KEY on the server before using create/list endpoints.
The browser sends it as X-Admin-Key.

Endpoints:
POST /api/login
POST /api/create-account
GET  /api/list-accounts

Login accepts JSON or form fields username/password (also user/pass).
Password is stored as a PHP password hash.

IMPORTANT: The supplied APK currently contains https://syam.syamcloud.com and /api/login. This panel does NOT claim compatibility with that remote service. To make the APK use this backend, rebuild the APK from source and point its base URL to your own HTTPS domain, then match the exact login response fields used by your source.
