<?php

App::uses('AppHelper', 'View/Helper');

class ImageHelper extends AppHelper{

    public $helpers = array('Html');

    public function thumbPath($path, $width = 0, $height = 0){
        $extension = '.'.pathinfo($path, PATHINFO_EXTENSION);
        $path = str_replace($extension, "_".$width."x".$height.$extension, $path);
        return $path;
    }

    public function lazyload($path, $options = array()){
        $image = $this->Html->image($path, $options);
        return str_replace('src="', 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" onload="lzld(this)" data-frz-src="', $image);
    }

}