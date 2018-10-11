<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

class ImageUpload
{
    const MAX_FILE_SIZE = 41943040;     // 40mb

    public function validate($image)
    {
        $error = false;
        $validMimeTypes = ["image/gif","image/png","image/jpeg","image/pjpeg"];
        $image_dimensions = getimagesize($image->tempName); $image_width = $image_dimensions[0]; $image_height = $image_dimensions[1];
        $minWidth = 2; $minHeight = 2;

        if (!in_array($image->type, $validMimeTypes)) $error = true;
        //if ($image->size > self::MAX_FILE_SIZE) $error = true;                            // yoxlamasada olar.. ciddi bir wey deyil
        //if (($image_width < $minWidth) || ($image_height < $minHeight)) $error = true;    // yoxlamasada olar.. ciddi bir wey deyil

        if (!$error) return true; else return false;
    }

    public function save($tmp,$saveParth='',$imageName){
        if($this->validate($tmp))
        {
            $folders=explode("/",$saveParth);
            $parth='';
            foreach($folders as $f)
            {
                if($f!='')
                {
                    $parth.=$f.'/';
                    if(!is_dir(MyFunctions::getImagePath().'/'.$parth)) mkdir(MyFunctions::getImagePath().'/'.$parth);
                }
            }

            if($tmp->saveAs(MyFunctions::getImagePath().'/'.$saveParth.'/'.$imageName)) return true;
            else return  false;
        }
        else return false;
    }

    public function deleteOldImages($files=[]){
        foreach($files as $file)
        {
            if($file!=null && is_file(MyFunctions::getImagePath().'/'.$file) ) unlink(MyFunctions::getImagePath().'/'.$file);
        }
    }

    public function maxSize($image, $maxWidth, $maxHeight, $quality=75){
        $ADAPT='Image::AUTO';
        $file = MyFunctions::getImagePath().'/'.$image;     if(!is_file($file)) $file=$image;

        if($maxWidth>0)
        {
            $image=Yii::$app->image->load($file);
            if($image->width>$maxWidth) $image->resize($maxWidth, NULL, $ADAPT)->save($file,$quality);
        }
        if($maxHeight>0)
        {
            $image=Yii::$app->image->load($file);
            if($image->height>$maxHeight) $image->resize(NULL, $maxHeight, $ADAPT)->save($file,$quality);
        }
        return true;
    }

    // Proporsional
    public function thumbExport($image, $saveParth, $fileThumb, $thumbWidth, $thumbHeight, $withMaxSize=false, $watermark='', $watermarkLogo='', $quality=75){
        $folders=explode("/",$saveParth);
        $parth='';
        foreach($folders as $f)
        {
            if($f!='')
            {
                $parth.=$f.'/';
                if(!is_dir(MyFunctions::getImagePath().'/'.$parth)) mkdir(MyFunctions::getImagePath().'/'.$parth);
            }
        }
        $file = MyFunctions::getImagePath().'/'.$image;   if(!is_file($file)) $file=$image;
        $fileThumb=MyFunctions::getImagePath().'/'.$saveParth.'/'.$fileThumb;

        if($withMaxSize==false){
            if($thumbWidth!=NULL && $thumbHeight!=NULL)  $ADAPT='Image::NONE'; else $ADAPT='Image::AUTO';
            $image=Yii::$app->image->load($file);
            if($image->resize($thumbWidth, $thumbHeight, $ADAPT)->save($fileThumb,$quality)) $file=$fileThumb;
        }
        else{
            $ADAPT='Image::AUTO';
            if($thumbWidth!=NULL)
            {
                $image=Yii::$app->image->load($file);
                if($image->width>$thumbWidth) { $image->resize($thumbWidth, NULL, $ADAPT)->save($fileThumb,$quality); $file=$fileThumb; }
            }
            if($thumbHeight!=NULL)
            {
                $image=Yii::$app->image->load($file);
                if($image->height>$thumbHeight) { $image->resize(NULL, $thumbHeight, $ADAPT)->save($fileThumb,$quality); $file=$fileThumb; }
            }
        }

        if($watermarkLogo!=''){
            if(is_file(MyFunctions::getImagePath().'/'.$watermarkLogo))  $watermarkLogo=MyFunctions::getImagePath().'/'.$watermarkLogo;
            $image=Yii::$app->image->load($file);
            $watermarkLogo=Yii::$app->image->load($watermarkLogo);
            if($watermark!='') $q=100; else $q=90;
            $image->watermark($watermarkLogo, $offset_x = $image->width-81, $offset_y = $image->height-81, $opacity = 100)->save($fileThumb,$q);
            $file=$fileThumb;
        }
        if($watermark!=''){
            if(is_file(MyFunctions::getImagePath().'/'.$watermark))  $watermark=MyFunctions::getImagePath().'/'.$watermark;
            $image=Yii::$app->image->load($file);
            $watermark=Yii::$app->image->load($watermark);
            $image->watermark($watermark, $offset_x = NULL, $offset_y = NULL, $opacity = 100)->save($fileThumb,90);
        }
        return true;
    }

