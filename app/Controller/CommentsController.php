<?php

App::uses('AppController', 'Controller');

class CommentsController extends AppController {

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('add', 'post');
    }

    public function add(){
        if($this->request->is('get')){
            throw new MethodNotAllowedException();
        }

        if($this->request->is('post')){
            $this->Comment->create();
            if($this->Comment->save($this->request->data)){
                $this->Session->setFlash(__('Your comment is now awaiting for approval. Thank you!'), 'flash_success');
                $this->redirect(array('controller' => 'pages', 'action' => 'index', 'home'));
            }
        }
    }

    public function post($id = null){
        $this->layout = 'ajax';
        $this->Comment->recursive = -1;
        $comments = $this->Comment->find('all', array(
            'conditions' => array('Comment.post_id' => $id),
            'order' => array('Comment.created' => 'DESC')
        ));

        $this->set('comments', $comments);
    }
}