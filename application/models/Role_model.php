<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    public function get_role_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('roles')->row();
    }

    public function create_role($data) {
        return $this->db->insert('roles', $data);
    }

    public function update_role($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('roles', $data);
    }

    public function delete_role($id) {
        // First check if any users are using this role
        $this->db->where('role_id', $id);
        $users = $this->db->get('users')->num_rows();
        
        if ($users > 0) {
            return false; // Can't delete a role that's in use
        }
        
        $this->db->where('id', $id);
        return $this->db->delete('roles');
    }

    // For permission-based system
    public function get_all_permissions() {
        return $this->db->get('permissions')->result();
    }

    public function get_roles_with_user_count() {
        $this->db->select('roles.*, COUNT(users.id) as user_count');
        $this->db->from('roles');
        $this->db->join('users', 'roles.id = users.role_id', 'left');
        $this->db->group_by('roles.id');
        $this->db->order_by('user_count', 'DESC');
        return $this->db->get()->result();
    }

    public function get_role_permissions($role_id) {
        $this->db->select('p.*');
        $this->db->from('permissions p');
        $this->db->join('role_permissions rp', 'rp.permission_id = p.id');
        $this->db->where('rp.role_id', $role_id);
        return $this->db->get()->result();
    }

    public function update_role_permissions($role_id, $permission_ids) {
        // Delete existing permissions
        $this->db->where('role_id', $role_id);
        $this->db->delete('role_permissions');
        
        // Insert new permissions
        $data = array();
        foreach ($permission_ids as $permission_id) {
            $data[] = array(
                'role_id' => $role_id,
                'permission_id' => $permission_id
            );
        }
        
        if (!empty($data)) {
            return $this->db->insert_batch('role_permissions', $data);
        }
        
        return true;
    }
} 