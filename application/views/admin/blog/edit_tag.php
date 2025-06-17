<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Tag: <?= $tag->name ?></h4>
                    <a href="<?= site_url('admin_blog/tags') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tags
                    </a>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    
                    <?php echo form_open('admin_blog/edit_tag/' . $tag->id); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $tag->name) ?>" required>
                            <div class="form-text">The name is how the tag appears on your site.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= set_value('slug', $tag->slug) ?>">
                            <div class="form-text">The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens. Leave empty to generate automatically.</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Tag
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name if slug is empty
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const originalSlug = '<?= $tag->slug ?>';
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('keyup', function() {
            // Only auto-generate if the slug is empty or matches the original slug
            if (slugInput.value === '' || slugInput.value === originalSlug) {
                // Convert to lowercase, replace spaces with hyphens, remove special chars
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }
        });
    }
});
</script> 