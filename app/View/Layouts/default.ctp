<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
        echo $this->Html->meta('icon');
		echo $this->Html->css(array('bootstrap.min', 'bootflat.min', 'style', 'leaflet'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('lazyload.min');
	?>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-default nav-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <?= $this->Html->link('One Day - One Picture', '/', array('class' => 'navbar-brand')); ?>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><button type="button" class="btn btn-success navbar-btn" data-toggle="modal" data-target="#loginModal"><?= __('Login'); ?></button></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="col-xs-12 flash-default">
        <?= $this->Session->flash(); ?>
    </div>

    <?= $this->fetch('content'); ?>

    <!-- Login form -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?= $this->Form->create('User', array('action' => 'login')); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= __('Close'); ?></span></button>
                    <h4 class="modal-title"><?= __('Login'); ?></h4>
                </div>
                <div class="modal-body">
                    <?= $this->Form->input('username', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>',
                        'placeholder' => __('Username'))); ?>
                    <?= $this->Form->input('password', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>',
                        'placeholder' => __('Password'))); ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->submit(__('Login'), array('class' => 'btn btn-success')); ?>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>

    <script>
        var baseurl = "<?php echo $this->request->base; ?>"
    </script>

    <?= $this->Html->script(array('jquery-2.1.0.min', 'bootstrap.min', 'leaflet')) ?>
    <?= $this->fetch('script'); ?>
</body>
</html>
