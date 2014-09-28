<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $name = 'Post';
    public $belongsTo = 'Album';
    public $hasMany = array(
      'Comment' => array(
          'dependent' => true
      )
    );

    public function afterFind($results, $primary = false){
        foreach($results as $key => $value){
            if(isset($val['Post']['post_dt'])){
                $results[$key]['Post']['post_dt'] = $this->dateFormatAfterFind($val['Post']['post_dt']);
            }
        }

        return $results;
    }

    public function beforeDelete($cascade = false){
        $post = $this->findById($this->id);
        $picture = IMAGES.'photos'.DS.$post['Post']['picture'];

        if(file_exists($picture)){
            unlink($picture);
        }

        return true;
    }

    public function beforeSave($options = array()){
        if(!empty($this->data['Post']['post_dt'])){
            $this->data['Post']['post_dt'] = $this->dateFormatBeforeSave($this->data['Post']['post_dt']);
        }

        App::uses('Xml', 'Utility');
        App::uses('HttpSocket', 'Network/Http');
        $http = new HttpSocket();
        $response = $http->get('http://www.earthtools.org/timezone/'.$this->data['Post']['latitude'].'/'.$this->data['Post']['longitude']);

        if($response->code == '200'){
            $response = Xml::toArray(Xml::build($response->body()));
            $response = 'GMT'.$response['timezone']['offset'];
        }else{
            $response = '';
        }

        $this->data[$this->alias]['post_dt_offset'] = $response;

        return true;
    }

    public function dateFormatAfterFind($datestring){
        return date('d F Y H:i', strtotime($datestring));
    }

    public function dateFormatBeforeSave($dateString){
        return date('Y-m-d H:i:s', strtotime($dateString));
    }
}