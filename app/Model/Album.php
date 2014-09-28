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
            'ruleNotEmpty' => array(
                'rule' => 'notEmpty',
                'required' => true
            ),
            'ruleIsUnique' => array(
                'rule' => 'isUnique',
                'required' => true
            )
        )
    );
}