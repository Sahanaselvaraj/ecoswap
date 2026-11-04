ECOSWAP - SMART WASTE REUSE AND COMMUNITY EXCHANGE PLATFORM
===========================================================

REQUIREMENTS
- Windows / Linux / macOS
- XAMPP (Apache + MySQL + PHP)
- VS Code or another code editor
- Web browser

HOW TO RUN USING XAMPP
1. Download and install XAMPP.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Copy the complete EcoSwap_Project folder into:
   C:\xampp\htdocs\
4. Open this address in your browser:
   http://localhost/phpmyadmin
5. Click Import.
6. Choose database.sql from EcoSwap_Project and click Import / Go.
   The SQL file creates the ecoswap database and required tables.
7. Check includes/db.php. Default XAMPP settings are:
   host = localhost
   database = ecoswap
   username = root
   password = (blank)
   If your MySQL password is different, update it there.
8. Open:
   http://localhost/EcoSwap_Project/

HOW TO USE
1. Register a new account.
2. Login.
3. Select Add Item and submit an item in usable condition.
4. Open Explore to search items.
5. Login as a different user and click Express Interest.
6. The item owner can view interest details under My Listings.
7. The owner can change the listing status to Claimed.
8. Impact shows community totals.

PROJECT FEATURES
- Responsive green-themed home page
- User registration and login with password hashing
- PHP + MySQL database connection using PDO
- Add and search listings
- Category filtering
- Express interest in another user's item
- My Listings with status management
- Interest received list
- Community impact dashboard
- Basic keyword safety check for prohibited hazardous items

SAFETY AND LIMITATIONS
- This is an academic/demo project, not a fully audited production marketplace.
- Do not list damaged batteries, hazardous chemicals, weapons, medicines,
  explosives, or illegal/dangerous goods.
- The keyword check is only a basic demonstration and cannot identify every risk.
- Meet in a safe public place and do not publish private contact details.
- Admin moderation, image upload, chat, email notifications, CSRF protection,
  and advanced reporting are not included in this beginner version.
- For public hosting, configure the host's MySQL database credentials and import
  database.sql using the hosting control panel. Never upload local root credentials.
