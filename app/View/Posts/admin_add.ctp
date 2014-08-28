<?= $this->start('script'); ?>
<?= $this->Html->script(array('maputils', 'upload')); ?>
<script type="text/javascript">
    var map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap',
        maxZoom: 18
    }).addTo(map);
</script>
<?= $this->end(); ?>
<div class="container" style="margin-top: 50px;">
    <div class="col-xs-12">
        <h3><?= __('Add a photo in : ').$album['Album']['title']; ?></h3>
        <hr />
        <?= $this->Form->create('Post', array('action' => 'add', 'enctype' => 'multipart/form-data')); ?>
        <?= $this->Form->input('album_id', array('type' => 'hidden', 'value' => $album['Album']['id'])); ?>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= '1. '.__('Upload your photo'); ?>
                </div>
                <div class="panel-body text-left">
                    <div class="form-group">
                        <?= $this->Form->file('file', array('type' => 'file')); ?>
                        <?= $this->Form->input('picture', array('type' => 'hidden')); ?>
                    </div>
                    <div class="progress" id="upload-progress">
                        <div class="progress-bar" id="upload-progress-bar">
                        </div>
                    </div>
                    <div class="col-xs-12" id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= '2. '.__('Add a short description'); ?>
                </div>
                <div class="panel-body text-left">
                    <?= $this->Form->input('title', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>',
                        'placeholder' => __('Location of the photo'))); ?>
                    <?= $this->Form->input('post_dt', array(
                        'div' => array('class' => 'form-group input-group'),
                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>',
                        'type' => 'text',
                        'placeholder' => __('Datetime')
                    )); ?>
                    <?= $this->Form->input('content', array(
                        'type' => 'textarea',
                        'div' => array('class' => 'form-group'),
                        'placeholder' => __('Here a short description'))); ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <?= $this->Form->input('latitude', array(
                                'id' => 'latitude',
                                'div' => array('class' => 'form-group input-group'),
                                'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>',
                                'type' => 'text',
                                'placeholder' => __('Latitude'),
                                'disabled' => false
                            )); ?>
                        </div>
                        <div class="col-xs-6">
                            <?= $this->Form->input('longitude', array(
                                'id' => 'longitude',
                                'div' => array('class' => 'form-group input-group'),
                                'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>',
                                'type' => 'text',
                                'placeholder' => __('Longitude'),
                                'disabled' => false,
                            )); ?>
                        </div>
                    </div>
                    <?= $this->Form->submit(__('Save'), array('class' => 'btn btn-lg btn-success pull-right')); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>