<div class="container" style="padding-top: 20px;">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo __('One Day, One Picture - Login'); ?>
            </div>
            <div class="panel-body text-left">
                <?php echo $this->Form->create('User', array('action' => 'login')); ?>
                <?php echo $this->Form->input('username', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>',
                    'placeholder' => __('Username'))); ?>
                <?php echo $this->Form->input('password', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>',
                    'placeholder' => __('Password'))); ?>
                <?php echo $this->Form->submit(__('Login'), array('class' => 'btn btn-success pull-right')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>