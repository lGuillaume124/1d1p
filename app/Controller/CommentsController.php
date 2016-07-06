<?php

App::uses('AppController', 'Controller');

class CommentsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'post');
    }

    public function add() {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $this->loadModel('Post');

        if ($this->request->is('post')) {
            $this->Comment->create();

            $album_id = $this->Post->find('first', array(
                'fields' => 'Post.album_id',
                'conditions' => array('Post.id' => $this->request->data['Comment']['post_id']),
                'recursive' => false
            ));

            $this->request->data['Comment']['album_id'] = $album_id['Post']['album_id'];

            if ($this->Comment->save($this->request->data)) {
                $this->Flash->success(__('Your comment is now awaiting for approval. Thank you!'));
                $this->redirect(array('controller' => 'pages', 'action' => 'index', 'home'));
            }
        }
    }

    public function admin_approve($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $comment = $this->Comment->find('first', array(
            'recursive' => -1,
            'fields' => array('Comment.id', 'Comment.post_id', 'Comment.approved'),
            'conditions' => array('Comment.id' => $id)
        ));

        if (!$comment || empty($comment)) {
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
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $post = $this->Comment->findById($id);

        if ($this->Comment->delete($id)) {
            $this->Flash->success(__('Comment '.$id.' ('.$post['Post']['title'].') has been successfully deleted!'));
        } else {
            $this->Flash->error(__('Unable to delete this comment'));
        }

        $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
    }

    public function admin_manage($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid Post ID.'));
        }

        $unapproved_comments = array();
        $approved_comments = array();

        $this->loadModel('Post');
        $post = $this->Post->findById($id);

        if (!$post) {
            $this->Flash->error(__('Invalid Post ID.'));
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }

        $comments = $this->Comment->find('all', array(
            'recursive' => -1,
            'conditions' => array('Comment.post_id' => $id),
            'order' => 'Comment.created DESC'
        ));

        foreach ($comments as $k => $comment) {
            if ($comment['Comment']['approved'] == false) {
                $unapproved_comments[] = $comment;
            } else {
                $approved_comments[] = $comment;
            }
        }

        $this->set(array('title_for_layout' => __('Manage comments').' - One Day, One Picture', 'unapproved_comments' => $unapproved_comments, 'approved_comments' => $approved_comments, 'post' => $post));
    }

    public function admin_unapprove($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $comment = $this->Comment->find('first', array(
            'recursive' => -1,
            'fields' => array('Comment.id', 'Comment.post_id', 'Comment.approved'),
            'conditions' => array('Comment.id' => $id)
        ));

        if (!$comment || empty($comment)) {
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

        $this->set('unapproved_comments', $comments);
    }

    public function post($id = null) {
        $this->layout = 'ajax';
        $this->Comment->recursive = -1;
        $comments = $this->Comment->find('all', array(
            'conditions' => array('Comment.post_id' => $id, 'Comment.approved' => true),
            'order' => array('Comment.created' => 'ASC')
        ));

        $this->set('comments', $comments);
    }
}