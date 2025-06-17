<div class="container mt-4">
    <div class="row">
        <!-- Main content -->
        <div class="col-md-8">
            <!-- Post content -->
            <article>
                <?php if ($post->image_path): ?>
                    <img src="<?= base_url($post->image_path) ?>" class="img-fluid rounded mb-4" alt="<?= $post->title ?>">
                <?php endif; ?>
                
                <h1><?= $post->title ?></h1>
                
                <div class="text-muted mb-3">
                    <i class="fa fa-user"></i> <?= $post->author ?>
                    <?php if ($post->category_name): ?>
                        | <i class="fa fa-folder"></i> <a href="<?= site_url('blog/category/'.$post->category_slug) ?>"><?= $post->category_name ?></a>
                    <?php endif; ?>
                    | <i class="fa fa-clock"></i> <?= date('F j, Y', strtotime($post->created_at)) ?>
                </div>
                
                <!-- Post content -->
                <div class="post-content">
                    <?= $post->content ?>
                </div>
                
                <!-- Post tags -->
                <?php if (!empty($post_tags)): ?>
                    <div class="post-tags mt-4">
                        <h5>Tags:</h5>
                        <div class="tag-cloud">
                            <?php foreach ($post_tags as $tag): ?>
                                <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" class="tag">
                                    <?= $tag->name ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
            
            <!-- Post navigation -->
            <div class="post-navigation mt-4">
                <div class="row">
                    <div class="col-6">
                        <a href="<?= site_url('blog') ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Back to Blog
                        </a>
                    </div>
                </div>
            </div>
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
                                <?= $tag->name ?>
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
.post-content {
    line-height: 1.8;
}
.post-content img {
    max-width: 100%;
    height: auto;
}
</style> 