<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {
    public $uses = array('');

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index', 'hash');
    }

	public function index(){
        $this->loadModel('Album');
        $this->loadModel('Comment');
        $album = null;
        $albums = array();

        if(!isset($this->request->query['a']) || empty($this->request->query['a']) || $this->request->query['a'] == 'latest'){
            $album = $this->Album->find('first', array(
                'order' => 'Album.created DESC'
            ));
        }

        if(isset($this->request->query['a']) && preg_match('/\d+/', $this->request->query['a'])){
            $album = $this->Album->findById($this->request->query['a']);
        }

        if(!empty($album)){
            $albums_list = $this->Album->find('all', array(
                'recursive' => false,
                'conditions' => array('Album.id !=' => $album['Album']['id'])
            ));
        }else{
            $albums_list = array();
        }

        foreach($albums_list as $v){
            $albums[$this->request->here.'?a='.$v['Album']['id']] = $v['Album']['title'];
        }

        $this->set(array('albums' => $albums, 'album' => $album));
	}

    public function hash(){
        if($this->request->is('post')){
            $user['username'] = $this->request->data['Page']['username'];

            if(isset($this->request->data['Page']['password'])){
                App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
                $passwordHasher = new BlowfishPasswordHasher();
                $user['password'] = $passwordHasher->hash($this->request->data['Page']['password']);
            }

            $this->set('user', $user);
        }
    }

    public function admin_index(){
        $this->loadModel('Album');
        $this->loadModel('Post');
        $this->loadModel('Comment');

        $albums = array();

        if(!isset($this->request->query['a']) || empty($this->request->query['a']) || $this->request->query['a'] == 'latest'){
            $album = $this->Album->find('first', array(
                'order' => 'Album.created DESC'
            ));
        }

        if(isset($this->request->query['a']) && preg_match('/\d+/', $this->request->query['a'])){
            $album = $this->Album->findById($this->request->query['a']);
        }

        if(!empty($album)){
            $albums_list = $this->Album->find('all', array(
                'recursive' => false,
                'conditions' => array('Album.id !=' => $album['Album']['id'])
            ));

            $comments = $this->Comment->find('all', array(
                'fields' => array('Comment.post_id', 'Comment.approved'),
                'conditions' => array('Comment.album_id' => $album['Album']['id']),
                'recursive' => -1
            ));

            foreach($album['Post'] as $kp => $post){
                $unapproved_comments = 0;
                $approved_comments = 0;

                foreach($comments as $kc => $comment){
                    if($comment['Comment']['post_id'] == $post['id']){
                        if($comment['Comment']['approved'] == true){
                            $approved_comments++;
                        }else{
                            $unapproved_comments++;
                        }
                    }
                }

                $album['Post'][$kp]['unapproved_comments'] = $unapproved_comments;
                $album['Post'][$kp]['approved_comments'] = $approved_comments;

                if(strlen($post['content']) > 61){
                    $album['Post'][$kp]['content'] = substr($post['content'], 0, 60).'...';
                }
            }
        }else{
            $albums_list = array();
        }

        foreach($albums_list as $v){
            $albums[$this->request->here.'?a='.$v['Album']['id']] = $v['Album']['title'];
        }

        $stats['acount'] = $this->Album->find('count');
        $stats['pcount'] = $this->Post->find('count');

        $this->set(array('album' => $album, 'albums' => $albums, 'stats' => $stats));

    }
}
