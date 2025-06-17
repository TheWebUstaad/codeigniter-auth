<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create_user($data) {
        // Hash the password before storing
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }

    public function get_user_by_username($username) {
        $this->db->select('u.*, r.role_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $this->db->where('u.username', $username);
        return $this->db->get()->row();
    }

    public function get_user_by_id($id) {
        $this->db->select('u.*, r.role_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $this->db->where('u.id', $id);
        return $this->db->get()->row();
    }

    public function get_all_users() {
        // Get the current logged-in user ID
        $current_user_id = $this->session->userdata('user_id');
        
        // First, get all users
        $this->db->select('u.*, r.role_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $users = $this->db->get()->result();
        
        // Reorder the users array to put the current user at the top
        if ($current_user_id) {
            $current_user = null;
            $other_users = [];
            
            foreach ($users as $user) {
                if ($user->id == $current_user_id) {
                    $current_user = $user;
                } else {
                    $other_users[] = $user;
                }
            }
            
            // If current user was found, put them at the beginning of the array
            if ($current_user) {
                array_unshift($other_users, $current_user);
                return $other_users;
            }
        }
        
        // If no reordering was done, return the original array
        return $users;
    }

    public function update_user($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']); // Don't update password if empty
        }
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    public function get_roles() {
        return $this->db->get('roles')->result();
    }

    public function get_role_by_id($role_id) {
        $this->db->where('id', $role_id);
        return $this->db->get('roles')->row();
    }

    // For permission-based authorization (if using permissions table)
    public function get_user_permissions($user_id) {
        $this->db->select('p.permission_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $this->db->join('role_permissions rp', 'rp.role_id = r.id');
        $this->db->join('permissions p', 'p.id = rp.permission_id');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'permission_name');
    }
    
    // Analytics methods
    public function count_all_users() {
        return $this->db->count_all('users');
    }
    
    public function get_users_by_role() {
        $this->db->select('r.role_name, COUNT(u.id) as count');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $this->db->group_by('r.role_name');
        $query = $this->db->get();
        
        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->role_name] = $row->count;
        }
        
        return $result;
    }
    
    public function get_recent_users($limit = 5) {
        $this->db->select('u.*, r.role_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id = u.role_id');
        $this->db->order_by('u.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_user_registration_stats() {
        $stats = [];
        
        // Get last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $month_name = date('M Y', strtotime("-$i month"));
            
            $start_date = "$year-$month-01";
            $end_date = date('Y-m-t', strtotime($start_date));
            
            $this->db->select('COUNT(*) as count');
            $this->db->from('users');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $query = $this->db->get();
            $result = $query->row();
            
            $stats[$month_name] = $result->count;
        }
        
        // Reverse array to get chronological order
        return array_reverse($stats);
    }

    public function get_users_with_roles($limit = null, $offset = 0) {
        $this->db->select('users.*, roles.role_name, COALESCE(users.active, 1) as active');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id');
        $this->db->order_by('users.id', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
}