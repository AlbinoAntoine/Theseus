<?php


namespace Modules\Profile\Libraries;

use Config\Database;
use Exception;
use Modules\Auth\Models\AuthTokenModel;
use Modules\Auth\Models\ConnexionsModel;
use Modules\Auth\Config\Auth;
use Config\App;
use \Config\Services;
use Modules\Auth\Models\UsersModel;

class ProfileLib
{

    public function resize_image($imagePath) {
        $infoImage = getimagesize($imagePath);
        $width = $infoImage['0'];
        $height = $infoImage['1'];
        $mime = $infoImage['mime'];

        if ($mime == 'image/png'){
            $image = imagecreatefrompng($imagePath);
        }elseif($mime == 'image/jpeg' || $mime == 'image/jpg'){
            $image = imagecreatefromjpeg($imagePath);
        }

        $cutPartX = 0;
        $cutPartY = 0;
        if ($width > $height){
            $new_size = $height;
            $cutPartX = ($width-$new_size)/2;
        }else{
            $new_size = $width;
            $cutPartY = ($height-$new_size)/2;
        }
        //$new_imag = imagecreatetruecolor($new_size, $new_size);
        $RctCrop = [
            'x'=>$cutPartX,
            'y'=>$cutPartY,
            'width'=>$new_size,
            'height'=>$new_size
        ];

        $image_crop = imagecrop($image, $RctCrop);
        $image_resize = imagescale( $image_crop, 150, 150 );

        imagejpeg($image_resize, $imagePath);
    }

}