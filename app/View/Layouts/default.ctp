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
    <!--
    <nav class="navbar navbar-inverse navbar-default nav-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <?= $this->Html->link('One Day, One Picture', '/', array('class' => 'navbar-brand')); ?>
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
    -->
    <?= $this->fetch('content'); ?>

    <script>
        var baseurl = "<?php echo $this->request->base; ?>"
    </script>

    <?= $this->Html->script(array('jquery-2.1.0.min', 'bootstrap.min', 'leaflet')) ?>
    <?= $this->fetch('script'); ?>
</body>
</html>
