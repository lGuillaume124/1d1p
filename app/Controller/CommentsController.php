<?php

App::uses('AppController', 'Controller');

class CommentsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'post');
    }

    public function add() {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if ($this->request->is('post')) {

            $this->Comment->create();

            if ($this->Comment->save($this->request->data)) {

                $this->Flash->success(__('Your comment is now awaiting for approval. Thank you!'));
                $this->redirect(array('controller' => 'pages', 'action' => 'index', 'home'));

            }

        }
    }

    public function admin_approve($id) {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $comment = $this->Comment->find('first', array(
            'recursive' => -1,
            'fields' => array('Comment.id', 'Comment.post_id', 'Comment.approved'),
            'conditions' => array('Comment.id' => $id)
        ));

        if (empty($comment)) {

            $this->Flash->error(__('Invalid Comment ID'));
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));

        } else {

            if ($comment['Comment']['approved'] == false) {

                $this->Comment->id = $id;
                if (!$this->Comment->saveField('approved', true)) {
                   $this->Flash->error(__('Unable to validate this comment.'));
                }

            } else {

                $this->Flash->info(__('This comment has already been approved.'));

            }
        }

        $this->redirect($this->referer());
    }

    public function admin_delete($id) {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Comment->delete($id)) {

            $this->Flash->success(__('Comment %s successfully deleted.', h($id)));

        } else {

            $this->Flash->error(__('Unable to delete this comment'));

        }

        $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
    }

    public function admin_manage($id) {

        if (!$id) {
            throw new NotFoundException(__('Invalid Post ID.'));
        }

        $title_for_layout = __('Comments management');
        $this->loadModel('Post');

        $comments = $this->Comment->find('all', array(
            'conditions' => array('Comment.post_id' => $id)
        ));

        $post = $this->Post->find('first', array(
            'fields' => 'Post.title',
            'conditions' => array('Post.id' => $id)
        ));

        $this->set(compact('title_for_layout', 'comments', 'post'));

    }

    public function admin_unapprove($id) {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $comment = $this->Comment->find('first', array(
            'recursive' => -1,
            'fields' => array('Comment.id', 'Comment.post_id', 'Comment.approved'),
            'conditions' => array('Comment.id' => $id)
        ));

        if (empty($comment)) {

            $this->Flash->error(__('Invalid Comment ID'));
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));

        } else {

            if ($comment['Comment']['approved'] == true) {

                $this->Comment->id = $id;
                if (!$this->Comment->saveField('approved', false)) {

                    $this->Flash->error(__('Unable to unapproved this comment.'));

                }

            } else {

                $this->Flash->info(__('This comment has already been unapproved.'));

            }
        }

        $this->redirect(array('controller' => 'comments', 'action' => 'manage', $comment['Comment']['post_id']));
    }

    public function admin_unread() {

        $comments = $this->Comment->find('all', array(
            'conditions' => array('approved' => false)
        ));

        $this->set(compact('comments'));
    }

    public function post($id = null) {

        $this->layout = 'ajax';
        $comments = $this->Comment->find('all', array(
            'recursive' => -1,
            'conditions' => array('Comment.post_id' => $id, 'Comment.approved' => true),
            'order' => array('Comment.created' => 'ASC')
        ));

        $this->set(compact('comments'));
    }
}