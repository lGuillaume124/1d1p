<?= $this->start('script'); ?>
<?= $this->Html->script('icheck.min'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        var title = $('#PostTitle').val()
        var coordinates = L.latLng($('#latitude').val(), $('#longitude').val());
        var map = L.map('map').setView(coordinates, 13);

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18
        }).addTo(map);

        var marker = L.marker(coordinates, {draggable: true, title: title}).addTo(map);
        marker.addEventListener('dragend', function(){
            $('#latitude').val(marker.getLatLng().lat);
            $('#longitude').val(marker.getLatLng().lng);
        });

        $('#latitude').blur(function() {
            coordinates = L.latLng($('#latitude').val(), $('#longitude').val());
            marker.setLatLng(coordinates);
            map.setView(coordinates);
        });

        $('#longitude').blur(function() {
            coordinates = L.latLng($('#latitude').val(), $('#longitude').val());
            marker.setLatLng(coordinates);
            map.setView(coordinates);
        });
    });
</script>
<?= $this->end(); ?>

<div class="col-xs-12">
    <h3><?= __('Edit a photo'); ?></h3>
    <hr />
    <?= $this->Form->create('Post', array('action' => 'edit')); ?>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?= __('Location'); ?>
            </div>
            <div class="panel-body text-left">
                <div class="col-xs-12" id="map" style="min-height: 386px;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?= __('Description'); ?>
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
                    <div class="col-xs-12">
                        <?= $this->Form->input('itinerary', array(
                            'div' =>  array('style' => 'position: relative;'),
                            'label' => __('Add to itinerary'),
                            'type' => 'checkbox'
                        )); ?>
                    </div>
                </div>
                <?= $this->Form->submit(__('Save'), array('class' => 'btn btn-lg btn-success pull-right')); ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>

