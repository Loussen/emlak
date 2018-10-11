<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$this->title = $this->context->siteTitle;

if($q=='') $title=Yii::t('app','lang245'); else $title=$q;
?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/markerclusterer.js" type="text/javascript"></script>
<script type="text/javascript">	  
function initialize() {
    var startLoc = new google.maps.LatLng(40.447992135544304, 49.85664367675781);
    var mapOptions = {
        zoom: 11,
        center: startLoc,
		scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	
	//map.setCenter(new google.maps.LatLng(40.43335959357837, 49.81269836425781));
	//google.maps.event.trigger(map, 'resize');
	var infolar=[];
	var map0=[];
	var map1=[];
	var message;
	var markers = [];
	<?php
	$say=0;
	foreach($announces as $row){
	if($row["google_map"]!=''){
		$xerite_unvan=$row["google_map"];
		$xerite_unvan=str_replace("(","",$xerite_unvan); $xerite_unvan=str_replace(")","",$xerite_unvan); $unvan=explode(", ",$xerite_unvan);
		$sekiller=explode("-",$row["logo_images"]); $key=$sekiller[0];
		
		$title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
        $slugTitle=MyFunctionsF::slugGenerator($title); $stripTitle=strip_tags($title);
		
		$infos='';
		if($row["room_count"]>0) $infos.=$row["room_count"].' '.Yii::t('app','lang185').' '.Yii::t('app','property_type'.$row["property_type"]);
		else $infos.=Yii::t('app','property_type'.$row["property_type"]);
		$infos.=', '.$row["price"].' '.Yii::t('app','lang149').'<br /><br />';
		
		$sekil_url=MyFunctionsF::getImageUrl().'/'.$row["cover"];	$infos.="<a href='".Url::to(['/'.$row["id"].'-'.$slugTitle.'.html'])."' target='_blank'><img src='".$sekil_url."'  /></a>";  //alt='".$stripTitle."' title='".$stripTitle."'
		$infos.="<br /><a href='".Url::to(['/'.$row["id"].'-'.$slugTitle.'.html'])."' target='_blank'>Elana bax</a>";
		$infos.='<br /><br />';
		$neyi=array('(',')','"',"'",'  ','	','
'); $neye=array('','','','',' ',' ','<br />');
		$melumat=trim($row["text"]);	$melumat=nl2br($melumat);	$melumat=str_replace($neyi,$neye,$melumat);
		$infos.=$melumat;
		?>
		infolar[<?php echo $say; ?>]="<?php echo $infos; ?>";
		map0[<?php echo $say; ?>]='<?php echo str_replace($neyi,$neye,trim($unvan[0])); ?>';
		map1[<?php echo $say; ?>]='<?php echo str_replace($neyi,$neye,trim($unvan[1])); ?>';
			var selected_marker = new google.maps.LatLng(map0[<?php echo $say; ?>], map1[<?php echo $say; ?>]);
			var marker<?php echo $say; ?> = new google.maps.Marker({
			  position: selected_marker,
			  map: map
			});
			markers.push(marker<?php echo $say; ?>);
			  message = infolar[<?php echo $say; ?>];
			  var infowindow<?php echo $say; ?> = new google.maps.InfoWindow(
				  {
					content: message,
					maxWidth: 300
				  });
			
			  google.maps.event.addListener(marker<?php echo $say; ?>, 'click', function() {
				eval("infowindow"+$("#open_window").val()).close();
				infowindow<?php echo $say; ?>.open(map,marker<?php echo $say; ?>);
				$("#open_window").val(<?php echo $say; ?>);
			  });
	<?php
	$say++;
		}
	} ?>
	var mcOptions = {gridSize: 50, maxZoom: 15};
	var mc = new MarkerClusterer(map, markers, mcOptions);
}  // end function initialize
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<input type="hidden" value="0" id="open_window" />

<div class="content clearfix broker">
    <div class="panel clearfix">
        <h1 class="title"><?=$title; ?><span> / <?=$announces_count; ?> <?=Yii::t('app','lang190'); ?></span></h1>
        <a class="site_icon" href="<?=Url::to([$link]);?>"><?=Yii::t('app','lang291'); ?></a>
    </div>
	
    <div class="ticket-list">
		<div id="map-canvas" style="width:965px;height:650px;margin-bottom:20px;display:static"></div>
    </div>
</div>