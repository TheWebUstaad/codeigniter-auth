# CodeIgniter User Authentication & Blog System

A robust and secure user authentication and blog management system built with CodeIgniter 3, featuring role-based access control, blog management, and a modern UI.

![PHP Version](https://img.shields.io/badge/PHP->=7.4-blue.svg)
![CodeIgniter Version](https://img.shields.io/badge/CodeIgniter-3.1.11-red.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [File Structure](#file-structure)
- [Database Schema](#database-schema)
- [Role-Based Access Control](#role-based-access-control)
- [API Documentation](#api-documentation)
- [Configuration](#configuration)
- [Security Features](#security-features)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 🔐 Authentication & Authorization
- Secure user registration and login
- Role-based access control (Admin, Editor, User)
- Permission-based feature access
- Password hashing using bcrypt
- Session management
- Remember me functionality

### 👥 User Management
- User profile management
- Role assignment
- User status management (Active/Inactive)
- Profile picture upload
- Password reset functionality

### 📝 Blog Management
- Create, edit, and delete blog posts
- Category management
- Tag management
- Rich text editor
- Image upload for posts
- Post status (Published/Draft)
- Search functionality
- Category and tag filtering

### 🎨 UI/UX Features
- Modern and responsive design
- Bootstrap 5 integration
- Font Awesome icons
- Clean and intuitive interface
- Mobile-friendly layout
- Real-time form validation
- Toast notifications

## 💻 System Requirements

| Requirement | Version |
|------------|---------|
| PHP        | >= 7.4  |
| MySQL      | >= 5.7  |
| Apache     | >= 2.4  |
| CodeIgniter| 3.1.11  |

## 🚀 Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/project-auth.git
```

2. Configure your database in `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'project_auth',
    // ... other settings
);
```

3. Import the database schema:
```bash
mysql -u your_username -p project_auth < complete_blog_setup.sql
```

4. Configure base URL in `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/project-auth/';
```

5. Set write permissions for required directories:
```bash
chmod 755 application/cache
chmod 755 application/logs
chmod 755 uploads
```

## 📁 File Structure

```
project-auth/
├── application/
│   ├── config/
│   │   ├── autoload.php
│   │   ├── config.php
│   │   ├── database.php
│   │   └── routes.php
│   ├── controllers/
│   │   ├── Admin.php
│   │   ├── Admin_Blog.php
│   │   ├── Auth.php
│   │   ├── Blog.php
│   │   ├── Dashboard.php
│   │   └── User.php
│   ├── models/
│   │   ├── Category_model.php
│   │   ├── Post_model.php
│   │   ├── Role_model.php
│   │   ├── Tag_model.php
│   │   └── User_model.php
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── blog/
│       ├── dashboard/
│       └── templates/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── uploads/
│   └── blog/
├── system/
└── index.php
```

## 🗄️ Database Schema

### Users Table
| Column     | Type         | Description           |
|------------|-------------|-----------------------|
| id         | INT         | Primary Key          |
| username   | VARCHAR(50) | Unique username      |
| email      | VARCHAR(100)| Unique email address |
| password   | VARCHAR(255)| Hashed password      |
| role_id    | INT         | Foreign Key to roles |
| active     | TINYINT     | Account status       |
| created_at | TIMESTAMP   | Creation timestamp   |
| updated_at | TIMESTAMP   | Update timestamp     |

### Roles Table
| Column     | Type         | Description         |
|------------|-------------|---------------------|
| id         | INT         | Primary Key        |
| role_name  | VARCHAR(50) | Role name          |
| created_at | TIMESTAMP   | Creation timestamp |

### Posts Table
| Column      | Type         | Description          |
|-------------|-------------|---------------------|
| id          | INT         | Primary Key         |
| title       | VARCHAR(255)| Post title          |
| slug        | VARCHAR(255)| URL-friendly title  |
| content     | TEXT        | Post content        |
| user_id     | INT         | Author ID           |
| category_id | INT         | Category ID         |
| status      | VARCHAR(20) | Published/Draft     |
| created_at  | TIMESTAMP   | Creation timestamp  |
| updated_at  | TIMESTAMP   | Update timestamp    |

## 🔒 Role-Based Access Control

### Available Roles
| Role    | Description                                   | Permissions                    |
|---------|-----------------------------------------------|--------------------------------|
| Admin   | Full system access                            | All permissions                |
| Editor  | Content management access                      | Manage posts, categories, tags |
| User    | Basic access                                  | Read posts, manage profile     |

### Permission Matrix
| Permission        | Admin | Editor | User |
|------------------|-------|---------|------|
| manage_users     | ✅    | ❌     | ❌   |
| manage_roles     | ✅    | ❌     | ❌   |
| manage_posts     | ✅    | ✅     | ❌   |
| manage_categories| ✅    | ✅     | ❌   |
| manage_tags      | ✅    | ✅     | ❌   |
| create_posts     | ✅    | ✅     | ❌   |
| read_posts      | ✅    | ✅     | ✅   |
| manage_profile   | ✅    | ✅     | ✅   |

## ⚙️ Configuration

### Email Configuration
Configure email settings in `application/config/email.php`:
```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'your_smtp_host';
$config['smtp_user'] = 'your_email@domain.com';
$config['smtp_pass'] = 'your_password';
$config['smtp_port'] = 587;
```

### Upload Configuration
Configure upload settings in `application/config/upload.php`:
```php
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$config['max_size'] = 2048; // 2MB
```

## 🔐 Security Features

- CSRF Protection
- XSS Filtering
- SQL Injection Prevention
- Password Hashing
- Session Security
- Form Validation
- Input Sanitization
- Secure File Upload
- Role-Based Access Control
- Error Logging

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Your Name** - *Initial work* - [YourGitHub](https://github.com/thewebustaad)

## 🙏 Acknowledgments

- CodeIgniter Team
- Bootstrap Team
- Font Awesome
- All contributors

## 📞 Support

For support, email m.abdullah.fuf@gmail.com or create an issue in the GitHub repository.
