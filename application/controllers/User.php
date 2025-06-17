<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/login');
        }
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function profile() {
        $data['title'] = 'My Profile';
        $data['user'] = $this->User_model->get_user_by_id($this->session->userdata('user_id'));

        $this->load->view('templates/header', $data);
        $this->load->view('user/profile_view', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_profile() {
        $data['title'] = 'Update Profile';
        $data['user'] = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_unique_username['.$this->session->userdata('user_id').']');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_unique_email['.$this->session->userdata('user_id').']');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('user/update_profile', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email')
            );
            
            if ($this->User_model->update_user($this->session->userdata('user_id'), $user_data)) {
                // Update session data
                $this->session->set_userdata('username', $user_data['username']);
                
                $this->session->set_flashdata('success', 'Profile updated successfully.');
                redirect('User/profile');
            } else {
                $this->session->set_flashdata('error', 'Error updating profile.');
                $this->load->view('templates/header', $data);
                $this->load->view('user/update_profile', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    public function change_password() {
        $data['title'] = 'Change Password';
        
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim|callback_check_current_password');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('user/change_password', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'password' => $this->input->post('new_password')
            );
            
            if ($this->User_model->update_user($this->session->userdata('user_id'), $user_data)) {
                $this->session->set_flashdata('success', 'Password changed successfully.');
                redirect('User/profile');
            } else {
                $this->session->set_flashdata('error', 'Error changing password.');
                $this->load->view('templates/header', $data);
                $this->load->view('user/change_password', $data);
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
    
    // Custom validation callback to check current password
    public function check_current_password($password) {
        $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        if (!password_verify($password, $user->password)) {
            $this->form_validation->set_message('check_current_password', 'The current password is incorrect.');
            return FALSE;
        }
        return TRUE;
    }
} 