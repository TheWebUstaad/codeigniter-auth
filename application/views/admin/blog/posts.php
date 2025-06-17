<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Manage Blog Posts</h4>
                    <?php if ($can_create): ?>
                    <a href="<?= site_url('admin_blog/create_post') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create New Post
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($posts)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No posts found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td><?= $post->id ?></td>
                                            <td>
                                                <?= $post->title ?>
                                                <?php if ($post->status === 'published'): ?>
                                                    <br>
                                                    <a href="<?= site_url('blog/view/'.$post->slug) ?>" target="_blank" class="small">
                                                        <i class="fa fa-external-link"></i> View
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($post->author ?? 'Unknown') ?></td>
                                            <td><?= $post->category_name ?: 'Uncategorized' ?></td>
                                            <td>
                                                <?php if ($post->status === 'published'): ?>
                                                    <span class="badge bg-success">Published</span>
                                                <?php elseif ($post->status === 'draft'): ?>
                                                    <span class="badge bg-warning text-dark">Draft</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Archived</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('M j, Y', strtotime($post->created_at)) ?></td>
                                            <td>
                                                <?php 
                                                // Determine if user can edit this post
                                                $can_edit = $can_edit_all || ($post->user_id == $this->session->userdata('user_id'));
                                                
                                                // Determine if user can delete this post
                                                $can_delete = $can_delete_all || ($post->user_id == $this->session->userdata('user_id') && 
                                                                              $this->authorization->has_permission('delete_own_posts'));
                                                ?>
                                                
                                                <?php if ($can_edit): ?>
                                                <a href="<?= site_url('admin_blog/edit_post/'.$post->id) ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php endif; ?>
                                                
                                                <?php if ($can_delete): ?>
                                                <a href="<?= site_url('admin_blog/delete_post/'.$post->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                <?php endif; ?>
                                                
                                                <?php if ($post->status == 'draft' && $can_publish && $can_edit): ?>
                                                <form method="post" action="<?= site_url('admin_blog/publish_post/'.$post->id) ?>" style="display:inline;">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fa fa-check-circle"></i> Publish
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-wrapper mt-3">
                        <?= $pagination_links ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 