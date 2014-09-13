<?php echo $this->Html->css('jquery.fs.selecter', 'stylesheet', array('inline' => false)); ?>
<?php echo $this->start('script'); ?>
<?php echo $this->Html->script(array('jquery.fs.selecter', 'main')); ?>
<script type="text/javascript">
    <?php
        $photos = '';
        if(!empty($album['Post'])){
            foreach($album['Post'] as $p){
                if($p['itinerary']){
                    $photos .= '{id: "postMarker'.$p['id'].'", lat: '.$p['latitude'].', lng: '.$p['longitude'].', title: "'.$p['title'].'", itinerary: true}, ';
                }else{
                    $photos .= '{id: "postMarker'.$p['id'].'", lat: '.$p['latitude'].', lng: '.$p['longitude'].', title: "'.$p['title'].'"}, ';
                }
            }
            $photos = substr($photos, 0, -2);
        }
    ?>
    var posts = [<?php echo $photos; ?>];

    // Animations de l'interface
    $('.timeline-tooltip').tooltip();
    $("#aSelecter").selecter({
        links: true,
        label: "<?php echo __('Select another album'); ?>"
    });
</script>
<?php echo $this->end(); ?>

<div class="row main-wrap">
    <!-- Map -->
    <div class="default-block map" id="map"></div>

    <!-- Timeline -->
    <div class="default-block timeline" id="timeline">
        <script>
            var lazy = lazyload({
                container: document.getElementById('timeline'),
                offset: 750
            });
        </script>

        <?php echo $this->Session->flash(); ?>

        <?php if(empty($album)){ ?>
            <div class="alert alert-info">
                <h4><?php echo __('Welcome !'); ?></h4>
                <p><?php
                    echo __('Nothing to see here.');
                    if(null == AuthComponent::user('id')){
                        echo '<strong>'.$this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'), array('style' => 'color: #31708F;')).'</strong>.';
                    }
                ?></p>
            </div>
        <?php }else{ ?>
            <div class="col-xs-12">
                <!-- Albums selecter -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <?php echo $album['Album']['title'].' ('.__n("%s photo", "%s photos", count($album['Post']), count($album['Post'])).') - '.__('Created on').' '.$this->Time->format($album['Album']['created'], '%d/%m/%Y'); ?>
                        <?php if(null == AuthComponent::user('id')){
                            echo $this->Html->link(
                                '<i class="glyphicon glyphicon-log-in"></i>',
                                array('controller' => 'users', 'action' => 'login'),
                                array(
                                    'class' => 'timeline-tooltip pull-right',
                                    'style' => 'color: #FFFFFF;',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'bottom',
                                    'data-original-title' => __('Login'),
                                    'title' => __('Login'),
                                    'escape' => false
                                )
                            );
                        }
                        ?>
                    </div>
                    <?php if(count($albums) >= 1): ?>
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <?php echo $this->Form->create(); ?>
                                <?php echo $this->Form->input('fields', array(
                                    'id' => 'aSelecter',
                                    'label' => false,
                                    'options' => $albums
                                )); ?>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php foreach($album['Post'] as $post): ?>
                    <!-- Timeline -->
                    <div class="jumbotron">
                        <div class="jumbotron-photo">
                            <?php echo $this->Image->lazyload($this->Image->thumbPath('photos'.DS.$post['picture'], 540)); ?>
                        </div>
                        <div class="jumbotron-contents">
                            <h5>
                                <?php echo $post['title']; ?><br />
                                <small><?php echo $this->Time->format($post['post_dt'], '%d/%m/%Y - %H:%M').' '.$post['post_dt_offset']; ?></small>
                            </h5>
                            <p><?php echo $post['content']; ?></p>
                            <span class="timeline-icon show-comments" post-id="<?php echo $post['id']; ?>" comments-counter="<?php echo $post['comments_counter']; ?>" style="margin-left: 0;">
                                <?php if(isset($post['comments_counter'])){
                                    echo $post['comments_counter'];
                                } ?>
                                <i class="glyphicon glyphicon-comment"></i>
                            </span>
                            <span class="timeline-icon">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-map-marker"></i>',
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
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-globe"></i>',
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
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-zoom-in"></i>',
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
                        <div class="add-comment-block">
                            <a href="<?php echo '#comModal'.$post['id']; ?>" data-toggle="modal"><?php echo __('Add comment'); ?></a>
                            <?php echo $this->Html->image('loader.gif', array('class' => 'pull-right comments-loader', 'id' => 'comments-loader-'.$post['id'])); ?>
                        </div>

                    </div>

                    <!-- Comment form -->
                    <div class="modal fade" id="<?php echo 'comModal'.$post['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo 'comModal'.$post['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <?php echo $this->Form->create('Comment', array('action' => 'add')); ?>
                                <?php echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $post['id'])); ?>
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Close'); ?></span></button>
                                    <h4 class="modal-title"><?php echo __('Add a comment for:').' '.$post['title']; ?></h4>
                                </div>
                                <div class="modal-body">
                                    <?php echo $this->Form->input('author', array(
                                        'div' => array('class' => 'form-group input-group'),
                                        'before' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>',
                                        'placeholder' => __('Your name'),
                                        'required' => true
                                    )); ?>
                                    <?php echo $this->Form->input('content', array(
                                        'type' => 'textarea',
                                        'div' => array('class' => 'form-group'),
                                        'placeholder' => __('Here your comment'),
                                        'required' => true
                                    )); ?>
                                </div>
                                <div class="modal-footer">
                                    <?php echo $this->Form->submit(__('Send '), array('class' => 'btn btn-success', 'escape' => false)); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>
</div>
