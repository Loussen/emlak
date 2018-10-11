<?php
namespace frontend\components;
use Yii;

class MyFunctionsF
{
    public static function getImagePath()
    {
        return Yii::$app->basePath.'/web/images';
    }
    public static function getImageUrl()
    {
        return Yii::$app->homeUrl.'/images';
    }

    public static function fileNameGenerator($name){
        $from=['ü','ö','ğ','ı','ə','ç','ş','Ü','Ö','Ğ','I','Ə','Ç','Ş','İ',' ','.',',','~'];
        $to=['u','o','g','i','e','c','s','U','O','G','I','E','C','S','I','-','','',''];
        $name=str_replace($from,$to,$name);
        $name = preg_replace("/[^a-zA-Z0-9-]+/", "", $name);
        $name=strtolower($name);
        return $name;
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

    public static function floorGenerator($floor_count,$current_floor,$property_type){
        if($property_type==1 || $property_type==2 || $property_type==5)
            return '<span>'.Yii::t('app','lang197').':</span> '.$current_floor.'/'.$floor_count.'&nbsp;&nbsp;';
        elseif($property_type==3 || $property_type==4 || $property_type==8)
            return '<span>'.Yii::t('app','lang197').':</span> '.$floor_count.'&nbsp;&nbsp;';
        else return '';
    }

    public static function codeGeneratorforAdmin($announceId,$adminId){
        return md5(md5($announceId.'-'.intval($adminId).'-'.date("d")));
    }

    public static function codeGeneratorforUser($announceId){
        return md5(md5($announceId.'-777'));
    }


}


?>