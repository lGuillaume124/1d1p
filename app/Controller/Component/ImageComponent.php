<?php

App::uses('Component', 'Controller');

class ImageComponent extends Component{

    private static $useGD = TRUE;
    private static $quality = 90;

    public function resize($img, $to, $width = 0, $height = 0){

        $dimensions = getimagesize($img);
        $ratio		= $dimensions[0] / $dimensions[1];
        $exif       = exif_read_data($img);
        $rotation   = 0;

        if(isset($exif['Orientation'])){
            switch($exif['Orientation']){
                case 3:
                    $rotation = 180;
                    break;
                case 6:
                    $rotation = -90;
                    list($width, $height) = array($height, $width);
                    break;
                case 8:
                    list($width, $height) = array($height, $width);
                    $rotation = 90;
                    break;
            }
        }

        if($width == 0 && $height == 0){$width = $dimensions[0];$height = $dimensions[1];}
        elseif($height == 0){$height = round($width / $ratio);}
        elseif ($width == 0){$width = round($height * $ratio);}

        if($dimensions[0] > ($width / $height) * $dimensions[1]){
            $dimY = $height;
            $dimX = round($height * $dimensions[0] / $dimensions[1]);
            $decalX = ($dimX - $width) / 2;
            $decalY = 0;
        }
        if($dimensions[0] < ($width / $height) * $dimensions[1]){
            $dimX = $width;
            $dimY = round($width * $dimensions[1] / $dimensions[0]);
            $decalY = ($dimY - $height) / 2;
            $decalX = 0;
        }
        if($dimensions[0] == ($width / $height) * $dimensions[1]){
            $dimX = $width;
            $dimY = $height;
            $decalX = 0;
            $decalY = 0;
        }

        if(self::$useGD){
            $pattern = imagecreatetruecolor($width, $height);
            $type = exif_imagetype($img);
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($img);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($img);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($img);
                    break;
            }
            imagecopyresampled($pattern, $image, -$decalX, -$decalY, 0, 0, $dimX, $dimY, $dimensions[0], $dimensions[1]);
            imagedestroy($image);
            imageinterlace($pattern, true);
            
            if($rotation != 0){
                $pattern = imagerotate($pattern, $rotation, null);
            }
            
            imagejpeg($pattern, $to, self::$quality);
            return TRUE;

        }else{
            $cmd = '/usr/bin/convert -resize '.$dimX.'x'.$dimY.' "'.$img.'" "'.$to.'"';
            shell_exec($cmd);

            $cmd = '/usr/bin/convert -gravity Center -quality '.self::$quality.' -crop '.$width.'x'.$height.'+0+0 -page '.$width.'x'.$height.' "'.$to.'" "'.$to.'"';
            shell_exec($cmd);
        }
        return TRUE;
    }
}