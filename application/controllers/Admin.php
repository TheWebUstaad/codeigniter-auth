<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/login');
        }
        
        // Load required models
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->library('form_validation');

        // Check if user has Admin role for dashboard access
        if ($this->router->fetch_method() === 'index' && $this->session->userdata('role_name') !== 'Admin') {
            redirect('Dashboard');
        }
        
        // For other admin functions, check for Admin role or manage_users permission
        if ($this->router->fetch_method() !== 'index' && 
            $this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_users', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
    }

    public function index() {
        // Ensure only admin can access analytics
        if ($this->session->userdata('role_name') !== 'Admin') {
            show_error('You do not have permission to access this page.', 403);
        }

        $data['title'] = 'Admin Panel';
        
        // Load required models
        $this->load->model('Post_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        
        // Basic counts
        $data['user_count'] = $this->User_model->count_users();
        $data['role_count'] = $this->Role_model->count_roles();
        $data['permission_count'] = $this->Role_model->count_permissions();
        
        // Blog statistics
        $data['post_count'] = $this->Post_model->count_posts(['status' => 'published']);
        $data['draft_count'] = $this->Post_model->count_posts(['status' => 'draft']);
        $data['category_count'] = $this->Category_model->count_categories();
        $data['tag_count'] = $this->Tag_model->count_tags();
        
        // Recent activity
        $data['recent_users'] = $this->User_model->get_recent_users(5);
        $data['recent_posts'] = $this->Post_model->get_recent_posts(5);
        
        // Growth statistics
        $data['user_growth'] = $this->User_model->get_user_growth();
        $data['post_growth'] = $this->Post_model->get_post_growth();
        $data['category_growth'] = $this->Category_model->get_category_growth();
        
        // Popular content
        $data['popular_categories'] = $this->Category_model->get_popular_categories(5);
        $data['popular_tags'] = $this->Tag_model->get_popular_tags(5);
        
        // System health
        $data['system_info'] = [
            'php_version' => PHP_VERSION,
            'codeigniter_version' => CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'database_driver' => $this->db->platform(),
            'database_version' => $this->db->version()
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    // User Management
    public function users() {
        $data['title'] = 'Manage Users';
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/list', $data);
        $this->load->view('templates/footer');
    }

    public function create_user() {
        $data['title'] = 'Create User';
        $data['roles'] = $this->Role_model->get_all_roles(); // Get all roles for dropdown

        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/users/create', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role_id' => $this->input->post('role_id')
            );
            if ($this->User_model->create_user($user_data)) {
                $this->session->set_flashdata('success', 'User created successfully.');
                redirect('Admin/users');
            } else {
                $this->session->set_flashdata('error', 'Error creating user.');
                $this->load->view('templates/header', $data);
                $this->load->view('admin/users/create', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit_user($id) {
        $data['title'] = 'Edit User';
        $data['user'] = $this->User_model->get_user_by_id($id);
        $data['roles'] = $this->Role_model->get_all_roles();

        if (empty($data['user'])) {
            show_404();
        }

        // Prevent changing own admin role
        if ($data['user']->id === $this->session->userdata('user_id') && 
            $data['user']->role_name === 'Admin' && 
            $this->input->post('role_id') && 
            $this->input->post('role_id') != $data['user']->role_id) {
            $this->session->set_flashdata('error', 'You cannot change your own admin role.');
            redirect('Admin/edit_user/' . $id);
            return;
        }

        // Check password if role is being changed
        if ($this->input->post('role_id') && $this->input->post('role_id') != $data['user']->role_id) {
            $admin_user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
            $confirm_password = $this->input->post('confirm_password');
            
            if (!$confirm_password || !password_verify($confirm_password, $admin_user->password)) {
                $this->session->set_flashdata('error', 'Invalid password. Role change not permitted.');
                redirect('Admin/edit_user/' . $id);
                return;
            }
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_unique_username['.$id.']');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_unique_email['.$id.']');
        $this->form_validation->set_rules('password', 'Password', 'permit_empty|min_length[6]'); // Allow empty for no change
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
        $this->form_validation->set_rules('active', 'Active', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/users/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'role_id' => $this->input->post('role_id'),
                'active' => $this->input->post('active')
            );
            if (!empty($this->input->post('password'))) {
                $user_data['password'] = $this->input->post('password');
            }

            if ($this->User_model->update_user($id, $user_data)) {
                $this->session->set_flashdata('success', 'User updated successfully.');
                redirect('Admin/users');
            } else {
                $this->session->set_flashdata('error', 'Error updating user.');
                $this->load->view('templates/header', $data);
                $this->load->view('admin/users/edit', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    // Custom validation callback for unique username during edit
    public function unique_username($username, $id) {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_username', 'The %s is already taken.');
            return FALSE;
        }
        return TRUE;
    }

    // Custom validation callback for unique email during edit
    public function unique_email($email, $id) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_email', 'The %s is already taken.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete_user($id) {
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting user.');
        }
        redirect('Admin/users');
    }

    public function view_user($id) {
        $data['title'] = 'View User';
        $data['user'] = $this->User_model->get_user_by_id($id);
        
        if (empty($data['user'])) {
            show_404();
        }

        // Get user permissions if available
        if ($this->db->table_exists('permissions') && $this->db->table_exists('role_permissions')) {
            $data['user_permissions'] = $this->User_model->get_user_permissions($id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/view', $data);
        $this->load->view('templates/footer');
    }

    // Role Management
    public function roles() {
        if ($this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_roles', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
        $data['title'] = 'Manage Roles';
        $data['roles'] = $this->Role_model->get_all_roles();
        $this->load->view('templates/header', $data);
        $this->load->view('admin/roles/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function create_role() {
        if ($this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_roles', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
        
        $data['title'] = 'Create Role';
        
        // If permissions system is used
        $data['permissions'] = $this->Role_model->get_all_permissions();
        
        $this->form_validation->set_rules('role_name', 'Role Name', 'required|trim|is_unique[roles.role_name]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/roles/create', $data);
            $this->load->view('templates/footer');
        } else {
            $role_data = array(
                'role_name' => $this->input->post('role_name'),
                'description' => $this->input->post('description')
            );
            
            if ($this->Role_model->create_role($role_data)) {
                $role_id = $this->db->insert_id();
                
                // If permissions are selected
                $permissions = $this->input->post('permissions');
                if (!empty($permissions)) {
                    $this->Role_model->update_role_permissions($role_id, $permissions);
                }
                
                $this->session->set_flashdata('success', 'Role created successfully.');
                redirect('Admin/roles');
            } else {
                $this->session->set_flashdata('error', 'Error creating role.');
                $this->load->view('templates/header', $data);
                $this->load->view('admin/roles/create', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    public function edit_role($id) {
        if ($this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_roles', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
        
        $data['title'] = 'Edit Role';
        $data['role'] = $this->Role_model->get_role_by_id($id);
        
        if (empty($data['role'])) {
            show_404();
        }
        
        // If permissions system is used
        $data['permissions'] = $this->Role_model->get_all_permissions();
        $data['role_permissions'] = $this->Role_model->get_role_permissions($id);
        $data['selected_permissions'] = array_column($data['role_permissions'], 'id');
        
        $this->form_validation->set_rules('role_name', 'Role Name', 'required|trim|callback_unique_role_name['.$id.']');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/roles/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $role_data = array(
                'role_name' => $this->input->post('role_name'),
                'description' => $this->input->post('description')
            );
            
            if ($this->Role_model->update_role($id, $role_data)) {
                // If permissions are selected
                $permissions = $this->input->post('permissions');
                if (is_array($permissions)) {
                    $this->Role_model->update_role_permissions($id, $permissions);
                } else {
                    // No permissions selected, clear all
                    $this->Role_model->update_role_permissions($id, array());
                }
                
                $this->session->set_flashdata('success', 'Role updated successfully.');
                redirect('Admin/roles');
            } else {
                $this->session->set_flashdata('error', 'Error updating role.');
                $this->load->view('templates/header', $data);
                $this->load->view('admin/roles/edit', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    // Custom validation callback for unique role name during edit
    public function unique_role_name($role_name, $id) {
        $this->db->where('role_name', $role_name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('roles');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_role_name', 'The %s is already taken.');
            return FALSE;
        }
        return TRUE;
    }
    
    public function delete_role($id) {
        if ($this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_roles', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
        
        if ($this->Role_model->delete_role($id)) {
            $this->session->set_flashdata('success', 'Role deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Role cannot be deleted because it is assigned to one or more users.');
        }
        redirect('Admin/roles');
    }
}