<?php echo $this->Html->css('jquery.fs.selecter', array('inline' => false)); ?>
<?php echo $this->start('script'); ?>
<?php echo $this->Html->script(array('jquery.fs.selecter')); ?>
<script type="text/javascript">
    $(function(){
        $('.admin-tooltip').tooltip();
        $('#album-selecter').selecter({
            links: true,
            label: "<?php echo __('Select another album'); ?>"
        });
    });
</script>
<?php echo $this->end(); ?>

<div class="col-xs-12" style="margin-top: 10px;">
    <?php if(empty($album)): ?>
        <div class="alert alert-info">
            <h4><?php echo __('Welcome').' '.AuthComponent::user('username').'.'; ?></h4>
            <p><?php echo __('You have not yet created albums.'); ?></p>
            <p><?php echo $this->Html->link(__('Add Your First Album'), '#', array('class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#newAlbumModal')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Album creation form -->
    <div class="modal fade" id="newAlbumModal" tabindex="-1" role="dialog" aria-labelledby="newAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('Album', array('action' => 'add')); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Close'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('New Album'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->input('title', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-folder-open"></i></span>',
                        'placeholder' => __('Album title'))); ?>
                </div>
                <div class="modal-footer">
                    <?php echo $this->Form->submit(__('Create'), array('class' => 'btn btn-success')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Albums edition form -->
<?php if(!empty($album)): ?>

    <div class="modal fade" id="<?php echo 'eModal'.$album['Album']['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo 'eModal'.$v['Album']['id'].'label'; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo $this->Form->create('Album', array('controller' => 'albums', 'action' => 'edit/'.$album['Album']['id'])); ?>
                <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $album['Album']['id'])); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Close'); ?></span></button>
                    <h4 class="modal-title"><?php echo __('Rename'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $this->Form->input('title', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>',
                        'placeholder' => __('Album title'))); ?>
                </div>
                <div class="modal-footer">
                    <?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-success')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php if(!empty($album)): ?>

    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading lg-panel-heading">
                <strong><?php echo __('Hi ').AuthComponent::user('username').'!'.' '.__('Want to share some photos?'); ?></strong>
                <?php echo $this->Html->link(__('New Album'), '#', array('class' => 'btn btn-success pull-right', 'data-toggle' => 'modal', 'data-target' => '#newAlbumModal')); ?>
            </div>
            <div class="panel-body text-left">
                <p>
                    <?php echo __('You currently have').' '; ?>
                    <span class="label label-default">
                        <?php echo __n("%s post", "%s posts", $stats['pcount'], $stats['pcount']); ?>
                    </span>&nbsp;in&nbsp;
                    <span class="label label-default">
                        <?php echo __n("%s album", "%s albums", $stats['acount'], $stats['acount']); ?>
                    </span>
                </p>


                <?php if(count($albums) >= 1){
                    echo $this->Form->input('fields', array(
                        'id' => 'album-selecter',
                        'label' => false,
                        'options' => $albums
                    ));
                } ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12">

        <div class="col-xs-9">
            <h3>
                <?php echo $album['Album']['title']; ?>
                <small><?php echo __('Created on').' '.$this->Time->format($album['Album']['created'], '%d/%m/%Y'); ?></small>
            </h3>
        </div>
        <div class="col-xs-3 text-right album-controls">
            <?php echo $this->Html->link(
                '<i class="glyphicon glyphicon-picture"></i>',
                array('controller' => 'posts', 'action' => 'add', '?' => array('a' => $album['Album']['id'])),
                array(
                    'class' => 'btn btn-sm btn-success admin-tooltip',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => __('Add Photo'),
                    'escape' => false)
            ); ?>
            <?php echo $this->Html->link(
                '<i class="glyphicon glyphicon-edit"></i>',
                '#',
                array(
                    'class' => 'btn btn-sm btn-primary',
                    'data-toggle' => 'modal',
                    'data-target' => '#eModal'.$album['Album']['id'],
                    //'data-placement' => 'top',
                    'title' => __('Rename'),
                    'escape' => false
                )
            ); ?>
            <?php echo $this->Form->postLink(
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
            <div class="admin-row">
                <?php foreach($album['Post'] as $post): ?>
                    <div class="thumbnail post-thumbnail">
                        <?php echo $this->Image->lazyload($this->Image->thumbPath('photos'.DS.$post['picture'], 510)); ?>
                        <div class="caption">
                            <h4>
                                <?php echo $post['title']; ?><br />
                                <small><?php echo $this->Time->format($post['post_dt'], '%d/%m/%Y - %H:%M').' '.$post['post_dt_offset']; ?></small>
                            </h4>
                            <p>
                                <?php echo $post['content']; ?>
                            </p>
                        </div>
                        <?php echo $this->Html->link(
                            '<i class="glyphicon glyphicon-edit"></i>',
                            array('controller' => 'posts', 'action' => 'edit', $post['id']),
                            array('class' => 'btn btn-sm btn-primary btn-mgmt btn-post-edit', 'escape' => false)
                        ); ?>
                        <?php echo $this->Form->postLink(
                            '<i class="glyphicon glyphicon-trash"></i>',
                            array('controller' => 'posts', 'action' => 'delete', $post['id']),
                            array('class' => 'btn btn-sm btn-danger btn-mgmt btn-post-delete', 'escape' => false),
                            __('Are you sure ?')
                        ); ?>

                        <?php if($post['unapproved_comments'] > 0){
                            echo $this->Html->link(
                                $post['unapproved_comments'].' <i class="glyphicon glyphicon-comment"></i>',
                                array('controller' => 'comments', 'action' => 'manage', $post['id']),
                                array('class' => 'btn btn-sm btn-warning btn-mgmt btn-new-comments', 'escape' => false)
                            );
                        }elseif($post['unapproved_comments'] == 0 && $post['approved_comments'] > 0){
                            echo $this->Html->link(
                                '<i class="glyphicon glyphicon-comment"></i>',
                                array('controller' => 'comments', 'action' => 'manage', $post['id']),
                                array('class' => 'btn btn-sm btn-info btn-mgmt btn-post-comments', 'escape' => false)
                            );
                        }  ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>

