<?php

App::uses('AppController', 'Controller');

define ('THUMBS_DIR', IMAGES.'thumbs'.DS);

class ImgController extends AppController{
    public $components = array('Image');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public function index($img) {
        preg_match("/.*(_([0-9]+)x([0-9]+))\.[a-z0-9]+$/i", $img, $format);
        $dimensions = array($format[2], $format[3]);
        $path = IMAGES.str_replace($format[1], "", $img);
        $thumb = THUMBS_DIR.pathinfo($img, PATHINFO_BASENAME);

        if (!file_exists($path)) {
            throw new NotFoundException();
        }

        if (!file_exists($thumb)) {
            if (!file_exists(THUMBS_DIR)) {
                App::uses('Folder', 'Utility');
                new Folder(THUMBS_DIR, true, 0775);
            }

            $this->Image->resize($path, $thumb, $dimensions[0], $dimensions[1]);
        }

        $this->response->file($thumb);
        return $this->response;
    }
}