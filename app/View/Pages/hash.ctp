<div class="container" style="margin-top: 70px;">
    <div class="col-xs-12">
        <p>
            <?= __('This page allows you to generate credentials for new users.'); ?>
        </p>
        <hr />
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <?= $this->Form->create('Page'); ?>
                <?= $this->Form->input('username', array('placeholder' => __('Username'), 'required')); ?>
                <?= $this->Form->input('password', array('placeholder' => __('Password'), 'required')); ?>
                <?= $this->Form->submit(__('Generate credentials'), array('class' => 'btn btn-lg btn-success pull-right')); ?>
                <?= $this->Form->end(); ?>
            </div>

            <?php if(isset($user)): ?>
            <div class="col-xs-12 col-sm-8 col-sm-offset-2" style="margin-top: 20px;">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <?= __('Credentials successfully generated!'); ?>
                    </div>
                    <div class="panel-body text-left">
                        <?= __('Username'); ?> : <?= $user['username']; ?><br />
                        <?= __('Password'); ?> : <?= $user['password']; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
    </div>
</div>