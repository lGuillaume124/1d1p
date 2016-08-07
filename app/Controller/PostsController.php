<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController {

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been successfully created!'));
            } else {
                $this->Flash->error(__('Unable to save your post.'));
            }
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }

        $this->loadModel('Album');

        if (isset($this->request->query['a']) || preg_match('/\d+/', $this->request->query['a'])) {
            $album = $this->Album->findById($this->request->query['a']);
        } else {
            $album = $this->Album->find('first', array(
                'order' => 'Album.created DESC'
            ));
		}

		if (!isset($this->request->query['a']) || !preg_match('/\d+/', $this->request->query['a'])) {
            $this->Flash->error(__('Undefined album'));
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }

        if (empty($album)) {
            $this->Flash->error(__('Undefined album'));
            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        } else {
            $this->set(array('title_for_layout' => __('Add a new post').' - One Day, One Picture', 'album' => $album));
        }
    }

    public function admin_delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $post = $this->Post->findById($id);

        if ($this->Post->delete($id)) {
            $this->Flash->success(__('Post '.$id.' ('.$post['Post']['title'].') has been successfully deleted!'));
        } else {
            $this->Flash->error(__('Unable to delete this post'));
        }

        $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
    }

    public function admin_edit($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post ID'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('Invalid post ID'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;

            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been successfully updated.'));
            } else {
                $this->Flash->error(__('Unable to save your post.'));
            }

            $this->redirect(array('controller' => 'pages', 'action' => 'index', 'admin' => true));
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }

        $this->set('title_for_layout', __('Edit a post').' - One Day, One Picture');
    }

    public function upload() {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException;
        }

        $this->layout = 'ajax';
        $this->render(false);

        if ($this->request->is('POST')) {

            if (!empty($this->request->data['Post']['file'])) {

                if (!$this->request->data['Post']['file']['error']) {

                    $extension = pathinfo($this->request->data['Post']['file']['name'], PATHINFO_EXTENSION);

                    if (!in_array($extension, array('jpg', 'jpeg', 'JPG', 'JPEG'))) {
                        echo json_encode(array('error' => __('We only accept JPG or JPEG photo!')));
                        return;
                    }

                    if (!file_exists(IMAGES.'photos')) {
                        App::uses('Folder', 'Utility');
                        new Folder(IMAGES.'photos', true, 0775);
                    }

                    $filename = md5(microtime()).'.jpg';

                    if (@move_uploaded_file($this->request->data['Post']['file']['tmp_name'], IMAGES.'photos'.DS.$filename)) {

                        if (@exif_read_data(IMAGES.'photos'.DS.$filename)) {

                            App::uses('CakeTime', 'Utility');
                            $exif = @exif_read_data(IMAGES.'photos'.DS.$filename);
                            $coordinates = $this->_getCoordinates($exif);
                            $datetime_original = (isset($exif['DateTimeOriginal'])) ? CakeTime::nice($exif['DateTimeOriginal']) : CakeTime::nice();

                            echo json_encode(array(
                                'coordinates' => $coordinates,
                                'photo' => $filename,
                                'datetime_original' => $datetime_original,
                                'original_name' => $this->request->data['Post']['file']['name']
                            ));

                            return;

                        } else {
                            echo json_encode(array('error' => __('Unable to analyze your photo.')));
                            return;
                        }
                    } else {
                        echo json_encode(array('error' => __('Unable to upload your photo.')));
                        return;
                    }
                } else {
                    echo json_encode(array('error' => $this->request->data['Post']['file']['error']));
                    return;
                }
            }
        }
        echo json_encode(array('photo' => null));
    }

    public function view($id = null) {

    }

    private function _getCoordinates($exif) {
        if (!isset($exif['GPSLatitude']) || !isset($exif['GPSLongitude'])) {
            return null;
        }

        $latitude = $this->_convertCoordinates($exif['GPSLatitude']);
        $longitude = $this->_convertCoordinates($exif['GPSLongitude']);

        if ($exif['GPSLatitudeRef'] == 'S') {
            $latitude = -$latitude;
        }

        if ($exif['GPSLongitudeRef'] == 'W') {
            $longitude = -$longitude;
        }

        return array('lat' => $latitude, 'lng' => $longitude);
    }

    private function _convertCoordinates($coords) {
        foreach ($coords as &$coord) {
            $tmp = explode('/', $coord);
            $coord = floatval($tmp[0]/$tmp[1]);
        }

        return $coords[0]+floatval($coords[1]/60)+floatval($coords[2]/3600);
    }
}
