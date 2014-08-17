<?php

App::uses('AppController', 'Controller');

class AlbumsController extends AppController{

    public function admin_add(){
        if($this->request->is('post')){
            $this->Album->create();
            if($this->Album->save($this->request->data)){
                $this->Session->setFlash(__('New album successfully created!'), 'flash_success');
            }else{
                $this->Session->setFlash(__('Unable to create album.'), 'flash_error');
            }
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }
    }

    public function admin_delete($id){
        if($this->request->is('get')){
            throw new MethodNotAllowedException();
        }

        $album = $this->Album->findById($id);

        if($this->Album->delete($id, $cascade = true)){
            $this->Session->setFlash(__('Album '.$id.' ('.$album['Album']['title'].') has been successfully deleted!'), 'flash_success');
        }else{
            $this->Session->setFlash(__('Unable to delete this album'), 'flash_error');
        }
        $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
    }
}