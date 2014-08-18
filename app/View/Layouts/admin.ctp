<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array('bootstrap.min.css', 'bootflat.min', 'style', 'leaflet'));
        echo $this->fetch('meta');
        echo $this->fetch('css');
    ?>
</head>
<body style="margin-top: -70px;">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <?= $this->Html->link(
                    'One Day - One Picture',
                    array('controller' => 'pages', 'action' => 'index', 'admin' => true),
                    array('class' => 'navbar-brand')
                ); ?>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?= $this->Html->link(
                            __('Dashboard'),
                            array('controller' => 'pages', 'action' => 'index', 'admin' => true)
                        ); ?>
                    </li>
                    <li>
                        <?= $this->Html->link(
                            __('Map'),
                            array('controller' => 'pages', 'action' => 'index', 'admin' => false)
                        ); ?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?= $this->Html->link(
                            '<i class="glyphicon glyphicon-log-out"></i>',
                            array('controller' => 'users', 'action' => 'logout', 'admin' => false),
                            array('title' => __('Logout'), 'escape' => false)); ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container" style="margin-top: 140px; margin-bottom: -70px;">
    <?= $this->Session->flash(); ?>
</div>

<?= $this->fetch('content'); ?>

<?= $this->Html->script(array('jquery-2.1.0.min', 'bootstrap.min', 'leaflet', 'lazyload.min')) ?>
<?= $this->fetch('script'); ?>
</body>
</html>
