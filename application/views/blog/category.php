<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container modern-category-container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-5 display-3 fw-bold text-dark text-center text-md-start animate__animated animate__fadeInDown">Category: <span class="text-primary"><?= html_escape($category->name) ?></span></h1>

            <?php if (empty($posts)): ?>
                <div class="alert alert-info text-center py-5 rounded-4 shadow-sm animate__animated animate__fadeIn">
                    <h4 class="alert-heading display-5 fw-bold mb-3">No posts found!</h4>
                    <p class="lead mb-0">It looks like there are no blog posts in this category yet. Check back soon!</p>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 g-5">
                    <?php foreach ($posts as $index => $post): ?>
                        <div class="col animate__animated animate__fadeInUp animate__delay-<?= $index * 0.1 ?>s">
                            <div class="card h-100 shadow-lg border-0 rounded-5 blog-post-card">
                                <?php if ($post->image_path): ?>
                                    <div class="post-image-wrapper">
                                        <img src="<?= base_url($post->image_path) ?>" class="card-img-top blog-card-img rounded-top-5" alt="<?= html_escape($post->title) ?>">
                                        <div class="image-overlay rounded-top-5"></div>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column p-4 p-lg-5">
                                    <h2 class="card-title h3 mb-3 fw-bold text-dark post-title">
                                        <a href="<?= site_url('blog/view/' . $post->slug) ?>" class="text-decoration-none text-dark hover-accent stretched-link">
                                            <?= html_escape($post->title) ?>
                                        </a>
                                    </h2>

                                    <div class="text-muted small mb-3 post-meta d-flex flex-wrap align-items-center">
                                        <span class="me-3 mb-2"><i class="fas fa-calendar-alt me-1 text-primary"></i> <?= date('F j, Y', strtotime($post->created_at)) ?></span>
                                        <?php if ($post->category_id): ?>
                                            <span class="mb-2"><i class="fas fa-folder-open me-1 text-primary"></i>
                                                <a href="<?= site_url('blog/category/' . $post->category_slug) ?>" class="text-decoration-none text-muted hover-accent">
                                                    <?= html_escape($post->category_name) ?>
                                                </a>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <p class="card-text post-excerpt text-secondary lead-sm mb-4">
                                        <?= $post->excerpt ? html_escape($post->excerpt) : character_limiter(strip_tags($post->content), 200) ?>
                                    </p>

                                    <div class="mt-auto">
                                        <a href="<?= site_url('blog/view/' . $post->slug) ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5 py-3 fw-semibold text-uppercase read-more-btn">
                                            Read More <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($pagination_links): ?>
                    <div class="d-flex justify-content-center mt-5 pt-4 animate__animated animate__fadeInUp">
                        <?= $pagination_links ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg mb-4 border-0 rounded-5 animate__animated animate__fadeInRight animate__delay-0.2s">
                <div class="card-header bg-primary text-white fw-bold fs-5 p-3 rounded-top-5 text-uppercase">Categories</div>
                <div class="card-body p-4 p-lg-4">
                    <ul class="list-group list-group-flush category-list">
                        <?php foreach ($categories as $cat): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <a href="<?= site_url('blog/category/' . $cat->slug) ?>" class="text-decoration-none text-dark hover-accent d-flex align-items-center fw-medium <?= ($cat->id === $category->id) ? 'active-category-link' : '' ?>">
                                    <i class="fas fa-folder me-3 text-primary fa-lg category-icon"></i> <?= html_escape($cat->name) ?>
                                </a>
                                <span class="badge bg-primary rounded-pill fw-normal category-badge"><?= $cat->post_count ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <?php if (!empty($popular_tags)): ?>
                <div class="card shadow-lg border-0 rounded-5 animate__animated animate__fadeInRight animate__delay-0.4s">
                    <div class="card-header bg-primary text-white fw-bold fs-5 p-3 rounded-top-5 text-uppercase">Popular Tags</div>
                    <div class="card-body p-4 p-lg-4">
                        <div class="d-flex flex-wrap tag-cloud-modern">
                            <?php foreach ($popular_tags as $tag): ?>
                                <a href="<?= site_url('blog/tag/' . $tag->slug) ?>" class="tag-modern bg-light text-primary rounded-pill px-3 py-2 me-2 mb-2 text-decoration-none d-flex align-items-center border border-primary fw-medium">
                                    <?= html_escape($tag->name) ?> <span class="badge bg-primary ms-2 rounded-pill tag-count-badge"><?= $tag->post_count ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #6a0572; /* Deep Plum/Violet - Rich and modern */
        --secondary-color: #2a9d8f; /* Teal - Energetic contrast */
        --text-dark: #333d29; /* Dark Forest Green - Softer than pure black */
        --text-light: #e0e0e0;
        --background-light: #f5f5f5; /* Off-white for a warm feel */
        --card-bg: #ffffff;
        --border-color: rgba(0, 0, 0, 0.08);
        --shadow-light: 0 10px 30px rgba(0, 0, 0, 0.05);
        --shadow-medium: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    body {
        background-color: var(--background-light);
        font-family: 'Montserrat', sans-serif; /* Clean, modern sans-serif */
        color: var(--text-dark);
        line-height: 1.7;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Playfair Display', serif; /* Elegant, distinctive serif for headings */
        color: var(--text-dark);
        line-height: 1.3;
    }

    /* General Card Styling (for main content and sidebar) */
    .card {
        background-color: var(--card-bg);
        border: none;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: var(--shadow-light);
        border-radius: 1.5rem !important; /* More pronounced rounding */
        overflow: hidden;
    }

    /* Blog Post Card Specifics (for individual posts in the category list) */
    .blog-post-card {
        display: flex;
        flex-direction: column;
    }

    .blog-post-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }

    .post-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem 1.5rem 0 0;
    }

    .blog-card-img {
        height: 300px; /* Adjust height for category list images */
        object-fit: cover;
        width: 100%;
        display: block;
        transition: transform 0.6s ease-in-out;
    }

    .blog-post-card:hover .blog-card-img {
        transform: scale(1.05); /* Subtle zoom on hover */
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 50%); /* Gradient overlay for text readability */
        transition: background 0.3s ease;
    }
    
    .blog-post-card:hover .image-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 50%);
    }

    .card-body {
        padding: 2.5rem !important;
        flex-grow: 1;
        position: relative; /* For stretched-link */
    }

    .post-title a {
        transition: color 0.3s ease;
        font-family: 'Playfair Display', serif; /* Ensure post titles use Playfair Display */
    }

    .post-title a:hover {
        color: var(--primary-color) !important;
    }

    .post-meta span {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 0.5rem;
    }

    .post-meta i {
        color: var(--secondary-color); /* Icons in accent color */
    }

    .post-excerpt {
        font-size: 1rem;
        color: #555;
        margin-bottom: 2rem;
    }

    /* Category Page Header */
    .modern-category-container h1 {
        font-family: 'Playfair Display', serif;
        color: var(--text-dark);
        margin-bottom: 3rem !important;
    }
    .modern-category-container h1 .text-primary {
        color: var(--primary-color) !important;
    }

    /* Sidebar Categories & Tags Headers */
    .card-header {
        background-color: var(--primary-color) !important;
        color: white;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 1.2rem 1.8rem !important;
        border-bottom: none;
        border-radius: 1.5rem 1.5rem 0 0 !important;
    }

    /* Category List in Sidebar */
    .category-list .list-group-item {
        border-left: 5px solid transparent;
        transition: all 0.2s ease-out;
        padding: 0.8rem 0;
        font-size: 1.05rem;
    }

    .category-list .list-group-item:hover {
        border-left-color: var(--secondary-color);
        background-color: rgba(0,0,0,0.02);
    }

    .category-list .list-group-item .active-category-link {
        color: var(--primary-color) !important; /* Highlight current category */
        font-weight: 700;
    }
    .category-list .list-group-item .active-category-link .category-icon {
        color: var(--primary-color) !important;
    }

    .category-icon {
        transition: transform 0.2s ease;
    }

    .category-list .list-group-item:hover .category-icon {
        transform: translateX(5px);
    }

    .category-badge {
        background-color: var(--secondary-color) !important;
        color: white;
        font-weight: 600;
        min-width: 30px;
        text-align: center;
        padding: .5em .7em;
    }

    /* Tag Cloud in Sidebar */
    .tag-cloud-modern .tag-modern {
        background-color: var(--background-light) !important;
        color: var(--primary-color) !important;
        border: 2px solid var(--primary-color);
        font-weight: 600;
        padding: 0.7em 1.2em;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .tag-cloud-modern .tag-modern:hover {
        background-color: var(--primary-color) !important;
        color: white !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .tag-cloud-modern .tag-modern .badge { /* Specific for sidebar tag counts */
        background-color: rgba(255, 255, 255, 0.9);
        color: var(--primary-color) !important;
        font-weight: 700;
        padding: 0.3em 0.6em;
    }

    .tag-cloud-modern .tag-modern:hover .badge { /* Specific for sidebar tag counts */
        background-color: var(--secondary-color) !important;
        color: white !important;
    }

    /* Read More Button */
    .read-more-btn {
        background-color: var(--secondary-color);
        border: 2px solid var(--secondary-color);
        color: white;
        font-weight: 600;
        letter-spacing: 0.03em;
        padding: 0.9rem 2.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .read-more-btn:hover {
        background-color: transparent;
        color: var(--secondary-color);
        transform: translateX(8px);
        box-shadow: none;
    }

    /* Pagination */
    .pagination {
        --bs-pagination-color: var(--text-dark);
        --bs-pagination-active-bg: var(--primary-color);
        --bs-pagination-active-border-color: var(--primary-color);
        --bs-pagination-hover-color: var(--primary-color);
        --bs-pagination-hover-bg: rgba(0, 0, 0, 0.03);
        --bs-pagination-hover-border-color: rgba(0, 0, 0, 0.1);
        --bs-pagination-focus-box-shadow: none;
        --bs-pagination-border-radius: 0.75rem;
    }

    .page-item .page-link {
        border-radius: var(--bs-pagination-border-radius);
        margin: 0 6px;
        min-width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        background-color: white;
        color: var(--text-dark);
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        font-weight: 700;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .page-item .page-link:hover {
        background-color: var(--secondary-color) !important;
        color: white !important;
        border-color: var(--secondary-color) !important;
    }

    /* Animate.css delays for staggered appearance */
    .animate__delay-0\.1s { animation-delay: 0.1s; }
    .animate__delay-0\.2s { animation-delay: 0.2s; }
    .animate__delay-0\.3s { animation-delay: 0.3s; }
    .animate__delay-0\.4s { animation-delay: 0.4s; }
    /* Add more as needed for more posts */

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .blog-card-img {
            height: 250px;
        }
        .card-body {
            padding: 1.5rem !important;
        }
        .post-title {
            font-size: 1.5rem;
        }
        .post-meta span {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
        .post-excerpt {
            font-size: 0.95rem;
        }
        .read-more-btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>