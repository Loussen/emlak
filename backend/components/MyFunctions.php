<?php
namespace backend\components;
use backend\models\Announces;
use backend\models\ImageUpload;
use Yii;

class MyFunctions
{
    public static function getStatus($status='all',$order='asc')
    {
        $array = [1 => 'Aktiv', 0 => 'Deaktiv'];
		if($order=='desc') $array=array_reverse($array);
        if(is_numeric($status))
            return $array[$status];
        else
            return $array;
    }

    public static function getSmsStatus($status='all',$order='asc')
    {
        $array = [1 => 'Aktiv', 0 => 'Deaktiv'];
        if($order=='desc') $array=array_reverse($array);
        if(is_numeric($status))
            return $array[$status];
        else
            return $array;
    }

    public static function getStatusTemplate($status)
    {
        if($status == 1) {
            $template = 'btn-success';
        }elseif($status == 0 || $status == 3 || $status == 2) {
            $template =  'btn-warning';
        }
        elseif($status == 4) {
            $template =  'btn-danger';
        }
        return $template;
    }

    public static function slugGenerator($slug,$space='-',$onlyEnglish=true)
    {
        $slug=strip_tags($slug);
        $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
        $spacesDuplicateHypens = '/[\-\s]+/';
        $slug = preg_replace($lettersNumbersSpacesHyphens, '', $slug);
        $slug = preg_replace($spacesDuplicateHypens, $space, $slug);
        $slug = trim($slug, '-');
        if(strlen($slug)>190) $slug=mb_substr($slug,0,190,"UTF-8");
        $slug=mb_strtolower($slug, 'UTF-8');
        if($onlyEnglish==true){
			$from=['ü','ö','ğ','ı','ə','ç','ş']; $to=['u','o','g','i','e','c','s'];
			$slug=str_replace($from,$to,$slug);
		}
		$slug=str_replace(' ','',$slug);
        return $slug;
    }

    public static function fileNameGenerator($name){
        $from=['ü','ö','ğ','ı','ə','ç','ş','Ü','Ö','Ğ','I','Ə','Ç','Ş',' '];
        $to=['u','o','g','i','e','c','s','U','O','G','I','E','C','S','-'];
        $name=str_replace($from,$to,$name);
        return $name;
    }

    public static function getImagePath()
    {
        return Yii::$app->basePath.'/../frontend/web/images';
    }
    public static function getImageUrl()
    {
        return Yii::$app->homeUrl.'/../frontend/web/images';
    }

    public static function attrForLangs($attr){
        $array=[];
        foreach(Yii::$app->params['languages'] as $key=>$lang)
        {
            $array[]=$attr.'_'.$key;
        }
        return $array;
    }

    public static function codeGeneratorforAdmin($announceId,$adminId){
        return md5(md5($announceId.'-'.intval($adminId).'-'.date("d")));
    }
	
	public static function codeGeneratorforUser($announceId){
        return md5(md5($announceId.'-777'));
    }

    public static function setWatermarktoImages($id,$offset=0,$limit=1){
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
			$tb='backend\models\\'.$table;
			$announce=$tb::find()->where(['id'=>$id])->one();
			if(!empty($announce)) break;
		}
        $images=explode(",",$announce->images);
        $logo_images=explode(",",$announce->logo_images);
        $count=0;
		$save_logo_images=[];
		$from=['png','bmp','gif','PNG','BMP','GIF','jpeg','JPEG'];
		$to=['jpg','jpg','jpg','jpg','jpg','jpg','jpg','jpg'];
		$img=new ImageUpload();
        foreach($images as $image){
			$file=MyFunctions::getImagePath().'/'.$image;
			if(is_file($file)){
				$type_exp=explode(".",$image);  $type=end($type_exp);   $type=strtolower($type);
				if($type!='jpg'){
					$type='jpg'; unset($type_exp[count($type_exp)-1]);
					$n_file=implode(".",$type_exp).'.'.$type;
					$n_file=MyFunctions::getImagePath().'/'.$n_file; rename($file,$n_file);
					if($count==0) { $announce->images=str_replace($from,$to,$announce->images);	$announce->save(false); }
					$image=str_replace($from,$to,$image); $file=$n_file;
				}
				$dest=explode(",",$image);	$dest=$dest[0];	$dest=explode("/",$dest); $dest=$dest[0].'/'.$dest[1].'/'.$dest[2].'/'.$dest[3];
				$saveParth=$dest;
				$fileThumb=explode("/",$image); $fileThumb=end($fileThumb);
				$fileThumb=explode("-",$fileThumb);   unset($fileThumb[count($fileThumb)-1]); $fileThumb=implode("-",$fileThumb).'.'.$type;
				$save_logo_images[]=$dest.'/'.$fileThumb;
				
				$img->maxSize($file,Announces::MAX_IMAGE_WIDTH,Announces::MAX_IMAGE_HEIGHT,100);
				if($id>248261) $watermark_logo='watermark_logo.png'; else $watermark_logo='';
				$img->thumbExportAnnounce($file,$saveParth,$fileThumb,Announces::THUMB3_IMAGE_WIDTH,Announces::THUMB3_IMAGE_HEIGHT,'watermark.png',$watermark_logo);
				if($count==0){	// cover image
					$fileCover=explode("-",$fileThumb); unset($fileCover[count($fileCover)-1]); $fileCover=$dest.'/'.implode("-",$fileCover).'.'.$type;
					copy(MyFunctions::getImagePath().'/'.$image,MyFunctions::getImagePath().'/'.$fileCover);
					$fileCoverT=explode("/",$fileCover); $fileCoverT=end($fileCoverT); 
					$img->thumbExportCover($file,$saveParth,$fileCoverT,Announces::THUMB_IMAGE_WIDTH,Announces::THUMB_IMAGE_HEIGHT);
				}
				$count++;
			}
        }
		
		if( count($images)!=count($logo_images) or $announce->cover!=$fileCover ){
			$save_logo_images=implode(",",$save_logo_images);
			if($save_logo_images!='') $announce->logo_images=$save_logo_images;
			$announce->cover=$fileCover;
			$announce->save(false);
		}

		if($offset>0){
			$offset=$offset+$limit;
			//header("Refresh:1; http://emlak.az/emlak0050pro/announces/index?offset=$offset&limit=$limit");
		}
		return $announce->logo_images;
    }
}

?>