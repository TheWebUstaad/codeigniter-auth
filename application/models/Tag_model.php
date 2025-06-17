<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_tags() {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('tags')->result();
    }

    public function get_tag($id) {
        $this->db->where('id', $id);
        return $this->db->get('tags')->row();
    }

    public function get_tag_by_slug($slug) {
        $this->db->where('slug', $slug);
        return $this->db->get('tags')->row();
    }

    public function create_tag($data) {
        if (empty($data['slug'])) {
            $data['slug'] = url_title($data['name'], 'dash', TRUE);
        }
        return $this->db->insert('tags', $data);
    }

    public function update_tag($id, $data) {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = url_title($data['name'], 'dash', TRUE);
        }
        $this->db->where('id', $id);
        return $this->db->update('tags', $data);
    }

    public function delete_tag($id) {
        // Delete tag associations first
        $this->db->where('tag_id', $id);
        $this->db->delete('post_tags');
        
        // Then delete the tag itself
        $this->db->where('id', $id);
        return $this->db->delete('tags');
    }

    // Get most popular tags
    public function get_popular_tags($limit = 10) {
        $this->db->select('t.*, COUNT(pt.post_id) as post_count');
        $this->db->from('tags t');
        $this->db->join('post_tags pt', 'pt.tag_id = t.id');
        $this->db->join('posts p', 'p.id = pt.post_id AND p.status = "published"');
        $this->db->group_by('t.id');
        $this->db->order_by('post_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Get tags for a specific post
    public function get_post_tags($post_id) {
        $this->db->select('t.*');
        $this->db->from('tags t');
        $this->db->join('post_tags pt', 'pt.tag_id = t.id');
        $this->db->where('pt.post_id', $post_id);
        $this->db->order_by('t.name', 'ASC');
        return $this->db->get()->result();
    }

    // Get posts with a specific tag
    public function get_posts_by_tag($tag_slug, $limit = NULL, $offset = NULL) {
        $this->db->select('p.*, u.username as author, c.name as category_name, c.slug as category_slug');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->join('post_tags pt', 'pt.post_id = p.id');
        $this->db->join('tags t', 't.id = pt.tag_id');
        $this->db->where('t.slug', $tag_slug);
        $this->db->where('p.status', 'published');
        $this->db->order_by('p.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }
    
    // Analytics methods
    
    public function count_tags() {
        return $this->db->count_all('tags');
    }
    
    public function get_tag_growth() {
        $stats = [];
        
        // Get last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));
            $month_name = date('M Y', strtotime("-$i month"));
            
            $start_date = "$year-$month-01";
            $end_date = date('Y-m-t', strtotime($start_date));
            
            $this->db->select('COUNT(*) as count');
            $this->db->from('tags');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $query = $this->db->get();
            $result = $query->row();
            
            $stats[$month_name] = $result->count;
        }
        
        // Reverse array to get chronological order
        return array_reverse($stats);
    }
    
    public function get_tag_cloud_data() {
        $this->db->select('t.name, t.slug, COUNT(pt.post_id) as weight');
        $this->db->from('tags t');
        $this->db->join('post_tags pt', 'pt.tag_id = t.id');
        $this->db->join('posts p', 'p.id = pt.post_id AND p.status = "published"');
        $this->db->group_by('t.id, t.name, t.slug');
        $this->db->having('weight >', 0);
        $this->db->order_by('weight', 'DESC');
        $this->db->limit(30);
        return $this->db->get()->result();
    }
} 