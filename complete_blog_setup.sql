-- Drop tables if they exist (in reverse order of dependencies)
DROP TABLE IF EXISTS `post_tags`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

-- Create roles table
CREATE TABLE `roles` (
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
CREATE TABLE `permissions` (
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

-- Create users table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 4,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_role` (`role_id`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert dummy users (password is 'password' hashed)
INSERT INTO `users` (`username`, `email`, `password`, `role_id`) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('editor', 'editor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),
('author', 'author@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3),
('user', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4);

-- Create role_permissions table for many-to-many relationship
CREATE TABLE `role_permissions` (
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

-- Create categories table
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert dummy categories
INSERT INTO `categories` (`name`, `slug`) VALUES
('Technology', 'technology'),
('Business', 'business'),
('Health', 'health'),
('Lifestyle', 'lifestyle'),
('Travel', 'travel'),
('Food', 'food'),
('Science', 'science'),
('Sports', 'sports');

-- Create posts table
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `excerpt` text,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert dummy posts
INSERT INTO `posts` (`user_id`, `category_id`, `title`, `slug`, `content`, `excerpt`, `status`, `created_at`) VALUES
(1, 1, 'Getting Started with CodeIgniter', 'getting-started-with-codeigniter', '<p>CodeIgniter is a powerful PHP framework with a very small footprint, built for developers who need a simple and elegant toolkit to create full-featured web applications.</p><p>In this tutorial, we will explore the basics of CodeIgniter and how to set up your first project.</p><h2>What is CodeIgniter?</h2><p>CodeIgniter is an Application Development Framework - a toolkit - for people who build web sites using PHP. Its goal is to enable you to develop projects much faster than you could if you were writing code from scratch, by providing a rich set of libraries for commonly needed tasks, as well as a simple interface and logical structure to access these libraries.</p><p>CodeIgniter lets you creatively focus on your project by minimizing the amount of code needed for a given task.</p>', 'Learn the basics of CodeIgniter and how to set up your first project with this powerful PHP framework.', 'published', '2023-01-15 10:00:00'),
(1, 2, 'Building a Business Website with PHP', 'building-business-website-php', '<p>Creating a business website using PHP can be a cost-effective solution for small to medium enterprises. In this article, we will discuss the steps to build a professional business website using PHP.</p><p>A good business website should be fast, secure, and easy to navigate. PHP, being a server-side scripting language, offers these features and more.</p><h2>Planning Your Business Website</h2><p>Before diving into coding, it\'s essential to plan your website structure. Determine the pages you need, such as Home, About Us, Services, Products, Contact, etc.</p><p>Next, design a database schema to store your business data, including products, services, customer inquiries, and more.</p>', 'Learn how to create a professional business website using PHP that is fast, secure, and easy to navigate.', 'published', '2023-02-10 14:30:00'),
(2, 3, 'Healthy Habits for Developers', 'healthy-habits-developers', '<p>As developers, we often spend long hours sitting in front of computers, which can lead to various health issues. In this post, we\'ll explore some healthy habits that developers can adopt to maintain their well-being.</p><h2>Regular Exercise</h2><p>Exercise is crucial for maintaining physical health. Even a 30-minute walk daily can make a significant difference. Consider standing desks or desk exercises if you can\'t leave your workspace.</p><h2>Eye Care</h2><p>Follow the 20-20-20 rule: every 20 minutes, look at something 20 feet away for 20 seconds. This helps reduce eye strain caused by staring at screens for extended periods.</p>', 'Discover healthy habits for developers to maintain physical and mental well-being while working long hours on computers.', 'published', '2023-03-05 09:15:00'),
(2, 4, 'Minimalist Living for Tech Professionals', 'minimalist-living-tech-professionals', '<p>In a world filled with gadgets and tech accessories, adopting a minimalist lifestyle can be challenging for tech professionals. However, minimalism can lead to reduced stress and increased productivity.</p><p>This article explores how tech professionals can embrace minimalism without compromising their professional needs.</p><h2>Digital Minimalism</h2><p>Start by decluttering your digital space. Uninstall unused apps, organize your files, and maintain a clean desktop. Use cloud storage solutions to reduce local storage needs.</p><p>Consider using a single device for multiple purposes instead of having separate devices for each function.</p>', 'Explore how tech professionals can embrace minimalism for reduced stress and increased productivity.', 'published', '2023-03-20 11:45:00'),
(3, 5, 'Hidden Gems: Unexplored Travel Destinations', 'hidden-gems-unexplored-travel-destinations', '<p>While popular tourist destinations offer fantastic experiences, there\'s something special about discovering places that aren\'t on every traveler\'s radar. This post highlights some unexplored destinations that offer unique experiences.</p><h2>Coastal Towns of Albania</h2><p>Albania\'s coastline offers stunning beaches and crystal-clear waters without the crowds found in neighboring Greece or Italy. The towns of Ksamil and Dhermi are particularly beautiful and affordable.</p><h2>Rural Japan</h2><p>Beyond Tokyo and Kyoto, rural Japan offers a glimpse into traditional Japanese life. Regions like Tohoku and Shikoku have beautiful landscapes, historic temples, and authentic cultural experiences.</p>', 'Discover unexplored travel destinations that offer unique experiences away from typical tourist crowds.', 'published', '2023-04-12 16:20:00'),
(3, 6, 'Fusion Cooking: East Meets West', 'fusion-cooking-east-meets-west', '<p>Fusion cooking combines elements from different culinary traditions to create innovative and exciting dishes. This article explores the art of combining Eastern and Western cooking techniques and flavors.</p><h2>Understanding Flavor Profiles</h2><p>Before experimenting with fusion cooking, it\'s essential to understand the basic flavor profiles of different cuisines. Asian cuisines often balance sweet, sour, salty, and spicy elements, while Western cuisines might focus on rich, savory flavors.</p><p>Start by identifying complementary flavors from different traditions and experiment with combining them in familiar dishes.</p>', 'Learn the art of fusion cooking by combining Eastern and Western culinary traditions to create innovative dishes.', 'draft', '2023-05-08 13:10:00'),
(1, 7, 'The Future of Artificial Intelligence', 'future-artificial-intelligence', '<p>Artificial Intelligence (AI) is rapidly evolving and reshaping various industries. This article examines current trends and future possibilities in AI development.</p><h2>Current State of AI</h2><p>Today\'s AI systems excel at pattern recognition, natural language processing, and decision-making in specific domains. Machine learning models, particularly deep learning networks, have achieved remarkable results in image recognition, language translation, and game playing.</p><h2>Future Directions</h2><p>The future of AI likely involves more general-purpose systems that can transfer learning across domains. Researchers are working on making AI more explainable, ethical, and energy-efficient.</p>', 'Explore current trends and future possibilities in artificial intelligence development across various industries.', 'published', '2023-06-22 08:45:00'),
(2, 8, 'The Psychology of Sports Performance', 'psychology-sports-performance', '<p>Athletic performance isn\'t just about physical ability; mental strength plays a crucial role. This article delves into the psychological aspects of sports performance.</p><h2>Mindset and Performance</h2><p>A growth mindset, as opposed to a fixed mindset, can significantly impact an athlete\'s development. Athletes who believe their abilities can be developed through dedication and hard work tend to achieve more than those who believe their talents are innate gifts.</p><h2>Visualization Techniques</h2><p>Many elite athletes use visualization techniques to enhance performance. By mentally rehearsing movements and scenarios, athletes can improve their actual performance when faced with those situations.</p>', 'Understand the psychological aspects of sports performance and how mental strength contributes to athletic success.', 'draft', '2023-07-14 15:30:00'),
(4, 1, 'Introduction to Web Security', 'introduction-web-security', '<p>Web security is a critical aspect of web development that is often overlooked. This introductory guide covers the basics of web security and common vulnerabilities.</p><h2>Common Web Vulnerabilities</h2><p>Several types of vulnerabilities can affect web applications:</p><ul><li>Cross-Site Scripting (XSS): Occurs when an attacker injects malicious scripts into content from trusted websites.</li><li>SQL Injection: Happens when an attacker inserts malicious SQL code into a query.</li><li>Cross-Site Request Forgery (CSRF): Forces authenticated users to execute unwanted actions on a web application.</li></ul>', 'Learn the basics of web security and how to protect your applications from common vulnerabilities.', 'published', '2023-08-05 10:20:00'),
(4, 4, 'Digital Detox: Reclaiming Your Time and Attention', 'digital-detox-reclaiming-time-attention', '<p>In our hyper-connected world, taking a break from digital devices can have significant benefits for mental health and productivity. This article explores the concept of digital detox and provides practical tips for implementation.</p><h2>Signs You Need a Digital Detox</h2><p>Consider a digital detox if you experience any of these signs:</p><ul><li>Checking your phone first thing in the morning and last thing at night</li><li>Feeling anxious when you\'re away from your phone</li><li>Difficulty concentrating on tasks without digital distractions</li><li>Decreased face-to-face social interactions</li></ul>', 'Discover the benefits of taking breaks from digital devices and practical tips for implementing a digital detox.', 'draft', '2023-09-18 14:15:00');

-- Create tags table
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert dummy tags
INSERT INTO `tags` (`name`, `slug`) VALUES
('PHP', 'php'),
('JavaScript', 'javascript'),
('CSS', 'css'),
('HTML', 'html'),
('MySQL', 'mysql'),
('CodeIgniter', 'codeigniter'),
('Laravel', 'laravel'),
('React', 'react'),
('Vue.js', 'vuejs'),
('Node.js', 'nodejs'),
('Python', 'python'),
('Machine Learning', 'machine-learning'),
('AI', 'ai'),
('Web Development', 'web-development'),
('Mobile Development', 'mobile-development'),
('DevOps', 'devops'),
('Cloud Computing', 'cloud-computing'),
('Security', 'security'),
('UX/UI', 'ux-ui'),
('Responsive Design', 'responsive-design');

-- Create post_tags table for many-to-many relationship
CREATE TABLE `post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert dummy post_tags relationships
INSERT INTO `post_tags` (`post_id`, `tag_id`) VALUES
(1, 1), (1, 6), (1, 14), -- CodeIgniter post: PHP, CodeIgniter, Web Development
(2, 1), (2, 14), (2, 19), -- Business Website: PHP, Web Development, UX/UI
(3, 16), (3, 18), -- Healthy Habits: DevOps, Security (loosely related)
(4, 19), (4, 20), -- Minimalist Living: UX/UI, Responsive Design (loosely related)
(5, 14), (5, 19), -- Travel: Web Development, UX/UI (loosely related)
(6, 14), (6, 19), -- Fusion Cooking: Web Development, UX/UI (loosely related)
(7, 12), (7, 13), (7, 11), -- AI: Machine Learning, AI, Python
(8, 14), (8, 19), -- Sports Psychology: Web Development, UX/UI (loosely related)
(9, 1), (9, 14), (9, 18), -- Web Security: PHP, Web Development, Security
(10, 14), (10, 19), (10, 20); -- Digital Detox: Web Development, UX/UI, Responsive Design 