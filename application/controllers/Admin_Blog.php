<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('authorization');
        $this->load->library('pagination');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Check if user has permission to access blog management
        // Only users with admin role or specific blog permissions can access
        if (!$this->authorization->has_role('admin') && 
            !$this->authorization->has_permission(['create_posts', 'edit_own_posts', 'edit_all_posts'])) {
            $this->session->set_flashdata('error', 'You don\'t have permission to access the blog management area.');
            redirect('blog');
        }
    }

    // POSTS MANAGEMENT
    public function posts($page = 0) {
        $config['base_url'] = site_url('admin_blog/posts');
        $config['total_rows'] = $this->Post_model->count_posts();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        
        // Bootstrap 4 pagination styling
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        // If user is not admin or editor, show only their posts
        $user_id = null;
        if (!$this->authorization->has_role(['admin', 'editor']) && 
            !$this->authorization->has_permission('edit_all_posts')) {
            $user_id = $this->session->userdata('user_id');
        }
        
        $data = [
            'posts' => $this->Post_model->get_all_posts($config['per_page'], $page, $user_id),
            'pagination_links' => $this->pagination->create_links(),
            'title' => 'Manage Posts',
            'can_create' => $this->authorization->has_permission('create_posts'),
            'can_edit_all' => $this->authorization->has_permission('edit_all_posts'),
            'can_delete_all' => $this->authorization->has_permission('delete_all_posts'),
            'can_publish' => $this->authorization->has_permission('publish_posts')
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/blog/posts', $data);
        $this->load->view('templates/footer');
    }

    public function create_post() {
        // Check if user has permission to create posts
        if (!$this->authorization->has_permission('create_posts')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to create posts.');
            redirect('admin_blog/posts');
        }
        
        $data = [
            'categories' => $this->Category_model->get_all_categories(),
            'tags' => $this->Tag_model->get_all_tags(),
            'title' => 'Create New Post',
            'can_publish' => $this->authorization->has_permission('publish_posts')
        ];
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/create_post', $data);
            $this->load->view('templates/footer');
        } else {
            // Upload image if posted
            $image_path = NULL;
            if (!empty($_FILES['featured_image']['name'])) {
                $config['upload_path'] = './uploads/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('featured_image')) {
                    $upload_data = $this->upload->data();
                    $image_path = 'uploads/blog/' . $upload_data['file_name'];
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                    $this->load->view('templates/header', $data);
                    $this->load->view('admin/blog/create_post', $data);
                    $this->load->view('templates/footer');
                    return;
                }
            }
            
            // If user doesn't have publish permission, force status to draft
            $status = $this->input->post('status');
            if (!$this->authorization->has_permission('publish_posts') && $status == 'published') {
                $status = 'draft';
            }
            
            // Prepare post data
            $post_data = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', TRUE),
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt'),
                'user_id' => $this->session->userdata('user_id'),
                'category_id' => $this->input->post('category_id') ?: NULL,
                'status' => $status,
                'image_path' => $image_path
            ];
            
            // Insert post
            $this->db->trans_begin();
            
            $post_id = $this->Post_model->create_post($post_data);
            
            // Handle tags
            if ($this->input->post('tags')) {
                $this->Post_model->update_post_tags($this->db->insert_id(), $this->input->post('tags'));
            }
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to create post.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Post created successfully.');
            }
            
            redirect('admin_blog/posts');
        }
    }

    public function edit_post($id) {
        $post = $this->Post_model->get_post($id);
        
        // Check if post exists
        if (!$post) {
            show_404();
        }
        
        // Check if user has permission to edit this post
        $can_edit = false;
        
        // Admin or users with edit_all_posts permission can edit any post
        if ($this->authorization->has_role('admin') || $this->authorization->has_permission('edit_all_posts')) {
            $can_edit = true;
        }
        // Users with edit_own_posts can only edit their own posts
        else if ($this->authorization->has_permission('edit_own_posts') && $post->user_id == $this->session->userdata('user_id')) {
            $can_edit = true;
        }
        
        if (!$can_edit) {
            $this->session->set_flashdata('error', 'You don\'t have permission to edit this post.');
            redirect('admin_blog/posts');
        }
        
        $data = [
            'post' => $post,
            'categories' => $this->Category_model->get_all_categories(),
            'tags' => $this->Tag_model->get_all_tags(),
            'post_tags' => array_column($this->Post_model->get_post_tags($id), 'id'),
            'title' => 'Edit Post',
            'can_publish' => $this->authorization->has_permission('publish_posts')
        ];
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/edit_post', $data);
            $this->load->view('templates/footer');
        } else {
            // Upload image if posted
            $image_path = $post->image_path;
            if (!empty($_FILES['featured_image']['name'])) {
                $config['upload_path'] = './uploads/blog/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if it doesn't exist
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('featured_image')) {
                    // Delete old image if exists
                    if ($post->image_path && file_exists('./' . $post->image_path)) {
                        unlink('./' . $post->image_path);
                    }
                    
                    $upload_data = $this->upload->data();
                    $image_path = 'uploads/blog/' . $upload_data['file_name'];
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                    $this->load->view('templates/header', $data);
                    $this->load->view('admin/blog/edit_post', $data);
                    $this->load->view('templates/footer');
                    return;
                }
            }
            
            // If user doesn't have publish permission, maintain current status if published
            $status = $this->input->post('status');
            if (!$this->authorization->has_permission('publish_posts') && 
                $status == 'published' && $post->status != 'published') {
                $status = 'draft';
            }
            
            // Prepare post data
            $post_data = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', TRUE),
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt'),
                'category_id' => $this->input->post('category_id') ?: NULL,
                'status' => $status,
                'image_path' => $image_path
            ];
            
            // Update post
            $this->db->trans_begin();
            
            $this->Post_model->update_post($id, $post_data);
            
            // Handle tags
            if ($this->input->post('tags')) {
                $this->Post_model->update_post_tags($id, $this->input->post('tags'));
            } else {
                $this->Post_model->update_post_tags($id, []);
            }
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to update post.');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Post updated successfully.');
            }
            
            redirect('admin_blog/posts');
        }
    }

    public function delete_post($id) {
        $post = $this->Post_model->get_post($id);
        
        // Check if post exists
        if (!$post) {
            show_404();
        }
        
        // Check if user has permission to delete this post
        $can_delete = false;
        
        // Admin or users with delete_all_posts permission can delete any post
        if ($this->authorization->has_role('admin') || $this->authorization->has_permission('delete_all_posts')) {
            $can_delete = true;
        }
        // Users with delete_own_posts can only delete their own posts
        else if ($this->authorization->has_permission('delete_own_posts') && $post->user_id == $this->session->userdata('user_id')) {
            $can_delete = true;
        }
        
        if (!$can_delete) {
            $this->session->set_flashdata('error', 'You don\'t have permission to delete this post.');
            redirect('admin_blog/posts');
        }
        
        // Delete image if exists
        if ($post->image_path && file_exists('./' . $post->image_path)) {
            unlink('./' . $post->image_path);
        }
        
        if ($this->Post_model->delete_post($id)) {
            $this->session->set_flashdata('success', 'Post deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete post.');
        }
        
        redirect('admin_blog/posts');
    }

    // CATEGORIES MANAGEMENT
    public function categories() {
        // Check if user has permission to manage categories
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_categories')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage categories.');
            redirect('admin_blog/posts');
        }
        
        $data = [
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'title' => 'Manage Categories'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/blog/categories', $data);
        $this->load->view('templates/footer');
    }

    public function create_category() {
        // Check if user has permission to manage categories
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_categories')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage categories.');
            redirect('admin_blog/posts');
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[categories.name]');
        
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title' => 'Create Category'
            ];
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/create_category', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE)
            ];
            
            if ($this->Category_model->create_category($data)) {
                $this->session->set_flashdata('success', 'Category created successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to create category.');
            }
            
            redirect('admin_blog/categories');
        }
    }

    public function edit_category($id) {
        // Check if user has permission to manage categories
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_categories')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage categories.');
            redirect('admin_blog/posts');
        }
        
        $category = $this->Category_model->get_category($id);
        
        if (!$category) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Name', "required|callback_check_category_name[$id]");
        
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'category' => $category,
                'title' => 'Edit Category'
            ];
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/edit_category', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE)
            ];
            
            if ($this->Category_model->update_category($id, $data)) {
                $this->session->set_flashdata('success', 'Category updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category.');
            }
            
            redirect('admin_blog/categories');
        }
    }

    public function delete_category($id) {
        // Check if user has permission to manage categories
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_categories')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage categories.');
            redirect('admin_blog/posts');
        }
        
        if ($this->Category_model->delete_category($id)) {
            $this->session->set_flashdata('success', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category.');
        }
        
        redirect('admin_blog/categories');
    }

    // Check if category name exists for other categories
    public function check_category_name($name, $id) {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('categories');
        
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_category_name', 'The {field} already exists.');
            return FALSE;
        }
        
        return TRUE;
    }

    // TAGS MANAGEMENT
    public function tags() {
        // Check if user has permission to manage tags
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_tags')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage tags.');
            redirect('admin_blog/posts');
        }
        
        $data = [
            'tags' => $this->Tag_model->get_popular_tags(100),
            'title' => 'Manage Tags'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/blog/tags', $data);
        $this->load->view('templates/footer');
    }

    public function create_tag() {
        // Check if user has permission to manage tags
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_tags')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage tags.');
            redirect('admin_blog/posts');
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[tags.name]');
        
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'title' => 'Create Tag'
            ];
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/create_tag', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE)
            ];
            
            if ($this->Tag_model->create_tag($data)) {
                $this->session->set_flashdata('success', 'Tag created successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to create tag.');
            }
            
            redirect('admin_blog/tags');
        }
    }

    public function edit_tag($id) {
        // Check if user has permission to manage tags
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_tags')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage tags.');
            redirect('admin_blog/posts');
        }
        
        $tag = $this->Tag_model->get_tag($id);
        
        if (!$tag) {
            show_404();
        }
        
        $this->form_validation->set_rules('name', 'Name', "required|callback_check_tag_name[$id]");
        
        if ($this->form_validation->run() === FALSE) {
            $data = [
                'tag' => $tag,
                'title' => 'Edit Tag'
            ];
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/blog/edit_tag', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'slug' => url_title($this->input->post('name'), 'dash', TRUE)
            ];
            
            if ($this->Tag_model->update_tag($id, $data)) {
                $this->session->set_flashdata('success', 'Tag updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update tag.');
            }
            
            redirect('admin_blog/tags');
        }
    }

    public function delete_tag($id) {
        // Check if user has permission to manage tags
        if (!$this->authorization->has_role('admin') && !$this->authorization->has_permission('manage_tags')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to manage tags.');
            redirect('admin_blog/posts');
        }
        
        if ($this->Tag_model->delete_tag($id)) {
            $this->session->set_flashdata('success', 'Tag deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete tag.');
        }
        
        redirect('admin_blog/tags');
    }

    // Check if tag name exists for other tags
    public function check_tag_name($name, $id) {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('tags');
        
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_tag_name', 'The {field} already exists.');
            return FALSE;
        }
        
        return TRUE;
    }
    
    // Publish a draft post
    public function publish_post($id) {
        $post = $this->Post_model->get_post($id);
        
        // Check if post exists
        if (!$post) {
            show_404();
        }
        
        // Check if user has permission to publish posts
        if (!$this->authorization->has_permission('publish_posts')) {
            $this->session->set_flashdata('error', 'You don\'t have permission to publish posts.');
            redirect('admin_blog/posts');
        }
        
        // Check if user has permission to edit this post
        $can_edit = false;
        
        // Admin or users with edit_all_posts permission can edit any post
        if ($this->authorization->has_role('admin') || $this->authorization->has_permission('edit_all_posts')) {
            $can_edit = true;
        }
        // Users with edit_own_posts can only edit their own posts
        else if ($this->authorization->has_permission('edit_own_posts') && $post->user_id == $this->session->userdata('user_id')) {
            $can_edit = true;
        }
        
        if (!$can_edit) {
            $this->session->set_flashdata('error', 'You don\'t have permission to edit this post.');
            redirect('admin_blog/posts');
        }
        
        // Only allow publishing of draft posts
        if ($post->status != 'draft') {
            $this->session->set_flashdata('error', 'Only draft posts can be published.');
            redirect('admin_blog/posts');
        }
        
        // Update post status to published
        if ($this->Post_model->update_post($id, ['status' => 'published'])) {
            $this->session->set_flashdata('success', 'Post published successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to publish post.');
        }
        
        redirect('admin_blog/posts');
    }
}