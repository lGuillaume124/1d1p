<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $name = 'Post';
    public $belongsTo = 'Album';

    public function afterFind($results, $primary = false){
        foreach($results as $key => $value){
            if(isset($val['Post']['post_dt'])){
                $results[$key]['Post']['post_dt'] = $this->dateFormatAfterFind($val['Post']['post_dt']);
            }
        }
        return $results;
    }

    public function beforeSave($options = array()){
        if(!empty($this->data['Post']['post_dt'])){
            $this->data['Post']['post_dt'] = $this->dateFormatBeforeSave($this->data['Post']['post_dt']);
        }
        return true;
    }

    public function dateFormatAfterFind($datestring){
        return date('d F Y H:i', strtotime($datestring));
    }

    public function dateFormatBeforeSave($dateString){
        return date('Y-m-d H:i:s', strtotime($dateString));
    }
}