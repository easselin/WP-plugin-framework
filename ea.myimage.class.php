<?php 

if( !defined('__MYIMAGE') ) {
  define( '__MYIMAGE' , 1 );

class myImage {
  private $image;
  private $imgSrc;
  private $height;
  private $width;
  private $type;
  private $attribut;
  private $quality;
  
  public function __construct($filePath) {
    $this->imgSrc = $filePath;
    $this->quality = 70;
    
    //getting the image infos
    list($this->width, $this->height, $this->type, $this->attribut) = getimagesize($this->imgSrc);
    
    //create image depending on the type
    switch ($this->type) {  
      case 1:
        $this->image = imageCreateFromGif($this->imgSrc) or die("Error: Cannot find image!");
        break;  
      case 2:
        $this->image = imageCreateFromJpeg($this->imgSrc) or die("Error: Cannot find image!");
        break;  
      case 3:
        $this->image = imageCreateFromPng($this->imgSrc) or die("Error: Cannot find image!");
        break;
    }

  } // end __construct
  
  public function resize_abs($wid='', $hei='', $lock=false) {
    $oldHeight = $this->height;
    $oldWidth = $this->width;
    $oldImage = $this->image;

    if($lock && ($hei != '' XOR $wid != '')) {
      if($hei != '') {
        $this->width = $oldWidth * ($hei / $oldHeight);
        $this->height = $hei;
      }
      if($wid != '') { 
        $this->height = $oldHeight * ($wid / $oldWidth);
        $this->width = $wid;
      }
    } else {
      if($hei != '') { $this->height = $hei; }
      if($wid != '') { $this->width = $wid; }
    }
    
    $this->image = imagecreatetruecolor($this->width,$this->height);
    imagecopyresized($this->image, $oldImage, 0, 0, 0, 0, $this->width, $this->height, $oldWidth, $oldHeight);
    imagedestroy($oldImage);
    
  } // end resize_abs

  public function resize_rel($widCoeff='', $heiCoeff='') {
    $oldHeight = $this->height;
    $oldWidth = $this->width;
    $oldImage = $this->image;

    if($heiCoeff != '') { $this->height = $this->height * $heiCoeff; }
    if($widCoeff != '') { $this->width = $this->width * $widCoeff; }
    
    $this->image = imagecreatetruecolor($this->width,$this->height);
    imagecopyresized($this->image, $oldImage, 0, 0, 0, 0, $this->width, $this->height, $oldWidth, $oldHeight);
    imagedestroy($oldImage);
        
  } // end resize_rel
  
  public function resize_auto($maxWidth, $maxHeight) {
    
    if($this->height <= $maxHeight && $this->width <= $maxWidth) {
      //... rien à faire
    } elseif($this->height > $maxHeight && $this->width <= $maxWidth) {
      $this->resize_abs('', $maxHeight, true);
    } elseif($this->height <= $maxHeight && $this->width > $maxWidth) {
      $this->resize_abs($maxWidth, '', true);
    } elseif($this->height > $maxHeight && $this->width > $maxWidth) {
      $ratioX = $this->width / $maxWidth;
      $ratioY = $this->height / $maxHeight;
      if($ratioX >= $ratioY) {
        $this->resize_abs($maxWidth, '', true);
      } else {
        $this->resize_abs('', $maxHeight, true);
      }
    }
    
  } // end resize_rel

  public function resize_max($int){
    
  }

  public function resize_min($int){
    
  }
  
  public function crop($cropWidth, $cropHeight, $x ,$y) {
    
  }

  public function crop_auto($cropWidth, $cropHeight) {
    
    $oldHeight = $this->height;
    $oldWidth = $this->width;
    $oldImage = $this->image;
    
    // On pose comme borne supérieur du crop, les dimensions de l'image
    if($cropHeight > $oldHeight) { $cropHeight = $oldHeight; }
    if($cropWidth > $oldWidth) { $cropWidth = $oldWidth; }
    
    $cropHeightSrc = $cropHeight;
    $cropWidthSrc = $cropWidth;
    
    $xPos = ( $oldWidth - $cropWidthSrc ) / 2;
    $yPos = ( $oldHeight - $cropHeightSrc ) / 2;

    $this->image = imagecreatetruecolor($cropWidth, $cropHeight);
    imagecopyresized($this->image, $oldImage, 0, 0, $xPos, $yPos, $cropWidth, $cropHeight, $cropWidthSrc, $cropHeightSrc);
    
    $this->height = $cropHeight;
    $this->width = $cropWidth;
    imagedestroy($oldImage);

  } // end crop_auto
  
  public function magik_thumb($thumb_size) {
    
    $minDim = min($this->height, $this->width);
    $this->crop_auto($minDim, $minDim);
    $this->resize_abs($thumb_size,$thumb_size);    
    
  } // end magik_thumb
  
  public function copy($dest_path) {
    
    imagejpeg($this->image, $dest_path, $this->quality);
    return new myImage($dest_path);
    
  }
  
  public function saveImage($dest_path) {
    
    $this->copy($dest_path);
    
  }
  
  public function getImage(){
    
    imagejpeg($this->image, $this->imgSrc, $this->quality);
    list($this->width, $this->height, $this->type, $this->attribut) = getimagesize($this->imgSrc);
    return $this->imgSrc;
    
  } // end getImage
  
  public function getHeight() {
    return $this->height;
  }
  
  public function getWidth() {
    return $this->width;
  }
  
  public function debugImage() {
    
    echo $this->imgSrc;
    echo '<pre>';
    print_r($this);
    echo '</pre>';
    
  }
}

} // end define test
?>