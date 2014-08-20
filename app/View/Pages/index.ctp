<?= $this->Html->css('jquery.fs.selecter', 'stylesheet', array('inline' => false)); ?>
<?= $this->start('script'); ?>
<?= $this->Html->script(array('jquery.fs.selecter', 'maputils', 'main')); ?>
<script type="text/javascript">
    var map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Powered by OpenStreetMap',
        maxZoom: 18
    }).addTo(map);
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.timeline-tooltip').tooltip();
        $("#aSelecter").selecter({
            links: true,
            label: "<?= __('Select another album'); ?>"
        });
    });
</script>
<?= $this->end(); ?>
<div class="row map-container">
    <div class="main-block map" id="map"></div>
    <div class="main-block timeline">
        <?php if(empty($album)): ?>
            <div class="alert alert-info">
                <h4><?= __('Welcome !'); ?></h4>
                <p><?= __('Unfortunately there is nothing to see here.'); ?></p>
            </div>
        <?php endif; ?>
        <?php if(!empty($album)): ?>
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?= $album['Album']['title'].' ('.__n("%s photo", "%s photos", count($album['Post']), count($album['Post'])).') - '.__('Created on ').$this->Time->format($album['Album']['created'], '%d/%m/%Y'); ?>
                    </div>
                    <?php if(count($albums) >= 1): ?>
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <?= $this->Form->create(); ?>
                                <?= $this->Form->input('fields', array(
                                    'id' => 'aSelecter',
                                    'label' => false,
                                    'options' => $albums
                                )); ?>
                                <?= $this->Form->end(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php foreach($album['Post'] as $post): ?>
                    <div class="jumbotron">
                        <dv class="jumbotron-photo">
                            <?= $this->Image->lazyload($this->Image->thumbPath('photos'.DS.$post['picture'], 540)); ?>
                        </dv>
                        <div class="jumbotron-contents">
                            <h5>
                                <?= $post['title']; ?><br />
                                <small><?= $this->Time->format($post['post_dt'], '%d/%m/%Y - %H:%M').' '.$post['post_dt_offset']; ?></small>
                            </h5>
                            <p><?= $post['content']; ?></p>
                            <!-- Not yet
                            <span class="timeline-icon">
                                <?= $this->Html->link('0 <i class="glyphicon glyphicon-comment"></i>',
                                    array(''),
                                    array('escape' => false)); ?>
                            </span>
                            -->
                            <span class="timeline-icon">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-map-marker"></i>',
                                    array(''),
                                    array(
                                        'class' => 'timeline-tooltip',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data-original-title' => __('Show on the map'),
                                        'title' => __('Show on the map'),
                                        'escape' => false)); ?>
                            </span>
                            <span class="timeline-icon">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-globe"></i>',
                                    array(''),
                                    array(
                                        'class' => 'timeline-tooltip',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'right',
                                        'title' => $post['latitude'].' '.$post['longitude'],
                                        'escape' => false)); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>