<div class="col-xs-12">
    <h3 style="margin-top: 10px;">
        <?php echo __('Manage comments - %s', h($post['Post']['title'])); ?>
    </h3>
    <hr />

    <?php if (empty($comments)): ?>

        <div class="alert alert-info">
            <p><?php echo __('No comments for this post.'); ?></p>
        </div>

    <?php else: ?>

        <!-- First loop for the comments which are waiting for validation -->
        <?php foreach ($comments as $comment): ?>

            <?php if(!$comment['Comment']['approved']): ?>

                <div class="panel panel-primary panel-comment">
                    <div class="panel-heading lg-panel-heading">
                        <?php echo __('Author: %s - Submitted on %s', h($comment['Comment']['author']), h($this->Time->format($comment['Comment']['created'], '%d/%m/%Y'))); ?>
                        <?php echo $this->Form->postLink(
                            '<i class="glyphicon glyphicon-ok"></i>',
                            array('controller' => 'comments', 'action' => 'approve', $comment['Comment']['id']),
                            array(
                                'class' => 'btn btn-sm btn-success btn-mgmt btn-comment-approve',
                                'escape' => false),
                            __('Are you sure?')
                        ); ?>
                        <?php echo $this->Form->postLink(
                            '<i class="glyphicon glyphicon-remove"></i>',
                            array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id']),
                            array(
                                'class' => 'btn btn-sm btn-danger btn-mgmt btn-comment-remove',
                                'escape' => false),
                            __('Are you sure?')
                        ); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $comment['Comment']['content']; ?>
                    </div>
                </div>

            <?php endif; ?>

        <?php endforeach; ?>

        <!-- Second loop for the validated comments -->
        <?php foreach($comments as $comment): ?>

            <?php if($comment['Comment']['approved']): ?>

                <div class="panel panel-default panel-comment">
                    <div class="panel-heading lg-panel-heading">
                        <?php echo __('Author: %s - Submitted on %s', h($comment['Comment']['author']), h($this->Time->format($comment['Comment']['created'], '%d/%m/%Y'))); ?>
                        <?php echo $this->Form->postLink(
                            '<i class="glyphicon glyphicon-ban-circle"></i>',
                            array('controller' => 'comments', 'action' => 'unapprove', $comment['Comment']['id']),
                            array(
                                'class' => 'btn btn-sm btn-info btn-mgmt btn-comment-approve',
                                'escape' => false),
                            __('Are you sure? ')
                        ); ?>
                        <?php echo $this->Form->postLink(
                            '<i class="glyphicon glyphicon-remove"></i>',
                            array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id']),
                            array(
                                'class' => 'btn btn-sm btn-danger btn-mgmt btn-comment-remove',
                                'escape' => false),
                            __('Are you sure? ')
                        ); ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $comment['Comment']['content']; ?>
                    </div>
                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>
</div>