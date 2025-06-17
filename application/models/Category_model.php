<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_categories() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('categories')->result();
    }

    public function get_category($id) {
        $this->db->where('id', $id);
        return $this->db->get('categories')->row();
    }

    public function get_category_by_slug($slug) {
        $this->db->where('slug', $slug);
        return $this->db->get('categories')->row();
    }

    public function create_category($data) {
        if (empty($data['slug'])) {
            $data['slug'] = url_title($data['name'], 'dash', TRUE);
        }
        return $this->db->insert('categories', $data);
    }

    public function update_category($id, $data) {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = url_title($data['name'], 'dash', TRUE);
        }
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($id) {
        // First update all posts with this category to have null category
        $this->db->where('category_id', $id);
        $this->db->update('posts', array('category_id' => NULL));
        
        // Then delete the category
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }

    // Get post count for each category
    public function get_categories_with_post_count() {
        $this->db->select('c.*, COUNT(p.id) as post_count');
        $this->db->from('categories c');
        $this->db->join('posts p', 'p.category_id = c.id AND p.status = "published"', 'left');
        $this->db->group_by('c.id');
        $this->db->order_by('c.name', 'ASC');
        return $this->db->get()->result();
    }
    
    // Analytics methods
    
    public function count_categories() {
        return $this->db->count_all('categories');
    }
    
    public function get_popular_categories($limit = NULL) {
        $this->db->select('c.*, COUNT(p.id) as post_count');
        $this->db->from('categories c');
        $this->db->join('posts p', 'p.category_id = c.id AND p.status = "published"', 'left');
        $this->db->group_by('c.id');
        $this->db->order_by('post_count', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        return $this->db->get()->result();
    }
    
    public function get_category_growth() {
        $stats = [];
        
        // Get last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $month_name = date('M Y', strtotime("-$i month"));
            
            $start_date = "$year-$month-01";
            $end_date = date('Y-m-t', strtotime($start_date));
            
            $this->db->select('COUNT(*) as count');
            $this->db->from('categories');
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