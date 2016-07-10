<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('bootstrap.min', 'bootflat.min', 'style', 'leaflet', 'blue'));
        echo $this->fetch('meta');
        echo $this->fetch('css');
		echo $this->Html->script(array('jquery-2.2.4.min', 'lazyload.min'));
    ?>
    <script type="text/javascript">
        var baseurl = "<?php echo $this->request->base; ?>"
	    var window_height = $(window).height();
        var lazy = lazyload({
            offset: window_height
        });
	</script>
</head>
<body>
    <?php if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'home'): ?>
        <nav class="navbar navbar-inverse navbar-default nav-default" role="navigation">
    <?php else: ?>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php endif;  ?>
        <div class="container-fluid">
            <div class="navbar-header">
                <?php echo $this->Html->link(
                    'One Day, One Picture',
                    array('controller' => 'pages', 'action' => 'index', 'admin' => true),
                    array('class' => 'navbar-brand')
                ); ?>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?php echo $this->Html->link(
                            __('Dashboard'),
                            array('controller' => 'pages', 'action' => 'index', 'admin' => true)
                        ); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link(
                            __('Map'),
                            array('controller' => 'pages', 'action' => 'index', 'home', 'admin' => false)
                        ); ?>
                    </li>
                    <?php if(isset($unread_comments) && $unread_comments > 0): ?>
                    <li>
                        <?php echo $this->Html->link(
                            __('Comments').' (<strong>'.$unread_comments.'</strong>)',
                            array('controller' => 'comments', 'action' => 'unread', 'admin' => true),
                            array('escape' => false)
                        ); ?>
                    </li>
                    <?php endif; ?>
                    <li>
                        <?php echo $this->Html->link(
                            __('Users'),
                            array('controller' => 'users', 'action' => 'index', 'admin' => true)
                        ); ?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php echo $this->Html->link(
                            '<i class="glyphicon glyphicon-log-out"></i>',
                            array('controller' => 'users', 'action' => 'logout', 'admin' => false),
                            array('title' => __('Logout'), 'escape' => false)); ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'home') {
        echo $this->fetch('content');
    } else { ?>
        <div class="container" style="margin-top: 60px;">
            <div class="col-xs-12" style="margin-top: 10px">
                <?php echo $this->Session->flash(); ?>
            </div>
            <?php echo $this->fetch('content'); ?>
        </div>
    <?php } ?>

    <?php echo $this->Html->script(array('bootstrap.min', 'leaflet')) ?>
    <?php echo $this->fetch('script'); ?>
</body>
</html>
