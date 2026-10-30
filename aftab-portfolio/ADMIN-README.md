# Admin Dashboard setup

The admin dashboard is available at `/admin/login.php` after setup. It is private: it has no default account or password. The email address supplied during setup is your administrator login username.

1. Import `database-admin.sql` into the existing `aftab_portfolio` database. This is an additive migration; it only creates `admin_users` and does not alter contact messages.
2. From the project directory, create the first administrator in a terminal:

   ```powershell
   C:\xampp\php\php.exe admin\create-user.php your-admin-email@example.com
   ```

   Enter a unique password of at least 12 characters when prompted. Do not pass the password as a command-line argument. Once the first account is created, this setup script refuses to create further accounts.
3. Visit `http://localhost/aftab-portfolio/admin/login.php` and sign in.

## Shared-hosting first setup

If your host does not provide SSH/CLI, first select the portfolio database in phpMyAdmin and import `database-admin.sql`. Set a long, random temporary `ADMIN_SETUP_KEY` in `config/config.php`, upload the changed file, then visit `/admin/setup.php`. Enter that setup key, your administrator email, and a password of at least 12 characters. The setup route returns 404 after the first account is created. Immediately set `ADMIN_SETUP_KEY` back to an empty string and upload `config/config.php` again.

For production, configure `PORTFOLIO_DB_HOST`, `PORTFOLIO_DB_NAME`, `PORTFOLIO_DB_USER`, and `PORTFOLIO_DB_PASS` in hosting environment settings rather than source files. Use HTTPS so the session cookie receives its `Secure` attribute automatically. Keep the `admin` directory deployed, but do not expose `create-user.php` through a CLI-enabled web process; it returns 404 for browser requests.

The dashboard never deletes contact messages. Message status changes require an authenticated session and CSRF token.
