<?php

App::uses('FormHelper', 'View/Helper');

class BootstrapFormHelper extends FormHelper{

    public function create($model = null, $options = array()) {

        $defaultOptions = array(
            'inputDefaults' => array(
                'div' => array('class' => 'form-group'),
                'label' => false,
                'class' => 'form-control'
            )
        );

        $options = array_merge($defaultOptions, $options);
        return parent::create($model, $options);
    }

    public function input($fieldName, $options = array()) {

        $this->setEntity($fieldName);
        $defaultOptions = $this->_parseOptions($options);

        return parent::input($fieldName, $options);
    }
}