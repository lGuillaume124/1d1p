<?= $this->start('script'); ?>
<?= $this->Html->script('maputils'); ?>
<script type="text/javascript">
    var map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap',
        maxZoom: 18
    }).addTo(map);

    $(document).ready(function(){
        $('#PostFile').change(function(){
            $('#map').css('min-height', '274px');
            $('#upload-progress').fadeIn(500);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/posts/upload');
            xhr.onload = function(){
                console.log(xhr.responseText);
                var response = JSON.parse(xhr.responseText);

                if(response.error != null){
                    $('#upload-progress-bar').addClass('progress-bar-danger');
                    alert(response.error);
                }

                if(response.photo != null){
                    $('#upload-progress-bar').addClass('progress-bar-success');
                    $('#upload-progress').delay(1500).fadeOut(1000);
                    $('#map').delay(3000).queue(function(next){
                        $(this).css('min-height', '314px');
                        next();
                    });
                    $('#PostPostDt').val(response.datetime_original);
                    if(response.coordinates != null){
                        $('#latitude').val(response.coordinates.latitude);
                        $('#longitude').val(response.coordinates.longitude);
                        placeMarker(response.coordinates, response.photo);

                    }else{
                        navigator.geolocation.getCurrentPosition(function(position){
                            $('#latitude').val(position.coords.latitude);
                            $('#longitude').val(position.coords.longitude);
                            placeMarker(position.coords, response.photo);
                        }, function(error){
                            console.log(error);
                        });
                    }
                    $('#PostPicture').val(response.photo);
                }else{
                    $('#upload-progress-bar').addClass('progress-bar-danger');
                }
            };
            xhr.upload.onprogress = function(e){
                $('#upload-progress-bar').css('width', (e.loaded/e.total)*100+"%");
            };
            var form = new FormData();
            form.append('data[Post][file]', $(this)[0].files[0]);
            xhr.send(form);
        });

        $('#PostAddForm').submit(function(){
            ('#Post.File').remove();
        });
    });
</script>
<?= $this->end(); ?>
<div class="container dashboard-container">

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
                    <div class="col-xs-12" id="map">

                    </div>
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