    public function thumbExportAnnounce($image, $saveParth, $fileThumb, $thumbWidth, $thumbHeight, $watermark='', $watermarkLogo=''){
        if(!is_file($image)) $file = MyFunctions::getImagePath().'/'.$image; else $file=$image;
		$fileThumb=MyFunctions::getImagePath().'/'.$saveParth.'/'.$fileThumb;
        $tip=explode(".",$file); $tip=end($tip); $tip=strtolower($tip);
        $ADAPT='Image::AUTO';
        if($thumbWidth!=NULL){
            $image=Yii::$app->image->load($file);
            if($image->width>$thumbWidth) {
                $image->resize($thumbWidth, NULL, $ADAPT)->save($fileThumb,100); $file=$fileThumb;
            }
        }
        if($thumbHeight!=NULL){
            $image=Yii::$app->image->load($file);
            if($image->height>$thumbHeight) {
				$image->resize(NULL, $thumbHeight, $ADAPT)->sharpen(1)->save($fileThumb,100); $file=$fileThumb;
            }
        }
		
        if($watermark!='' && $tip!='png'){
            if(is_file(MyFunctions::getImagePath().'/'.$watermark))  $watermark=MyFunctions::getImagePath().'/'.$watermark;
            $image=Yii::$app->image->load($file);
            $watermark=Yii::$app->image->load($watermark);
            $image->watermark($watermark, $offset_x = NULL, $offset_y = NULL, $opacity = 100)->save($fileThumb,100); $file=$fileThumb;
        }
        if($watermarkLogo!=''){
            if(is_file(MyFunctions::getImagePath().'/'.$watermarkLogo)) $watermarkLogo=MyFunctions::getImagePath().'/'.$watermarkLogo;
            $image=Yii::$app->image->load($file);
            $watermarkLogo=Yii::$app->image->load($watermarkLogo);
            $image->watermark($watermarkLogo, $offset_x = $image->width-81, $offset_y = $image->height-81, $opacity = 100)->save($fileThumb,95);
        }
    }
	
	public function thumbExportCover($image, $saveParth, $fileThumb, $thumbWidth, $thumbHeight){
		if(!is_file($image)) $file = MyFunctions::getImagePath().'/'.$image; else $file=$image;
		$fileThumb=MyFunctions::getImagePath().'/'.$saveParth.'/'.$fileThumb;
		$ADAPT='Image::AUTO';
		$image=Yii::$app->image->load($file);
		if($image->height<$image->width){
			if($image->height>$thumbHeight) $image->resize(NULL, $thumbHeight, $ADAPT)->save($fileThumb,100); $file=$fileThumb;
		}
		else{
			if($image->width>$thumbWidth) $image->resize($thumbWidth, NULL, $ADAPT)->save($fileThumb,100); $file=$fileThumb;
		}

        $ADAPT='Image::NONE';
		$image=Yii::$app->image->load($file);
		$margX=0; $margY=0;
		if($image->height>$thumbHeight) $margX=intval(($image->height-$thumbHeight)/2);
		if($image->width>$thumbWidth) $margY=intval(($image->width-$thumbWidth)/2);
        $image->crop($thumbWidth, $thumbHeight)->save($fileThumb,100,$margX,$margY);
        return true;
    }
}
