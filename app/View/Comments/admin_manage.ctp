<div class="col-xs-12">
    <h3 style="margin-top: 10px;">
        <?php echo __('Manage comments - ').$post['Post']['title']; ?>
    </h3>
    <hr />

    <?php if(empty($unapproved_comments) && empty($approved_comments)){ ?>

        <div class="alert alert-info">
            <p><?= __('Unfortunately there is no comments for this post.'); ?></p>
        </div>

    <?php }else{ ?>

        <?php foreach($unapproved_comments as $unapproved_comment){ ?>

            <div class="panel panel-primary panel-comment">
                <div class="panel-heading panel-comment-heading">
                    <?php echo __('Author:').' '.$unapproved_comment['Comment']['author'].' - '.__('Submitted on ').$this->Time->format($unapproved_comment['Comment']['created'], '%d/%m/%Y'); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-ok"></i>',
                        array('controller' => 'comments', 'action' => 'approve', $unapproved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-success btn-comment-approve',
                            'escape' => false),
                        __('Are you sure? ')
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-remove"></i>',
                        array('controller' => 'comments', 'action' => 'delete', $unapproved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-danger btn-comment-remove',
                            'escape' => false),
                        __('Are you sure? ')
                    ); ?>
                </div>
                <div class="panel-body">
                    <?php echo $unapproved_comment['Comment']['content']; ?>
                </div>
            </div>

        <?php } ?>

        <?php foreach($approved_comments as $approved_comment){ ?>

            <div class="panel panel-default panel-comment">
                <div class="panel-heading panel-comment-heading">
                    <?php echo __('Author:').' '.$approved_comment['Comment']['author'].' - '.__('Submitted on ').$this->Time->format($approved_comment['Comment']['created'], '%d/%m/%Y'); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-ban-circle"></i>',
                        array('controller' => 'comments', 'action' => 'unapprove', $approved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-info btn-comment-approve',
                            'escape' => false),
                        __('Are you sure? ')
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-remove"></i>',
                        array('controller' => 'comments', 'action' => 'delete', $approved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-danger btn-comment-remove',
                            'escape' => false),
                        __('Are you sure? ')
                    ); ?>
                </div>
                <div class="panel-body">
                    <?php echo $approved_comment['Comment']['content']; ?>
                </div>
            </div>

        <?php } ?>

    <?php } ?>
</div>