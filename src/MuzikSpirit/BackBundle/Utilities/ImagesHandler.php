<?php

namespace MuzikSpirit\BackBundle\Utilities;

/**
 * Class ImagesHandler
 * @package MuzikSpirit\BackBundle\Utilities
 */
class ImagesHandler
{
    /**
     * option des images
     * @var array
     */
    protected $options = array();

    /**
     * Constructeur
     * @param null $newOptions
     */
    public function __construct($newOptions = null)
    {

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
        if ($newOptions) {
            $this->options = array_replace_recursive($options, $newOptions);
        } else {
            $this->options = $options;
        }

    }

    /**
     * Reduction de taille d'images
     *
     * @param string $path     chemin
     * @param string $fileName nom du fichier
     * @return bool
     */
    public function createScaledImage($path, $fileName, $thumb = 0)
    {
        if ($thumb == 0) {
            $filePath = $this->options['current_dir'].$this->options['tmp_folder'].$fileName;
            $newFilePath = $this->options['current_dir'].$path.$fileName;
        } else {
            $filePath = $this->options['current_dir'].$path.$fileName;
            $newFilePath = $this->options['current_dir'].$path.'thumbs/'.$fileName;
        }

        list($imgWidth, $imgHeight) = @getimagesize($filePath);
        if (!$imgWidth || !$imgHeight) {
            return false;
        }
        $scale = min(
            $this->options['max_width'] / $imgWidth,
            $this->options['max_height'] / $imgHeight
        );

        if ($scale >= 1) {
            if ($filePath !== $newFilePath) {
                if (copy($filePath, $newFilePath)) {
                    return unlink($filePath);
                }
            }
            
            return true;
        }
        $newWidth = $imgWidth * $scale;
        $newHeight = $imgHeight * $scale;

        $newImg = @imagecreatetruecolor($newWidth, $newHeight);
        switch (strtolower(substr(strrchr($fileName, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $srcImg = @imagecreatefromjpeg($filePath);
                $writeImage = 'imagejpeg';
                $imageQuality = isset($this->options['jpeg_quality']) ?
                    $this->options['jpeg_quality'] : 75;
                break;
            case 'gif':
                @imagecolortransparent($newImg, @imagecolorallocate($newImg, 0, 0, 0));
                $srcImg = @imagecreatefromgif($filePath);
                $writeImage = 'imagegif';
                $imageQuality = null;
                break;
            case 'png':
                @imagecolortransparent($newImg, @imagecolorallocate($newImg, 0, 0, 0));
                @imagealphablending($newImg, false);
                @imagesavealpha($newImg, true);
                $srcImg = @imagecreatefrompng($filePath);
                $writeImage = 'imagepng';
                $imageQuality = isset($this->options['png_quality']) ?
                    $this->options['png_quality'] : 9;
                break;
            default:
                $srcImg = null;
        }
        $success = $srcImg && @imagecopyresampled(
            $newImg,
            $srcImg,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $imgWidth,
            $imgHeight
            ) && $writeImage($newImg, $newFilePath, $imageQuality);
        @imagedestroy($srcImg);
        @imagedestroy($newImg);

        return $success;
    }

    /**
     * Convertiseur de type d'image
     * @param string $path     Chemin de l'image
     * @param string $fileName Nom de l'image
     * @param int    $type     Type de l'image
     * @return mixed
     */
    public function imageConverter($path,$fileName,$type) {
        $filePath = $this->options['current_dir'].$this->options['tmp_folder'].$fileName;
        $extension = strtolower(substr(strrchr($fileName, '.'), 1));
        $outputFile = preg_replace('/'.$extension.'$/i',trim(strtolower($type)),$fileName);
        $newFilePath = $this->options['current_dir'].$path.$outputFile;

        switch (exif_imagetype ($filePath)) {
            case 2:
                //echo 'JPEG';
                $input = imagecreatefromjpeg($filePath);
                break;
            case 1:
                //echo 'GIF';
                $input = imagecreatefromgif($filePath);
                break;
            case 3:
                //echo 'PNG';
                $input = imagecreatefrompng($filePath);
                break;
            default:
                $input = null;
        }
        list($width, $height) = getimagesize($filePath);

        $output = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($output,  255, 255, 255);
        imagefilledrectangle($output, 0, 0, $width, $height, $white);
        imagecopy($output, $input, 0, 0, 0, 0, $width, $height);

        switch ($type) {
            case 'jpg':
            case 'jpeg':
                imagejpeg ($output,$newFilePath, $this->options['jpeg_quality']);
                break;
            case 'gif':
                imagegif ($output,$newFilePath);
                break;
            case 'png':
                imagepng ($output,$newFilePath,$this->options['png_quality']);
                break;
            default:
                $output = null;
        }

        // Free up memory (imagedestroy does not delete files):
        imagedestroy($output);
        unlink($filePath);

        return $outputFile;
    }

    public function imageCrop($file,$x,$y,$w,$h,$newWidth ,$newHeight){
        $filePath = $this->options['current_dir'].$this->options['tmp_folder'].$file;
        $newFilePath = $this->options['current_dir'].$this->options['tmp_folder'].'crop-'.$file;
        $newImg = imagecreatetruecolor($newWidth , $newHeight);

        switch (exif_imagetype ($filePath)) {
            case 2:
                //echo 'JPEG';
                $srcImg = imagecreatefromjpeg($filePath);
                $writeImage = 'imagejpeg';
                $imageQuality = isset($this->options['jpeg_quality']) ?
                    $this->options['jpeg_quality'] : 75;
                break;
            case 1:
                //echo 'GIF';
                imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
                $srcImg = @imagecreatefromgif($filePath);
                $writeImage = 'imagegif';
                $imageQuality = null;
                break;
            case 3:
                //echo 'PNG';
                imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
                imagealphablending($newImg, false);
                imagesavealpha($newImg, true);
                $srcImg = @imagecreatefrompng($filePath);
                $writeImage = 'imagepng';
                $imageQuality = isset($this->options['png_quality']) ?
                    $this->options['png_quality'] : 9;
                break;
            default:
                $srcImg = null;
        }
        $success = $srcImg && @imagecopyresampled(
                $newImg,
                $srcImg,
                0, 0, $x, $y,
                $newWidth ,
                $newHeight,
                $w,
                $h
            ) && $writeImage($newImg, $newFilePath, $imageQuality);

        unlink($filePath);
        rename ($newFilePath, $filePath);
        @imagedestroy($filePath);
        @imagedestroy($srcImg);
    }

    public function imageInfo($filePath){

        $tabInfo['extension'] = strtolower(substr(strrchr(basename($filePath), '.'), 1));
        $tabInfo['fileName'] = basename($filePath, '.'.$tabInfo['extension']);

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