<?php

App::uses('AppModel', 'Model');

class Comment extends AppModel {
    public $name = 'Comment';
    public $belongsTo = 'Post';
}