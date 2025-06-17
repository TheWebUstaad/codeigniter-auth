<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;


$route['default_controller'] = 'Auth'; // Or 'Dashboard' if logged in
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Custom routes for authentication
$route['login'] = 'Auth/login';
$route['logout'] = 'Auth/logout';
$route['register'] = 'Auth/register'; // If you allow user registration

// Blog routes
$route['blog'] = 'Blog/index';
$route['blog/page/(:num)'] = 'Blog/index/$1';
$route['blog/view/(:any)'] = 'Blog/view/$1';
$route['blog/category/(:any)'] = 'Blog/category/$1';
$route['blog/category/(:any)/page/(:num)'] = 'Blog/category/$1/$2';
$route['blog/tag/(:any)'] = 'Blog/tag/$1';
$route['blog/tag/(:any)/page/(:num)'] = 'Blog/tag/$1/$2';
$route['blog/search'] = 'Blog/search';

// Admin Blog routes
$route['admin/blog'] = 'Admin_Blog/posts';
$route['admin/blog/posts'] = 'Admin_Blog/posts';
$route['admin/blog/posts/(:num)'] = 'Admin_Blog/posts/$1';
$route['admin/blog/create'] = 'Admin_Blog/create_post';
$route['admin/blog/edit/(:num)'] = 'Admin_Blog/edit_post/$1';
$route['admin/blog/delete/(:num)'] = 'Admin_Blog/delete_post/$1';
$route['admin/blog/categories'] = 'Admin_Blog/categories';
$route['admin/blog/categories/create'] = 'Admin_Blog/create_category';
$route['admin/blog/categories/edit/(:num)'] = 'Admin_Blog/edit_category/$1';
$route['admin/blog/categories/delete/(:num)'] = 'Admin_Blog/delete_category/$1';
$route['admin/blog/tags'] = 'Admin_Blog/tags';
$route['admin/blog/tags/create'] = 'Admin_Blog/create_tag';
$route['admin/blog/tags/edit/(:num)'] = 'Admin_Blog/edit_tag/$1';
$route['admin/blog/tags/delete/(:num)'] = 'Admin_Blog/delete_tag/$1';
