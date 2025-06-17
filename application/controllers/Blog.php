<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->model('Category_model');
        $this->load->model('Tag_model');
        $this->load->library('pagination');
    }

    public function index() {
        // Pagination config
        $config['base_url'] = site_url('blog/index');
        $config['total_rows'] = $this->Post_model->count_posts(['status' => 'published']);
        $config['per_page'] = 10;
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
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $data = [
            'posts' => $this->Post_model->get_published_posts($config['per_page'], $page),
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'popular_tags' => $this->Tag_model->get_popular_tags(),
            'pagination_links' => $this->pagination->create_links(),
            'title' => 'Blog'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function view($slug = NULL) {
        if (!$slug) {
            redirect('blog');
        }
        
        $post = $this->Post_model->get_post_by_slug($slug);
        
        if (!$post || $post->status !== 'published') {
            show_404();
        }
        
        $data = [
            'post' => $post,
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'popular_tags' => $this->Tag_model->get_popular_tags(),
            'post_tags' => $this->Post_model->get_post_tags($post->id),
            'title' => $post->title
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('blog/view', $data);
        $this->load->view('templates/footer');
    }

    public function category($slug = NULL) {
        if (!$slug) {
            redirect('blog');
        }
        
        $category = $this->Category_model->get_category_by_slug($slug);
        
        if (!$category) {
            show_404();
        }
        
        // Pagination config
        $config['base_url'] = site_url("blog/category/{$slug}");
        $config['total_rows'] = $this->Post_model->count_posts(['status' => 'published', 'category_id' => $category->id]);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        
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
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $data = [
            'posts' => $this->Post_model->get_published_posts($config['per_page'], $page, $category->id),
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'popular_tags' => $this->Tag_model->get_popular_tags(),
            'category' => $category,
            'pagination_links' => $this->pagination->create_links(),
            'title' => "Category: {$category->name}"
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('blog/category', $data);
        $this->load->view('templates/footer');
    }

    public function tag($slug = NULL) {
        if (!$slug) {
            redirect('blog');
        }
        
        $tag = $this->Tag_model->get_tag_by_slug($slug);
        
        if (!$tag) {
            show_404();
        }
        
        // Pagination config
        $config['base_url'] = site_url("blog/tag/{$slug}");
        // Count posts with this tag
        $this->db->select('COUNT(*) as count');
        $this->db->from('post_tags pt');
        $this->db->join('tags t', 't.id = pt.tag_id');
        $this->db->join('posts p', 'p.id = pt.post_id');
        $this->db->where('t.slug', $slug);
        $this->db->where('p.status', 'published');
        $query = $this->db->get();
        $config['total_rows'] = $query->row()->count;
        
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        
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
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $data = [
            'posts' => $this->Tag_model->get_posts_by_tag($slug, $config['per_page'], $page),
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'popular_tags' => $this->Tag_model->get_popular_tags(),
            'tag' => $tag,
            'pagination_links' => $this->pagination->create_links(),
            'title' => "Tag: {$tag->name}"
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('blog/tag', $data);
        $this->load->view('templates/footer');
    }

    public function search() {
        $search_query = $this->input->get('q');
        
        if (empty($search_query)) {
            redirect('blog');
        }
        
        // Pagination config
        $config['base_url'] = site_url("blog/search?q={$search_query}");
        $config['total_rows'] = $this->Post_model->count_posts(['status' => 'published', 'search' => $search_query]);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        
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
        
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        
        $data = [
            'posts' => $this->Post_model->get_all_posts($config['per_page'], $page, ['status' => 'published', 'search' => $search_query]),
            'categories' => $this->Category_model->get_categories_with_post_count(),
            'popular_tags' => $this->Tag_model->get_popular_tags(),
            'search_query' => $search_query,
            'pagination_links' => $this->pagination->create_links(),
            'title' => "Search results for: {$search_query}"
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('blog/search', $data);
        $this->load->view('templates/footer');
    }
} 