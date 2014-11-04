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
	?>
</head>
<body>

    <?php echo $this->fetch('content'); ?>

    <script>
        var baseurl = "<?php echo $this->request->base; ?>"
    </script>

    <?php echo $this->Html->script(array('jquery-2.1.0.min', 'blazy.min', 'bootstrap.min', 'leaflet')) ?>
    <script>
        $(document).ready(function(){
            var bLazy = new Blazy({
                selector: 'img',
                offset: 250,
                container: '#timeline',
                success: function(element){
                    setTimeout(function(){
                        var parent = element.parentNode;
                        parent.className = parent.className.replace('img-loading','');
                        console.log(parent);
                    }, 200);
                }
            });
        });
    </script>
    <?php echo $this->fetch('script'); ?>
</body>
</html>
