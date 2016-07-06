<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $name = 'User';

    public $validate = array(
        'username' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Username already used',
                'required' => true
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'The username cannot be empty',
                'required' => true
            )
        ),
        'password' => array(
            'minLength' => array(
                'rule' => array('minLength', 12),
                'message' => 'Your password must be at least 12 characters long',
                'required' => true
            )
        )
    );

    public function beforeSave ($options = array()) {

        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }

        return true;
    }
}