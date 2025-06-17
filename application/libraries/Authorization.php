<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorization {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
    }

    /**
     * Check if the current user has a specific role.
     * @param string|array $roles The role(s) to check against.
     * @return bool
     */
    public function has_role($roles) {
        if (!is_array($roles)) {
            $roles = array($roles);
        }
        return in_array($this->CI->session->userdata('role_name'), $roles);
    }

    /**
     * Check if the current user has a specific permission.
     * Requires the permissions to be loaded into the session during login.
     * @param string|array $permission The permission(s) to check against.
     * @return bool
     */
    public function has_permission($permission) {
        $user_permissions = $this->CI->session->userdata('permissions');
        if (!is_array($user_permissions)) {
            return FALSE;
        }
        if (!is_array($permission)) {
            $permission = array($permission);
        }
        foreach ($permission as $p) {
            if (in_array($p, $user_permissions)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Redirects if user does not have the required role.
     * @param string|array $roles The role(s) required.
     * @param string $redirect_url URL to redirect to on failure.
     */
    public function restrict_to_roles($roles, $redirect_url = 'Dashboard') {
        if (!$this->has_role($roles)) {
            redirect($redirect_url);
        }
    }

    /**
     * Redirects if user does not have the required permission.
     * @param string|array $permission The permission(s) required.
     * @param string $redirect_url URL to redirect to on failure.
     */
    public function restrict_to_permission($permission, $redirect_url = 'Dashboard') {
        if (!$this->has_permission($permission)) {
            redirect($redirect_url);
        }
    }
}