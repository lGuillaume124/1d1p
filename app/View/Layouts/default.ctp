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

    <?php echo $this->fetch('content'); ?>

    <script>
        var baseurl = "<?php echo $this->request->base; ?>"
    </script>

    <?php echo $this->Html->script(array('jquery-2.1.0.min', 'bootstrap.min', 'leaflet')) ?>
    <?php echo $this->fetch('script'); ?>
</body>
</html>
