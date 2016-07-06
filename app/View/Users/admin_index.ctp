<div class="col-xs-12">
    <h3 style="margin-top: 10px;">
        <?php echo __('Users management'); ?>
    </h3>
    <hr />

    <?php if (count($users) > 1): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><?php echo __('Username'); ?></th>
                        <th class="text-center"><?php echo __('Status'); ?></th>
                        <th class="text-center"><?php echo __('Management'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user['User']['username'] != AuthComponent::user('username')): ?>
                            <tr>
                                <td>
                                    <?php echo $user['User']['username']; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($user['User']['is_active']): ?>
                                        <span class="label label-primary"><?php echo __('Active'); ?></span>
                                    <?php else: ?>
                                        <span class="label label-warning"><?php echo __('Inactive'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($user['User']['is_active']): ?>
                                        <?php echo $this->Form->postLink(
                                            '<i class="glyphicon glyphicon-ban-circle"></i>',
                                            array('controller' => 'users', 'action' => 'disable', $user['User']['id']),
                                            array('class' => 'btn btn-xs btn-warning', 'escape' => false),
                                            __('Are you sure?')
                                        ); ?>
                                    <?php else: ?>
                                        <?php echo $this->Form->postLink(
                                            '<i class="glyphicon glyphicon-ok"></i>',
                                            array('controller' => 'users', 'action' => 'enable', $user['User']['id']),
                                            array('class' => 'btn btn-xs btn-success', 'escape' => false),
                                            __('Are you sure?')
                                        ); ?>
                                    <?php endif; ?>

                                    <?php echo $this->Form->postLink(
                                        '<i class="glyphicon glyphicon-trash"></i>',
                                        array('controller' => 'users', 'action' => 'delete', $user['User']['id']),
                                        array('class' => 'btn btn-xs btn-danger', 'escape' => false),
                                        __('Are you sure?')
                                    ); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <?php echo __('You are the only one here, no users to manage.'); ?>
        </div>
    <?php endif; ?>
</div>
