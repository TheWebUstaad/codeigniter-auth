<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_posts($limit = NULL, $offset = NULL, $filters = []) {
        // Base query
        $this->db->select('p.*, c.name as category_name, c.slug as category_slug, u.username as author, GROUP_CONCAT(t.name) as tags');
        $this->db->from('posts p');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('post_tags pt', 'pt.post_id = p.id', 'left');
        $this->db->join('tags t', 't.id = pt.tag_id', 'left');
        
        // Apply filters
        if (!empty($filters)) {
            if (isset($filters['status'])) {
                $this->db->where('p.status', $filters['status']);
            }
            if (isset($filters['category_id'])) {
                $this->db->where('p.category_id', $filters['category_id']);
            }
            if (isset($filters['author_id'])) {
                $this->db->where('p.user_id', $filters['author_id']);
            }
            if (isset($filters['search'])) {
                $search = $filters['search'];
                $this->db->group_start();
                $this->db->like('p.title', $search);
                $this->db->or_like('p.content', $search);
                $this->db->or_like('c.name', $search);
                $this->db->or_like('t.name', $search);
                $this->db->group_end();
            }
        }
        
        $this->db->group_by('p.id');
        $this->db->order_by('p.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function get_published_posts($limit = NULL, $offset = NULL, $category_id = NULL) {
        $filters = array('status' => 'published');
        if ($category_id) {
            $filters['category_id'] = $category_id;
        }
        return $this->get_all_posts($limit, $offset, $filters);
    }

    public function count_posts($filters = []) {
        $this->db->select('COUNT(DISTINCT p.id) as count');
        $this->db->from('posts p');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('post_tags pt', 'pt.post_id = p.id', 'left');
        $this->db->join('tags t', 't.id = pt.tag_id', 'left');
        
        // Apply filters
        if (!empty($filters)) {
            if (isset($filters['status'])) {
                $this->db->where('p.status', $filters['status']);
            }
            if (isset($filters['category_id'])) {
                $this->db->where('p.category_id', $filters['category_id']);
            }
            if (isset($filters['author_id'])) {
                $this->db->where('p.user_id', $filters['author_id']);
            }
            if (isset($filters['search'])) {
                $search = $filters['search'];
                $this->db->group_start();
                $this->db->like('p.title', $search);
                $this->db->or_like('p.content', $search);
                $this->db->or_like('c.name', $search);
                $this->db->or_like('t.name', $search);
                $this->db->group_end();
            }
        }
        
        $result = $this->db->get()->row();
        return $result->count;
    }

    public function get_post($id) {
        $this->db->select('p.*, u.username as author, c.name as category_name, c.slug as category_slug');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->where('p.id', $id);
        return $this->db->get()->row();
    }

    public function get_post_by_slug($slug) {
        $this->db->select('p.*, u.username as author, c.name as category_name, c.slug as category_slug');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->where('p.slug', $slug);
        return $this->db->get()->row();
    }

    public function create_post($data) {
        if (empty($data['slug'])) {
            $data['slug'] = $this->create_slug($data['title']);
        }
        return $this->db->insert('posts', $data);
    }

    public function update_post($id, $data) {
        if (isset($data['title']) && empty($data['slug'])) {
            $data['slug'] = $this->create_slug($data['title'], $id);
        }
        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    public function delete_post($id) {
        // Delete post tags first (due to foreign key constraints)
        $this->db->where('post_id', $id);
        $this->db->delete('post_tags');
        
        // Then delete the post
        $this->db->where('id', $id);
        return $this->db->delete('posts');
    }

    // Create a unique slug for the post
    private function create_slug($title, $id = NULL) {
        $slug = url_title($title, 'dash', TRUE);
        $this->db->select('slug');
        $this->db->from('posts');
        $this->db->where('slug', $slug);
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $count = $this->db->count_all_results();
        
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        
        return $slug;
    }

    // Get tags for a post
    public function get_post_tags($post_id) {
        $this->db->select('t.*');
        $this->db->from('tags t');
        $this->db->join('post_tags pt', 'pt.tag_id = t.id');
        $this->db->where('pt.post_id', $post_id);
        return $this->db->get()->result();
    }

    // Update post tags
    public function update_post_tags($post_id, $tag_ids) {
        // Delete existing post tags
        $this->db->where('post_id', $post_id);
        $this->db->delete('post_tags');
        
        // Add new tags
        if (!empty($tag_ids)) {
            $data = array();
            foreach ($tag_ids as $tag_id) {
                $data[] = array(
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                );
            }
            return $this->db->insert_batch('post_tags', $data);
        }
        
        return TRUE;
    }
    
    // Analytics methods
    
    public function get_posts_by_status() {
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('posts');
        $this->db->group_by('status');
        $query = $this->db->get();
        
        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->status] = $row->count;
        }
        
        return $result;
    }
    
    public function get_posts_by_author($limit = 5) {
        $this->db->select('u.username, COUNT(p.id) as post_count');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->group_by('u.username');
        $this->db->order_by('post_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_post_engagement() {
        // This is a placeholder - in a real app, you might track views, comments, likes
        $this->db->select('p.id, p.title, p.slug, p.views, COUNT(c.id) as comment_count');
        $this->db->from('posts p');
        $this->db->join('comments c', 'c.post_id = p.id', 'left');
        $this->db->where('p.status', 'published');
        $this->db->group_by('p.id, p.title, p.slug, p.views');
        $this->db->order_by('p.views', 'DESC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }
    
    public function get_trending_posts($days = 7, $limit = 5) {
        $date = date('Y-m-d', strtotime("-$days days"));
        
        $this->db->select('p.*, u.username as author');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->where('p.status', 'published');
        $this->db->where('p.created_at >=', $date);
        $this->db->order_by('p.views', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_posts_with_authors_categories($limit = 5) {
        $this->db->select('p.*, u.username as author_name, c.name as category_name');
        $this->db->from('posts p');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        $this->db->join('categories c', 'c.id = p.category_id', 'left');
        $this->db->order_by('p.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
} 