<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Post: <?= $post->title ?></h4>
                    <a href="<?= site_url('admin_blog/posts') ?>" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Posts
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($upload_error)): ?>
                        <div class="alert alert-danger"><?= $upload_error ?></div>
                    <?php endif; ?>
                    
                    <?= form_open_multipart('admin_blog/edit_post/'.$post->id) ?>
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?= set_value('title', $post->title) ?>" required>
                            <?= form_error('title', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category (Optional)</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->id ?>" <?= ($category->id == $post->category_id) ? 'selected' : '' ?>><?= $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="featured_image">Featured Image</label>
                            <?php if($post->image_path): ?>
                                <div class="mb-3">
                                    <img src="<?= base_url($post->image_path) ?>" alt="Current Featured Image" class="img-thumbnail" style="max-height: 200px">
                                    <p class="small text-muted">Current image. Upload a new one to replace it.</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="featured_image" id="featured_image" class="form-control-file">
                            <small class="text-muted">Max size: 2MB. Allowed types: jpg, jpeg, png, gif. Leave empty to keep current image.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="excerpt">Excerpt (Optional)</label>
                            <textarea name="excerpt" id="excerpt" class="form-control" rows="3"><?= set_value('excerpt', $post->excerpt) ?></textarea>
                            <small class="text-muted">A short summary of your post (shown on blog index)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Content *</label>
                            <textarea name="content" id="content" class="form-control" rows="10" required><?= set_value('content', $post->content) ?></textarea>
                            <?= form_error('content', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select name="tags[]" id="tags" class="form-control" multiple>
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?= $tag->id ?>" <?= in_array($tag->id, $post_tags) ? 'selected' : '' ?>><?= $tag->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple tags</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select name="status" id="status" class="form-control" required <?= (!$can_publish && $post->status != 'published') ? 'disabled' : '' ?>>
                                <option value="draft" <?= ($post->status == 'draft') ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= ($post->status == 'published') ? 'selected' : '' ?>>Published</option>
                                <option value="archived" <?= ($post->status == 'archived') ? 'selected' : '' ?>>Archived</option>
                            </select>
                            <?php if (!$can_publish && $post->status != 'published'): ?>
                                <small class="text-danger">You don't have permission to publish posts.</small>
                                <input type="hidden" name="status" value="draft">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Post
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize any rich text editors or tag selectors here if needed
document.addEventListener('DOMContentLoaded', function() {
    // If you want to use a rich text editor like CKEditor, TinyMCE, etc.
    // You would initialize it here for the 'content' textarea
});
</script> 