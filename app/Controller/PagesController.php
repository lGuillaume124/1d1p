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

        $albums = $this->Album->find('all', array(
            'order' => array('Album.created DESC')
        ));

        $stats['acount'] = $this->Album->find('count');
        $stats['pcount'] = $this->Post->find('count');

        $this->set('albums', $albums);
        $this->set('stats', $stats);
    }
}
