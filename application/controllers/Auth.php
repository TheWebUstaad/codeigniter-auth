<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('Dashboard'); // Redirect to dashboard if already logged in
        } else {
            $this->login();
        }
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('Dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user_by_username($username);

            if ($user && password_verify($password, $user->password)) {
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role_id' => $user->role_id,
                    'role_name' => $user->role_name,
                    'logged_in' => TRUE
                );

                // If using permissions table, load them into session
                if ($this->db->table_exists('permissions') && $this->db->table_exists('role_permissions')) {
                     $session_data['permissions'] = $this->User_model->get_user_permissions($user->id);
                }

                $this->session->set_userdata($session_data);
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');
                $this->load->view('auth/login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata(array('user_id', 'username', 'role_id', 'role_name', 'logged_in', 'permissions'));
        $this->session->sess_destroy();
        redirect('Auth/login');
    }

    // Optional: User Registration
    public function register() {
        // Implement registration logic here if users can register themselves
        // Ensure you set a default role_id for new registrations (e.g., 'User')
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role_id' => 3 // Assuming 'User' role has ID 3
            );

            if ($this->User_model->create_user($data)) {
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect('Auth/login');
            } else {
                $this->session->set_flashdata('error', 'Error during registration. Please try again.');
                $this->load->view('auth/register');
            }
        }
    }
}