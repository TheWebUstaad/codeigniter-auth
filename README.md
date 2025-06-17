# User and Role Management System

This is a complete user authentication and authorization system built with CodeIgniter. It includes user management, role-based access control, and permissions management.

## Features

- User Authentication (Login, Registration, Logout)
- User Management (Create, Read, Update, Delete)
- Role Management (Create, Read, Update, Delete)
- Permission-Based Access Control
- Bootstrap UI

## Setup Instructions

### 1. Database Setup

1. Create a database for your application in MySQL
2. Configure your database connection in `application/config/database.php`
3. Run the SQL script to create the necessary tables:

```bash
# Import the SQL file
mysql -u your_username -p your_database < roles_tables.sql
```

### 2. Initial Admin User

After running the SQL script, you need to create an admin user:

1. Register a new user through the registration page
2. Manually update the user's role in the database:

```sql
UPDATE users SET role_id = 1 WHERE username = 'your_admin_username';
```

### 3. Login and Access Admin Panel

1. Login with your admin credentials
2. You'll now have access to the Admin Panel via the dashboard
3. From there, you can manage users and roles

## User Roles

The system comes with three default roles:

1. **Admin**: Full access to all system features
2. **Editor**: Can manage content but not users or system settings
3. **User**: Basic user with limited access

## Permissions

Default permissions include:

- manage_users: Create, edit, and delete users
- manage_roles: Create, edit, and delete roles
- manage_content: Create, edit, and delete content
- view_reports: View system reports and analytics
- manage_settings: Modify system settings

## Adding Custom Permissions

To add custom permissions:

1. Add them to the `permissions` table
2. Assign them to roles through the role management interface
3. Use the Authorization library to check for these permissions in your controllers

```php
// Example usage in a controller
public function some_action() {
    // Load the Authorization library
    $this->load->library('Authorization');
    
    // Check if user has the required permission
    if (!$this->authorization->has_permission('your_permission_name')) {
        show_error('You do not have permission to access this page.', 403);
    }
    
    // Continue with controller logic
}
```

## Customizing the UI

The user interface uses Bootstrap 4. You can customize the appearance by modifying the templates:

- Header: `application/views/templates/header.php`
- Footer: `application/views/templates/footer.php`
- CSS: Make sure to include your custom CSS in the assets folder

## Security Considerations

- Passwords are hashed using PHP's `password_hash()` function with BCRYPT algorithm
- Role-based access control is enforced at the controller level
- Input validation is performed using CodeIgniter's form validation library
