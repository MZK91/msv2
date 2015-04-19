<?php

namespace MuzikSpirit\BackBundle\Utilities;

class ImagesHandler
{
    protected $options = array();

    function __construct($new_options=null) {

        $options = array(
            'current_dir' => __DIR__.'/../../../../web/',
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            // The maximum number of files for the upload directory:
            'max_number_of_files' => null,
            // Image resolution restrictions:
            'max_width' => 640,
            'max_height' => 900,
            'min_width' => 1,
            'min_height' => 1,
            'tmp_folder' => 'images/tmp/',
            'jpeg_quality' => 100,
            'png_quality' => 9,
        );
        if ($new_options) {
            $this->options = array_replace_recursive($options,$new_options);
        }else{
            $this->options = $options;
        }

    }

    public function create_scaled_image($path,$file_name) {
        $file_path = $this->options['current_dir'].$this->options['tmp_folder'].$file_name;
        $new_file_path = $this->options['current_dir'].$path.$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $this->options['max_width'] / $img_width,
            $this->options['max_height'] / $img_height
        );

        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                if(copy($file_path, $new_file_path)){
                    return unlink ($file_path);
                }
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;

        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($this->options['jpeg_quality']) ?
                    $this->options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($this->options['png_quality']) ?
                    $this->options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
                $new_img,
                $src_img,
                0, 0, 0, 0,
                $new_width,
                $new_height,
                $img_width,
                $img_height
            ) && $write_image($new_img, $new_file_path, $image_quality);
        @imagedestroy($src_img);
        @imagedestroy($new_img);

        return $success;
    }

    public function imageConverter($path,$file_name,$type) {
        $file_path = $this->options['current_dir'].$this->options['tmp_folder'].$file_name;
        $extension = strtolower(substr(strrchr($file_name, '.'), 1));
        $outputFile = preg_replace('/'.$extension.'$/i',trim(strtolower($type)),$file_name);
        $new_file_path = $this->options['current_dir'].$path.$outputFile;

        switch (exif_imagetype ($file_path)) {
            case 2:
                //echo 'JPEG';
                $input = imagecreatefromjpeg($file_path);
                break;
            case 1:
                //echo 'GIF';
                $input = imagecreatefromgif($file_path);
                break;
            case 3:
                //echo 'PNG';
                $input = imagecreatefrompng($file_path);
                break;
            default:
                $input = null;
        }
        list($width, $height) = getimagesize($file_path);

        $output = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($output,  255, 255, 255);
        imagefilledrectangle($output, 0, 0, $width, $height, $white);
        imagecopy($output, $input, 0, 0, 0, 0, $width, $height);

        switch ($type) {
            case 'jpg':
            case 'jpeg':
                imagejpeg ($output,$new_file_path, $this->options['jpeg_quality']);
                break;
            case 'gif':
                imagegif ($output,$new_file_path);
                break;
            case 'png':
                imagepng ($output,$new_file_path,$this->options['png_quality']);
                break;
            default:
                $output = null;
        }

        // Free up memory (imagedestroy does not delete files):
        imagedestroy($output);
        unlink($file_path);

        return $outputFile;
    }

    public function imageCrop($file,$x,$y,$w,$h,$new_width,$new_height){
        $file_path = $this->options['current_dir'].$this->options['tmp_folder'].$file;
        $new_file_path = $this->options['current_dir'].$this->options['tmp_folder'].'crop-'.$file;
        $new_img = imagecreatetruecolor($new_width, $new_height);

        switch (exif_imagetype ($file_path)) {
            case 2:
                //echo 'JPEG';
                $src_img = imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($this->options['jpeg_quality']) ?
                    $this->options['jpeg_quality'] : 75;
                break;
            case 1:
                //echo 'GIF';
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 3:
                //echo 'PNG';
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                imagealphablending($new_img, false);
                imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($this->options['png_quality']) ?
                    $this->options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
                $new_img,
                $src_img,
                0, 0, $x, $y,
                $new_width,
                $new_height,
                $w,
                $h
            ) && $write_image($new_img, $new_file_path, $image_quality);

        unlink($file_path);
        rename ($new_file_path, $file_path);
        @imagedestroy($file_path);
        @imagedestroy($src_img);
    }

    public function imageInfo($file_path){

        $tabInfo['extension'] = strtolower(substr(strrchr(basename($file_path), '.'), 1));
        $tabInfo['fileName'] = basename($file_path, '.'.$tabInfo['extension']);

        return $tabInfo;
    }
    public function moveToTmp($fileToUpload,$fileName){

        return move_uploaded_file($fileToUpload,$this->options['current_dir'].$this->options['tmp_folder'].$fileName);

    }

    public function moveToDir($oldPath,$newPath){
        rename($this->options['current_dir'].$oldPath,$this->options['current_dir'].$newPath);
        return 1;

    }


}