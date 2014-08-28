<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <?= __('You must login first'); ?>
            </div>
            <div class="panel-body text-left">
                <?= $this->Form->create('User', array('action' => 'login')); ?>
                <?= $this->Form->input('username', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>',
                    'placeholder' => __('Username'))); ?>
                <?= $this->Form->input('password', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>',
                    'placeholder' => __('Password'))); ?>
                <?= $this->Form->submit(__('Login'), array('class' => 'btn btn-success pull-right')); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>