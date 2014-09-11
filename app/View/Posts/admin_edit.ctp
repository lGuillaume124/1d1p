<?php echo $this->start('script'); ?>
<?php echo $this->Html->script('icheck.min'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });

        var title = $('#PostTitle').val();
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
<?php echo $this->end(); ?>

<div class="col-xs-12">
    <h3><?php echo __('Edit a photo'); ?></h3>
    <hr />
    <?php echo $this->Form->create('Post', array('action' => 'edit')); ?>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo __('Location'); ?>
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
                <?php echo __('Description'); ?>
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
                    <div class="col-xs-12">
                        <?php echo $this->Form->input('itinerary', array(
                            'div' =>  array('style' => 'position: relative;'),
                            'label' => __('Add to itinerary'),
                            'type' => 'checkbox'
                        )); ?>
                    </div>
                </div>
                <?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-lg btn-success pull-right')); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

