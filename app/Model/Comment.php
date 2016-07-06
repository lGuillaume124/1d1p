<?php

App::uses('AppModel', 'Model');

class Comment extends AppModel {
    public $name = 'Comment';

    public $validate = array(
        'author'    => 'notBlank',
        'content'   => 'notBlank',
        'approved'  => 'boolean',
        'post_id'   => array(
            'ruleNotEmpty'  => array(
                'rule' => 'notEmpty',
                'required' => true
            ),
            'ruleIsNumeric' => array(
                'rule' => 'numeric',
                'required' => true
            )
        ),
        'album_id'   => array(
            'ruleNotEmpty'  => array(
                'rule' => 'notBlank',
                'required' => true
            ),
            'ruleIsNumeric' => array(
                'rule' => 'numeric',
                'required' => true
            )
        )
    );
}