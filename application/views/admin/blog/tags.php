<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Manage Tags</h4>
                    <a href="<?= site_url('admin_blog/create_tag') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Tag
                    </a>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Post Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tags)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No tags found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($tags as $tag): ?>
                                        <tr>
                                            <td><?= $tag->id ?></td>
                                            <td><?= $tag->name ?></td>
                                            <td><?= $tag->slug ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $tag->post_count ?></span>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('admin_blog/edit_tag/'.$tag->id) ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= site_url('admin_blog/delete_tag/'.$tag->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tag? This will remove the tag from all posts.')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                                <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" target="_blank" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tag Cloud -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tag Cloud</h5>
                </div>
                <div class="card-body">
                    <div class="tag-cloud">
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?= site_url('blog/tag/'.$tag->slug) ?>" class="tag" style="font-size: <?= min(max(100 + ($tag->post_count * 20), 100), 200) ?>%;">
                                <?= $tag->name ?> <span class="badge bg-light text-dark"><?= $tag->post_count ?></span>
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
    gap: 10px;
    padding: 15px;
}
.tag {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border-radius: 3px;
    text-decoration: none;
    color: #333;
    transition: all 0.2s ease;
}
.tag:hover {
    background-color: #e0e0e0;
    transform: translateY(-2px);
    text-decoration: none;
    color: #333;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
</style> 