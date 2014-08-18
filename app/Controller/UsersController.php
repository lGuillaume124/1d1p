<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function login(){
        if($this->request->is('post')){
            if($this->Auth->login()){
                $this->redirect($this->Auth->redirectUrl());
            }else{
                $this->Session->setFlash(__('Wrong credentials.'), 'flash_error');
            }
        }
    }

    public function logout(){
        $this->redirect($this->Auth->logout());
    }
}
