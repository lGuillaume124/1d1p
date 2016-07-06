<?php

App::uses('AppController', 'Controller');

class AlbumsController extends AppController{

    public function admin_add(){
        if($this->request->is('post')){
            $this->Album->create();

            if($this->Album->save($this->request->data)){
                $this->Flash->success(__('New album successfully created.'));
            }else{
                $this->Flash->error(__('Unable to create album.'));
            }

            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));

        }else{
            throw new MethodNotAllowedException();
        }
    }

    public function admin_edit($id){
        if(!$id){
            throw new NotFoundException(__('Invalid album ID.'));
        }

        $album = $this->Album->findById($id);

        if(!$album){
            throw new NotFoundException(__('Invalid album ID.'));
        }

        if($this->request->is(array('post', 'put'))){
            $this->Album->id = $id;

            if($this->Album->save($this->request->data)){
                $this->Flash->success(__('Album successfully renamed.'));
            }else{
                $this->FLash->error(__('Unable to save your post.'));
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
            $this->Flash->success(__('Album '.$id.' ('.$album['Album']['title'].') successfully deleted.'));
        }else{
            $this->Flash->error(__('Unable to delete this album.'));
        }

        $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
    }
}