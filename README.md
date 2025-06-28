

---

````markdown
# DAS - Doctor Appointment System

## 🛠️ Setup Instructions

Follow these steps to set up the project on your local system:

### Step 1: Clone the repository

```bash
git clone https://github.com/angryadarsh/DAS.git
````

### Step 2: Navigate to the project directory

```bash
cd DAS
```

### Step 3: Install dependencies using Composer

```bash
composer install
```

### Step 4: Initialize the Yii2 application

```bash
php init
```

Choose **development** or **production** environment when prompted.

### Step 5: Import the database

Inside the project directory, you’ll find a `.sql` file (database dump). Import it into your MySQL server using:

```bash
mysql -u root -p das < path/to/dump.sql
```

> Replace `path/to/dump.sql` with the actual path to your SQL file.

### Step 6: Configure database connection

Edit the file `common/config/main-local.php`:

```php
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=das',
    'username' => 'root',
    'password' => 'your-password-here',
    'charset' => 'utf8',
],
```

### Step 7: Default login credentials

#### 🔐 Admin

* **Username:** `Adarsh`
* **Password:** `adar9867`

#### 👨‍⚕️ Doctor

* **Username:** `doctor`
* **Password:** `adar9867`

#### 🧑‍⚕️ Patient

* **Username:** `patient`
* **Password:** `adar9867`

---

---

```markdown
## 🌐 Localhost Virtual Host Setup

To run the **frontend** and **backend** on custom domains like `dasuser.com` and `dasadmin.com`, follow these steps:

### Step 8: Update your `hosts` file

Add the following lines to your system's `hosts` file:

```

127.0.0.1 dasuser.com
127.0.0.1 dasadmin.com

````

> 📌 **Linux/Mac:** Edit `/etc/hosts`  
> 📌 **Windows:** Edit `C:\Windows\System32\drivers\etc\hosts` as Administrator

---

### Step 9: Configure Apache virtual hosts

Edit your Apache configuration file (commonly located at `/etc/apache2/sites-available/000-default.conf` or create a new file like `/etc/apache2/sites-available/das.conf`):

```apacheconf
<VirtualHost *:80>
    ServerName dasuser.com
    DocumentRoot "/path/to/DAS/frontend/web"
    <Directory "path/to/DAS/frontend/web">
        Options FollowSymLinks
        AllowOverride All
        DirectoryIndex index.php
        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . index.php
        Require all granted
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName dasadmin.com
    DocumentRoot "path/to/DAS/backend/web"
    <Directory "path/to/DAS/backend/web">
        Options FollowSymLinks
        AllowOverride All
        DirectoryIndex index.php
        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . index.php
        Require all granted
    </Directory>
</VirtualHost>
````

### Step 10: Enable Apache rewrite module and restart Apache

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

Now you can access the application using:

* **Frontend (Patient/Doctor View):** [http://dasuser.com](http://dasuser.com)
* **Backend (Admin Panel):** [http://dasadmin.com](http://dasadmin.com)

> ⚠️ Make sure your web root paths in Apache match your local file system paths.


