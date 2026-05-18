## Task 1 Setup (22-46960-1)

1. Import database:
   ```bash
   mysql -u root -p < db/travel_guide.sql
   mysql -u root -p < db/task1_remember_token.sql
   ```
2. Copy `config/config.example.php` to `config/config.php` and set your local `base_url`.
3. Open: `http://localhost/Travel-Guide/public/home`

Features: registration, login, remember me, profile, home page, wishlist (AJAX).
