<div class="container mt-4">
    <div class="row">
        <!-- Main blog content -->
        <div class="col-md-8">
            <h1>Blog Posts</h1>
            
            <!-- Search form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="<?= site_url('blog/search') ?>" method="get" class="form-inline">
                        <div class="input-group w-100">
                            <input type="text" name="q" class="form-control" placeholder="Search posts..." required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (empty($posts)): ?>
                <div class="alert alert-info">No posts found.</div>
            <?php else: ?>
                <!-- Blog posts -->
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-4">
                        <?php if ($post->image_path): ?>
                            <img src="<?= base_url($post->image_path) ?>" class="card-img-top" alt="<?= $post->title ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="card-title"><?= $post->title ?></h2>
                            <div class="text-muted small mb-2">
                                <i class="fa fa-user"></i> <?= $post->author ?>
                                <?php if ($post->category_name): ?>
                                    | <i class="fa fa-folder"></i> <a href="<?= site_url('blog/category/'.$post->category_slug) ?>"><?= $post->category_name ?></a>
                                <?php endif; ?>
                                | <i class="fa fa-clock"></i> <?= date('F j, Y', strtotime($post->created_at)) ?>
                            </div>
                            
                            <?php if ($post->excerpt): ?>
                                <p class="card-text"><?= $post->excerpt ?></p>
                            <?php else: ?>
                                <p class="card-text"><?= character_limiter(strip_tags($post->content), 200) ?></p>
                            <?php endif; ?>
                            
                            <a href="<?= site_url('blog/view/'.$post->slug) ?>" class="btn btn-primary">Read More →</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <?= $pagination_links ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Categories -->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?= site_url('blog/category/'.$category->slug) ?>">
                                    <?= $category->name ?> 
                                    <span class="badge badge-secondary float-right"><?= $category->post_count ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Popular Tags -->
            <div class="card">
                <div class="card-header">Popular Tags</div>
                <div class="card-body">
                    <div class="tag-cloud">
                        <?php foreach ($popular_tags as $tag): ?>
                            <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" class="tag">
                                <?= $tag->name ?> <span class="badge badge-light"><?= $tag->post_count ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
}
.tag {
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border-radius: 3px;
    text-decoration: none;
    color: #333;
}
.tag:hover {
    background-color: #e0e0e0;
    text-decoration: none;
}
</style> 