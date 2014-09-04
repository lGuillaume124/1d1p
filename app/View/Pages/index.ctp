<?= $this->Html->css('jquery.fs.selecter', 'stylesheet', array('inline' => false)); ?>
<?= $this->start('script'); ?>
<?= $this->Html->script(array('jquery.fs.selecter', 'main')); ?>
<script type="text/javascript">
    <?php
        $photos = '';
        if(!empty($album['Post'])){
            foreach($album['Post'] as $p){
                if($p['itinerary']){
                    $photos .= '{id: "postMarker'.$p['id'].'", lat: '.$p['latitude'].', lng: '.$p['longitude'].', title: "<h6>'.$p['title'].'</h6>", itinerary: true}, ';
                }else{
                    $photos .= '{id: "postMarker'.$p['id'].'", lat: '.$p['latitude'].', lng: '.$p['longitude'].', title: "<h6>'.$p['title'].'</h6>"}, ';
                }
            }
            $photos = substr($photos, 0, -2);
        }
    ?>
    var posts = [<?= $photos; ?>];

    // Animations de l'interface
    $('.timeline-tooltip').tooltip();
    $("#aSelecter").selecter({
        links: true,
        label: "<?= __('Select another album'); ?>"
    });
</script>
<?= $this->end(); ?>

<div class="row main-wrap">
    <!-- Map -->
    <div class="default-block map" id="map"></div>

    <!-- Timeline -->
    <div class="default-block timeline" id="timeline">
        <script>
            var lazy = lazyload({
                container: document.getElementById('timeline')
            });
        </script>

        <?= $this->Session->flash(); ?>

        <?php if(empty($album)){ ?>
            <div class="alert alert-info">
                <h4><?= __('Welcome !'); ?></h4>
                <p><?= __('Unfortunately there is nothing to see here.'); ?></p>
            </div>
        <?php }else{ ?>
            <div class="col-xs-12">
                <!-- Albums selecter -->
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
                    <!-- Timeline -->
                    <div class="jumbotron">
                        <div class="jumbotron-photo">
                            <?= $this->Image->lazyload($this->Image->thumbPath('photos'.DS.$post['picture'], 540)); ?>
                        </div>
                        <div class="jumbotron-contents">
                            <h5>
                                <?= $post['title']; ?><br />
                                <small><?= $this->Time->format($post['post_dt'], '%d/%m/%Y - %H:%M').' '.$post['post_dt_offset']; ?></small>
                            </h5>
                            <p><?= $post['content']; ?></p>
                             <span class="timeline-icon show-comments" post-id="<?php echo$post['id']; ?>" style="margin-left: 0;">
                                0 <i class="glyphicon glyphicon-comment"></i>
                            </span>
                            <span class="timeline-icon">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-map-marker"></i>',
                                    'javascript:void(0)',
                                    array(
                                        'class' => 'timeline-tooltip icon-marker',
                                        'id' => 'postMarker'.$post['id'],
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data-original-title' => __('Show'),
                                        'title' => __('Show'),
                                        'escape' => false
                                    )
                                ); ?>
                            </span>
                            <span class="timeline-icon">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-globe"></i>',
                                    'javascript:void(0)',
                                    array(
                                        'class' => 'timeline-tooltip',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'right',
                                        'title' => $post['latitude'].' '.$post['longitude'],
                                        'style' => 'cursor: default;',
                                        'escape' => false
                                    )
                                ); ?>
                            </span>
                            <span class="timeline-icon pull-right">
                                <?= $this->Html->link('<i class="glyphicon glyphicon-zoom-in"></i>',
                                    array('controller' => 'img', 'action' => 'photos/'.$post['picture']),
                                    array(
                                        'class' => 'timeline-tooltip',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => __('Full size'),
                                        'escape' => false
                                    )
                                ); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Comments wrapper -->
                    <div class="well comments-well" id="<?php echo 'comments-container-'.$post['id']; ?>">
                        <a href="<?= '#comModal'.$post['id']; ?>" data-toggle="modal">Ajouter un commentaire</a>
                    </div>

                    <!-- Comment form -->
                    <div class="modal fade" id="<?= 'comModal'.$post['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="<?= 'comModal'.$post['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?= $this->Form->create('Comment', array('action' => 'add')); ?>
                                <?= $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['id'])); ?>
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= __('Close'); ?></span></button>
                                    <h4 class="modal-title"><?= __('Add a comment for: ').$post['title']; ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?= $this->Form->input('author', array(
                                        'div' => array('class' => 'form-group input-group'),
                                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>',
                                        'placeholder' => __('Your name'),
                                        'required' => true
                                    )); ?>
                                    <?= $this->Form->input('content', array(
                                        'type' => 'textarea',
                                        'div' => array('class' => 'form-group'),
                                        'placeholder' => __('Here your comment'),
                                        'required' => true
                                    )); ?>
                                </div>
                                <div class="modal-footer">
                                    <?= $this->Form->submit(__('Send '), array('class' => 'btn btn-success', 'escape' => false)); ?>
                                </div>
                                <?= $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>
</div>
