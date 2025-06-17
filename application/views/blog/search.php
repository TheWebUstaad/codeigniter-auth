<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">
                Search Results for "<?= htmlspecialchars($search_query) ?>"
                <small class="text-muted">(<?= count($posts) ?> results found)</small>
            </h1>

            <?php if(empty($posts)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No posts found matching your search criteria. Try different keywords or browse our recent posts below.
                </div>
            <?php endif; ?>

            <?php foreach($posts as $post): ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title h4">
                            <a href="<?= base_url('blog/view/' . $post->slug) ?>" class="text-decoration-none">
                                <?= htmlspecialchars($post->title) ?>
                            </a>
                        </h2>
                        
                        <div class="mb-2 text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i> <?= date('F j, Y', strtotime($post->created_at)) ?>
                            <?php if($post->category_name): ?>
                                <span class="mx-1">•</span>
                                <i class="fas fa-folder me-1"></i>
                                <a href="<?= base_url('blog/category/' . $post->category_slug) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($post->category_name) ?>
                                </a>
                            <?php endif; ?>
                            <?php if($post->author_name): ?>
                                <span class="mx-1">•</span>
                                <i class="fas fa-user me-1"></i> <?= htmlspecialchars($post->author_name) ?>
                            <?php endif; ?>
                        </div>

                        <p class="card-text">
                            <?= character_limiter(strip_tags($post->content), 200) ?>
                        </p>

                        <?php if(!empty($post->tags)): ?>
                            <div class="mb-2">
                                <i class="fas fa-tags me-1"></i>
                                <?php foreach(explode(',', $post->tags) as $tag): ?>
                                    <a href="<?= base_url('blog/tag/' . url_title(trim($tag), 'dash', TRUE)) ?>" 
                                       class="badge bg-secondary text-decoration-none me-1">
                                        <?= htmlspecialchars(trim($tag)) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?= base_url('blog/view/' . $post->slug) ?>" class="btn btn-primary btn-sm">
                            Read More <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if(!empty($posts)): ?>
                <div class="d-flex justify-content-center">
                    <?= $pagination_links ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Search Box -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Search Posts</h5>
                    <form action="<?= base_url('blog/search') ?>" method="get" class="mt-3">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..." 
                                   value="<?= htmlspecialchars($search_query) ?>" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Posts -->
            <?php if(!empty($recent_posts)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Recent Posts</h5>
                        <ul class="list-unstyled mt-3">
                            <?php foreach($recent_posts as $recent): ?>
                                <li class="mb-2">
                                    <a href="<?= base_url('blog/view/' . $recent->slug) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($recent->title) ?>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        <?= date('M j, Y', strtotime($recent->created_at)) ?>
                                    </small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Popular Categories -->
            <?php if(!empty($categories)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <ul class="list-unstyled mt-3">
                            <?php foreach($categories as $cat): ?>
                                <li class="mb-2">
                                    <a href="<?= base_url('blog/category/' . $cat->slug) ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($cat->name) ?>
                                        <span class="badge bg-secondary float-end"><?= $cat->post_count ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Popular Tags -->
            <?php if(!empty($tags)): ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Popular Tags</h5>
                        <div class="mt-3">
                            <?php foreach($tags as $tag): ?>
                                <a href="<?= base_url('blog/tag/' . $tag->slug) ?>" 
                                   class="badge bg-secondary text-decoration-none me-1 mb-1">
                                    <?= htmlspecialchars($tag->name) ?>
                                    <span class="badge bg-light text-dark"><?= $tag->post_count ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 