<div class="col-xs-12">
    <h3 style="margin-top: 10px;">
        <?php echo __('Manage comments unread comments'); ?>
    </h3>
    <hr />

    <?php if(empty($unapproved_comments)){ ?>

        <div class="alert alert-info">
            <p><?php echo __('All comments has been moderated.'); ?></p>
        </div>

    <?php }else{ ?>

        <?php foreach($unapproved_comments as $unapproved_comment){ ?>

            <div class="panel panel-primary panel-comment">
                <div class="panel-heading lg-panel-heading">
                    <?php echo __('Author:').' '.$unapproved_comment['Comment']['author'].' - '.__('Submitted on').' '.$this->Time->format($unapproved_comment['Comment']['created'], '%d/%m/%Y'); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-ok"></i>',
                        array('controller' => 'comments', 'action' => 'approve', $unapproved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-success btn-mgmt btn-comment-approve',
                            'escape' => false),
                        __('Are you sure?')
                    ); ?>
                    <?php echo $this->Form->postLink(
                        '<i class="glyphicon glyphicon-remove"></i>',
                        array('controller' => 'comments', 'action' => 'delete', $unapproved_comment['Comment']['id']),
                        array(
                            'class' => 'btn btn-sm btn-danger btn-mgmt btn-comment-remove',
                            'escape' => false),
                        __('Are you sure?')
                    ); ?>
                </div>
                <div class="panel-body">
                    <?php echo $unapproved_comment['Comment']['content']; ?>
                </div>
            </div>

        <?php } ?>

    <?php } ?>
</div>