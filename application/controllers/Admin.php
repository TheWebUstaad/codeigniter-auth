<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/login');
        }
        // Check if user has 'Admin' role or 'manage_users' permission
        if ($this->session->userdata('role_name') !== 'Admin' &&
            !in_array('manage_users', $this->session->userdata('permissions'))) {
            show_error('You do not have permission to access this page.', 403);
        }
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Admin Panel';
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

        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_unique_username['.$id.']');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_unique_email['.$id.']');
        $this->form_validation->set_rules('password', 'Password', 'permit_empty|min_length[6]'); // Allow empty for no change
        $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/users/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'role_id' => $this->input->post('role_id')
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