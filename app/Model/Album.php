<?php

App::uses('AppModel', 'Model');

class Album extends AppModel {
    public $name = 'Album';
    public $hasMany = array(
        'Post' => array(
            'dependent' => true,
            'order' => 'Post.post_dt DESC'
        ));

    public $validate = array(
        'title' => array(
            'rule2' => array(
                'rule' => 'notEmpty',
                'required' => true
            ),
            'rule3' => array(
                'rule' => 'isUnique',
                'required' => true
            )
        )
    );
}