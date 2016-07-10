<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {
    public $uses = array('');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

	public function index() {

        $title_for_layout = 'One Day, One Picture';
        $album = array();
        $albums = array();

        $this->loadModel('Album');

        if (empty($this->request->query['a']) || $this->request->query['a'] == 'latest') {

            $album = $this->Album->find('first', array(
                'recursive' => 2,
                'order' => 'Album.created DESC'
            ));

        } elseif (is_numeric($this->request->query['a'])) {

            $album = $this->Album->find('first', array(
                'recursive' => 2,
                'conditions' => array('Album.id' => $this->request->query['a'])
            ));
        }

        $albums_list = $this->Album->find('all', array(
            'recursive' => 0,
            'fields' => 'Album.title, Album.created',
            'order' => 'Album.created'
        ));

        foreach ($albums_list as $value) {

            $album_year = date("Y", strtotime($value['Album']['created']));
            $albums[$album_year][$this->request->here . '?a=' . $value['Album']['id']] = $value['Album']['title'];

        }

        foreach ($album['Post'] as $k1 => $post) {

            foreach ($post['Comment'] as $k2 => $comment) {

                if (!$comment['approved']) {
                    # Remove unapproved comments
                    unset($album['Post'][$k1]['Comment'][$k2]);

                }

            }

        }

        $this->set(compact('title_for_layout', 'album', 'albums'));

	}

    public function admin_index() {

        $album = array();
        $albums = array();

        $this->loadModel('Album');

        if (empty($this->request->query['a']) || $this->request->query['a'] == 'latest') {

            $album = $this->Album->find('first', array(
                'recursive' => 2,
                'order' => 'Album.created DESC'
            ));

        } elseif (is_numeric($this->request->query['a'])) {

            $album = $this->Album->find('first', array(
                'recursive' => 2,
                'conditions' => array('Album.id' => $this->request->query['a'])
            ));

        }

        $albums_list = $this->Album->find('all', array(
            'recursive' => 0,
            'fields' => 'Album.title, Album.created',
            'order' => 'Album.created'
        ));

        foreach ($albums_list as $value) {

            $album_year = date("Y", strtotime($value['Album']['created']));
            $albums[$album_year][$this->request->here . '?a=' . $value['Album']['id']] = $value['Album']['title'];

        }

        $this->set(compact('albums', 'album'));

    }
}
