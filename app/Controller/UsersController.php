<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
            } else {
                $this->Flash->error(__('Wrong credentials.'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}
