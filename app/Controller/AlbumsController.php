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
        }else{
            throw new MethodNotAllowedException();
        }
    }

    public function admin_edit($id){
        if(!$id){
            throw new NotFoundException(__('Invalid album ID'));
        }

        $album = $this->Album->findById($id);
        if(!$album){
            throw new NotFoundException(__('Invalid album ID'));
        }

        if($this->request->is(array('post', 'put'))){
            $this->Album->id = $id;
            if($this->Album->save($this->request->data)){
                $this->Session->setFlash(__('Your album has been successfully renamed.'), 'flash_success');
            }else{
                $this->Session->setFlash(__('Unable to save your post.'), 'flash_error');
            }
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }else{
            throw new MethodNotAllowedException();
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