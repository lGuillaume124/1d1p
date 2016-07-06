<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signin');
    }

    public function admin_index() {
        $users = $this->User->find('all');
        $this->set(compact('users'));
    }

    public function admin_disable($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $user = $this->User->findById($id);

        if (empty($user)) {
            $this->Flash->error(__('This user does not exist.'));
            return $this->redirect($this->referer());
        }

        if ($user['User']['active']) {
            $this->User->id = $id;
            if ($this->User->saveField('is_active', false)) {
                $this->Flash->success(__('User disabled.'));
            } else {
                $this->Flash->error(__('Unable to disable this user.'));
            }
        } else {
            $this->Flash->error(__('This user is already disabled.'));
        }

        return $this->redirect($this->referer());
    }

    public function admin_enable($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $user = $this->User->findById($id);

        if (empty($user)) {
            $this->Flash->error(__('This user does not exist.'));
            return $this->redirect($this->referer());
        }

        if (!$user['User']['active']) {
            $this->User->id = $id;
            if ($this->User->saveField('is_active', true)) {
                $this->Flash->success(__('User enabled.'));
            } else {
                $this->Flash->error(__('Unable to enable this user.'));
            }
        } else {
            $this->Flash->error(__('This user is already enabled.'));
        }

        return $this->redirect($this->referer());
    }

    public function admin_delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $user = $this->User->findById($id);

        if (empty($user)) {
            $this->Flash->error(__('This user does not exist.'));
            return $this->redirect($this->referer());
        }

        if ($this->User->delete($id)) {
            $this->Flash->success(__('User removed.'));
        } else {
            $this->Flash->error(__('Unable to remove this user'));
        }

        return $this->redirect($this->referer());
    }

    public function signin() {

        if ($this->request->is('post')) {
            $this->User->create();

            // We must be sure we always have at least an active user
            $users = $this->User->find('count', array('conditions' => array('User.is_active' => true)));
            $this->request->data['User']['is_active'] = ($users < 1) ? true : false;

            if ($this->User->save($this->request->data)) {
                if ($users > 0) {
                    $this->Flash->success(__('Your inscription has been recorded and will be validated by an admin soon.'));
                } else {
                    $this->Flash->success(__('As you are the first user here, your account has been automatically activated.'));
                }

                $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => false));
            } else {
                $this->Flash->error(__('An error occurred during the user creation. Be sure you did not miss anything or your password is 12 characters long.'));
            }
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
            } else {
                $this->Flash->error(__('Wrong credentials. Or may be your account is not enabled yet.'));
            }

            return $this->redirect($this->referer());
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}
