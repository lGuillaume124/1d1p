<?php echo $this->start('script'); ?>
<?php echo $this->Html->script(array('maputils', 'upload', 'icheck.min')); ?>
<script type="text/javascript">
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue'
    });
    var map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);
</script>
<?php echo $this->end(); ?>

<div class="col-xs-12">
    <h3><?php echo __('Add a photo in:').' '.$album['Album']['title']; ?></h3>
    <hr />
    <?php echo $this->Form->create('Post', array('action' => 'add', 'enctype' => 'multipart/form-data', 'id' => 'AddPostForm')); ?>
    <?php echo $this->Form->input('album_id', array('type' => 'hidden', 'value' => $album['Album']['id'])); ?>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo '1. '.__('Upload your photo.'); ?>
            </div>
            <div class="panel-body text-left">
                <div class="form-group">
                    <?php echo $this->Form->file('file', array('type' => 'file')); ?>
                    <?php echo $this->Form->input('picture', array('type' => 'hidden')); ?>
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
                <?php echo '2. '.__('Add a short description.'); ?>
            </div>
            <div class="panel-body text-left">
                <?php echo $this->Form->input('title', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>',
                    'placeholder' => __('Location of the photo'))); ?>
                <?php echo $this->Form->input('post_dt', array(
                    'div' => array('class' => 'form-group input-group'),
                    'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>',
                    'type' => 'text',
                    'placeholder' => __('Datetime')
                )); ?>
                <?php echo $this->Form->input('content', array(
                    'type' => 'textarea',
                    'div' => array('class' => 'form-group'),
                    'placeholder' => __('Here a short description'))); ?>
                <div class="row">
                    <div class="col-xs-6">
                        <?php echo $this->Form->input('latitude', array(
                            'id' => 'latitude',
                            'div' => array('class' => 'form-group input-group'),
                            'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>',
                            'type' => 'text',
                            'placeholder' => __('Latitude'),
                            'disabled' => false
                        )); ?>
                    </div>
                    <div class="col-xs-6">
                        <?php echo $this->Form->input('longitude', array(
                            'id' => 'longitude',
                            'div' => array('class' => 'form-group input-group'),
                            'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>',
                            'type' => 'text',
                            'placeholder' => __('Longitude'),
                            'disabled' => false,
                        )); ?>
                    </div>
                </div>
                <div class="col-xs-12" style="padding-left: 0;">
                    <?php echo $this->Form->input('itinerary', array(
                        'div' =>  array('style' => 'position: relative;'),
                        'label' => __('Add to itinerary'),
                        'type' => 'checkbox'
                    )); ?>
                </div>
                <?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-lg btn-success pull-right')); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>