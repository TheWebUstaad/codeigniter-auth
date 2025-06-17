<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('Auth/login');
        }
        $this->load->model('Post_model');
        $this->load->model('User_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $this->load->model('Role_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        
        // Get complete user info including role
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);
        
        // Prepare user info for the view
        $data['user_info'] = array(
            'user_id' => $user_id,
            'username' => $this->session->userdata('username'),
            'role_id' => $this->session->userdata('role_id'),
            'role_name' => $user->role_name,
            'permissions' => $this->session->userdata('permissions')
        );
        
        // Analytics data for dashboard
        $data['analytics'] = $this->get_analytics_data();
        
        // Get data for dashboard tables
        $this->load->model('Role_model');
        
        // Recent users for user list (limit 5)
        $data['recent_users'] = $this->User_model->get_users_with_roles(5);
        
        // Roles with user count
        $data['roles'] = $this->Role_model->get_roles_with_user_count();
        
        // Recent posts
        $data['recent_posts'] = $this->Post_model->get_posts_with_authors_categories(5);
        
        // Categories with post count
        $data['categories'] = $this->Category_model->get_categories_with_post_count();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    private function get_analytics_data() {
        $analytics = [];
        
        // Total counts
        $analytics['total_users'] = $this->User_model->count_all_users();
        $analytics['total_posts'] = $this->Post_model->count_posts();
        $analytics['total_published'] = $this->Post_model->count_posts(['status' => 'published']);
        $analytics['total_drafts'] = $this->Post_model->count_posts(['status' => 'draft']);
        $analytics['total_categories'] = $this->Category_model->count_categories();
        $analytics['total_tags'] = $this->Tag_model->count_tags();
        
        // Recent posts
        $analytics['recent_posts'] = $this->Post_model->get_all_posts(5, 0, ['status' => 'published']);
        
        // Popular categories
        $analytics['popular_categories'] = $this->Category_model->get_popular_categories(5);
        
        // Popular tags
        $analytics['popular_tags'] = $this->Tag_model->get_popular_tags(10);
        
        // Monthly post statistics (last 6 months)
        $analytics['monthly_stats'] = $this->get_monthly_post_stats();
        
        // User role distribution
        $analytics['user_roles'] = $this->User_model->get_users_by_role();
        
        return $analytics;
    }
    
    private function get_monthly_post_stats() {
        $stats = [];
        
        // Get last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $month_name = date('M Y', strtotime("-$i month"));
            
            $start_date = "$year-$month-01";
            $end_date = date('Y-m-t', strtotime($start_date));
            
            $this->db->select('COUNT(*) as count');
            $this->db->from('posts');
            $this->db->where('status', 'published');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $query = $this->db->get();
            $result = $query->row();
            
            $stats[$month_name] = $result->count;
        }
        
        // Reverse array to get chronological order
        return array_reverse($stats);
    }
}