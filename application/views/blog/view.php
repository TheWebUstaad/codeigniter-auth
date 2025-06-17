<div class="container modern-blog-post-container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8">
            <article class="blog-article card shadow-lg border-0 rounded-5 animate__animated animate__fadeInUp">
                <?php if ($post->image_path): ?>
                    <div class="post-hero-image-wrapper rounded-top-5">
                        <img src="<?= base_url($post->image_path) ?>" class="img-fluid post-hero-image rounded-top-5" alt="<?= $post->title ?>">
                        <div class="hero-image-overlay rounded-top-5"></div>
                    </div>
                <?php endif; ?>

                <div class="card-body p-4 p-lg-5">
                    <h1 class="post-title display-4 fw-bold mb-4 text-dark"><?= $post->title ?></h1>

                    <div class="post-meta text-muted small mb-4 d-flex flex-wrap align-items-center">
                        <span class="me-3 mb-2"><i class="fas fa-user-circle me-1 text-primary"></i> <?= $post->author ?></span>
                        <?php if ($post->category_name): ?>
                            <span class="me-3 mb-2"><i class="fas fa-folder-open me-1 text-primary"></i> <a href="<?= site_url('blog/category/'.$post->category_slug) ?>" class="text-decoration-none text-muted hover-accent"><?= $post->category_name ?></a></span>
                        <?php endif; ?>
                        <span class="mb-2"><i class="fas fa-calendar-alt me-1 text-primary"></i> <?= date('F j, Y', strtotime($post->created_at)) ?></span>
                    </div>

                    <div class="post-content fs-5 text-dark">
                        <?= $post->content ?>
                    </div>

                    <?php if (!empty($post_tags)): ?>
                        <div class="post-tags mt-5 pt-3 border-top border-light-subtle">
                            <h5 class="fw-bold mb-3 text-primary text-uppercase">Topics:</h5>
                            <div class="tag-cloud-modern">
                                <?php foreach ($post_tags as $tag): ?>
                                    <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" class="tag-modern bg-light text-primary rounded-pill px-4 py-2 me-2 mb-2 text-decoration-none d-flex align-items-center border border-primary fw-medium">
                                        <?= $tag->name ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <div class="post-navigation mt-5 pt-4 text-center animate__animated animate__fadeInUp">
                <a href="<?= site_url('blog') ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5 py-3 fw-semibold back-to-blog-btn">
                    <i class="fas fa-arrow-left me-2"></i> Back to All Posts
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg mb-4 border-0 rounded-5 animate__animated animate__fadeInRight animate__delay-0.2s">
                <div class="card-header bg-primary text-white fw-bold fs-5 p-3 rounded-top-5 text-uppercase">Categories</div>
                <div class="card-body p-4 p-lg-4">
                    <ul class="list-group list-group-flush category-list">
                        <?php foreach ($categories as $category): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <a href="<?= site_url('blog/category/'.$category->slug) ?>" class="text-decoration-none text-dark hover-accent d-flex align-items-center fw-medium">
                                    <i class="fas fa-folder me-3 text-primary fa-lg category-icon"></i> <?= $category->name ?>
                                </a>
                                <span class="badge bg-primary rounded-pill fw-normal category-badge"><?= $category->post_count ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-5 animate__animated animate__fadeInRight animate__delay-0.4s">
                <div class="card-header bg-primary text-white fw-bold fs-5 p-3 rounded-top-5 text-uppercase">Popular Tags</div>
                <div class="card-body p-4 p-lg-4">
                    <div class="d-flex flex-wrap tag-cloud-modern">
                        <?php foreach ($popular_tags as $tag): ?>
                            <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" class="tag-modern bg-light text-primary rounded-pill px-3 py-2 me-2 mb-2 text-decoration-none d-flex align-items-center border border-primary fw-medium">
                                <?= $tag->name ?> <span class="badge bg-primary ms-2 rounded-pill tag-count-badge"><?= $tag->post_count ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
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

    /* Main Article Card */
    .blog-article {
        box-shadow: var(--shadow-medium);
        border-radius: 1.5rem !important;
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .blog-article:hover {
        transform: translateY(-5px); /* Subtle lift on hover */
    }

    /* Hero Image for Post */
    .post-hero-image-wrapper {
        position: relative;
        height: 450px; /* Make the hero image more prominent */
        overflow: hidden;
        border-radius: 1.5rem 1.5rem 0 0;
    }

    .post-hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease-in-out;
    }

    .blog-article:hover .post-hero-image {
        transform: scale(1.03); /* Subtle zoom on image hover */
    }

    .hero-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 60%); /* Darker gradient for impact */
        transition: background 0.3s ease;
    }

    .post-title {
        color: var(--primary-color); /* Title in primary color */
        margin-bottom: 1.5rem !important;
    }

    .post-meta span {
        font-size: 0.95rem;
        color: #777;
    }

    .post-meta i {
        color: var(--secondary-color); /* Icons in accent color */
    }

    .hover-accent:hover {
        color: var(--secondary-color) !important;
    }

    /* Post Content Styling */
    .post-content {
        line-height: 1.9; /* More generous line height for readability */
        font-size: 1.15rem; /* Slightly larger base font size */
        color: var(--text-dark);
    }

    .post-content p {
        margin-bottom: 1.5rem;
    }

    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem; /* Rounded images within content */
        margin: 1.5rem 0;
        box-shadow: var(--shadow-light);
    }

    .post-content h2,
    .post-content h3,
    .post-content h4,
    .post-content h5,
    .post-content h6 {
        font-family: 'Playfair Display', serif;
        color: var(--primary-color);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .post-content ul,
    .post-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .post-content li {
        margin-bottom: 0.5rem;
    }

    /* Post Tags */
    .post-tags h5 {
        color: var(--secondary-color); /* Tags header in accent color */
        margin-bottom: 1rem !important;
    }

    .tag-cloud-modern .tag-modern {
        background-color: var(--background-light) !important;
        color: var(--primary-color) !important;
        border: 2px solid var(--primary-color);
        font-weight: 600;
        padding: 0.7em 1.2em;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .tag-cloud-modern .tag-modern:hover {
        background-color: var(--primary-color) !important;
        color: white !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Back to Blog Button */
    .back-to-blog-btn {
        background-color: transparent;
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        font-weight: 600;
        letter-spacing: 0.03em;
        padding: 0.9rem 2.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .back-to-blog-btn:hover {
        background-color: var(--secondary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar Styling (Copied from previous response for consistency) */
    .card {
        background-color: var(--card-bg);
        border: none;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: var(--shadow-light);
        border-radius: 1.5rem !important; /* More pronounced rounding */
        overflow: hidden;
    }

    .card-header {
        background-color: var(--primary-color) !important;
        color: white;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 1.2rem 1.8rem !important;
        border-bottom: none;
        border-radius: 1.5rem 1.5rem 0 0 !important;
    }

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

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .post-hero-image-wrapper {
            height: 280px;
        }
        .card-body {
            padding: 1.5rem !important;
        }
        .post-title {
            font-size: 2rem;
            margin-bottom: 1rem !important;
        }
        .post-meta span {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        .post-content {
            font-size: 1rem;
        }
        .back-to-blog-btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>