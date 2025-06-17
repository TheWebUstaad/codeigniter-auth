-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default roles
INSERT INTO `roles` (`role_name`, `description`) VALUES
('Admin', 'Full access to all system features'),
('Editor', 'Can manage content but not users or system settings'),
('Author', 'Can create and manage their own content only'),
('User', 'Basic user with limited access');

-- Create permissions table
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(50) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_name` (`permission_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default permissions
INSERT INTO `permissions` (`permission_name`, `description`) VALUES
('manage_users', 'Create, edit, and delete users'),
('manage_roles', 'Create, edit, and delete roles'),
('manage_content', 'Create, edit, and delete content'),
('view_reports', 'View system reports and analytics'),
('manage_settings', 'Modify system settings'),

-- Blog specific permissions
('create_posts', 'Create new blog posts'),
('edit_own_posts', 'Edit own blog posts'),
('edit_all_posts', 'Edit any blog post regardless of author'),
('delete_own_posts', 'Delete own blog posts'),
('delete_all_posts', 'Delete any blog post regardless of author'),
('publish_posts', 'Publish draft posts'),
('manage_categories', 'Create, edit, and delete blog categories'),
('manage_tags', 'Create, edit, and delete blog tags'),
('moderate_comments', 'Approve, edit, and delete comments'),
('feature_posts', 'Mark posts as featured');

-- Create role_permissions table for many-to-many relationship
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Assign default permissions to roles
-- Admin role gets all permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`) SELECT 1, id FROM `permissions`;

-- Editor role gets content management permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT 2, id FROM `permissions` 
WHERE `permission_name` IN (
    'manage_content', 
    'view_reports', 
    'create_posts', 
    'edit_own_posts', 
    'edit_all_posts', 
    'delete_own_posts', 
    'publish_posts', 
    'manage_categories', 
    'manage_tags', 
    'moderate_comments'
);

-- Author role gets limited content permissions
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT 3, id FROM `permissions` 
WHERE `permission_name` IN (
    'create_posts', 
    'edit_own_posts', 
    'delete_own_posts'
);

-- Modify users table to include role_id (if not already included)
-- Make sure to run this only if your users table exists but doesn't have role_id
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role_id` int(11) NOT NULL DEFAULT 4;
ALTER TABLE `users` ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

-- Update existing users to have the default 'User' role (if needed)
UPDATE `users` SET `role_id` = 4 WHERE `role_id` = 0 OR `role_id` IS NULL; 