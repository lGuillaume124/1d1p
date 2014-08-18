<?= $this->start('script'); ?>
<script type="text/javascript">
    $(function(){
        $('.admin-tooltip').tooltip();
    });
</script>
<?= $this->end(); ?>
<div class="container dashboard-container">
    <?php if(empty($albums)): ?>
        <div class="alert alert-info">
            <h4><?= __('Welcome ').AuthComponent::user('username').'!'; ?></h4>
            <p><?= __('Unfortunately you do not have any albums yet.'); ?></p>
            <p><?= $this->Html->link(__('Add Your First Album'), '#', array('class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#newAlbumModal')); ?></p>
        </div>
    <?php endif; ?>
    <?php if(!empty($albums)): ?>
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= __('Hi ').AuthComponent::user('username').'!'.' '.__('Want to share some photos?'); ?>
                </div>
                <div class="panel-body text-left">
                    <?= __('Currently, you have ') ?>
                    <span class="label label-default"><?= __n("%s post", "%s posts", $stats['pcount'], $stats['pcount']); ?></span> in
                    <span class="label label-default"><?= __n("%s album", "%s albums", $stats['acount'], $stats['acount']); ?></span>
                    <?= $this->Html->link(__('New Album'), '#', array('class' => 'btn btn-info pull-right', 'data-toggle' => 'modal', 'data-target' => '#newAlbumModal')); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <?php foreach($albums as $album): ?>
                <div class="col-xs-10">
                    <h3>
                        <?= $album['Album']['title']; ?>
                        <small><?= __('Created on ').$this->Time->format($album['Album']['created'], '%d/%m/%Y'); ?></small>
                    </h3>
                </div>
                <div class="col-xs-2 text-right album-controls">
                    <?= $this->Html->link(
                        '<i class="glyphicon glyphicon-picture"></i>',
                        array('controller' => 'posts', 'action' => 'add', '?' => array('a' => $album['Album']['id'])),
                        array(
                            'class' => 'btn btn-sm btn-success admin-tooltip',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => __('Add Photo'),
                            'escape' => false)
                    ); ?>
                    <?= $this->Form->postLink(
                        '<i class="glyphicon glyphicon-trash"></i>',
                        array('controller' => 'albums', 'action' => 'delete', $album['Album']['id']),
                        array(
                            'class' => 'btn btn-sm btn-danger admin-tooltip',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => __('Delete'),
                            'escape' => false),
                        __('Are you sure? All your photos in this album will be removed.')
                    ); ?>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 0"/>
                <?php if(!empty($album['Post'])): ?>
                    <?php foreach($album['Post'] as $post): ?>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="thumbnail post-thumbnail">
                                <?= $this->Image->lazyload($this->Image->thumbPath('photos'.DS.$post['picture'], 510)); ?>
                                <div class="caption text-justify">
                                    <h4>
                                        <?= $this->Time->format($post['post_dt'], '%d/%m/%Y - %H:%M'); ?><br />
                                        <small><?= $post['title']; ?></small>
                                    </h4>
                                    <p>
                                        <?= $post['content']; ?>
                                    </p>
                                </div>
                                <?= $this->Html->link(
                                    '<i class="glyphicon glyphicon-edit"></i>',
                                    array('controller' => 'posts', 'action' => 'edit', $post['id']),
                                    array('class' => 'btn btn-sm btn-primary btn-post-edit', 'escape' => false)
                                ); ?>
                                <?= $this->Form->postLink(
                                    '<i class="glyphicon glyphicon-trash"></i>',
                                    array('controller' => 'posts', 'action' => 'delete', $post['id']),
                                    array('class' => 'btn btn-sm btn-danger btn-post-delete', 'escape' => false),
                                    __('Are you sure ?')
                                ); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Album creation form -->
    <div class="modal fade" id="newAlbumModal" tabindex="-1" role="dialog" aria-labelledby="newAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?= $this->Form->create('Album', array('action' => 'add')); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= __('Close'); ?></span></button>
                    <h4 class="modal-title"><?= __('New Album'); ?></h4>
                </div>
                <div class="modal-body">
                    <?= $this->Form->input('title', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>',
                        'placeholder' => __('Album title'))); ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->submit(__('Create'), array('class' => 'btn btn-success')); ?>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
