<?php
if($_SESSION["mebleg"]>0)
{
	$zona=$_SESSION["zona"];
	$tarixden=$_SESSION["tarixden"];
	$tarixe=$_SESSION["tarixe"];
	$gun_sayi=$_SESSION["gun_sayi"];
	$kolidor_sayi=$_SESSION["kolidor_sayi"];
	$meqsed=$_SESSION["meqsed"];
	$valyuta=$_SESSION["valyuta"];
	$plan=$_SESSION["plan"];
	$elaqe_nomresi=$_SESSION["elaqe_nomresi"];
	$unvani=$_SESSION["unvani"];
	$hidden_person_count=intval($_SESSION["hidden_person_count"]);
	$insanlar=$_SESSION["insanlar"];
	$index_qaydalar_oxudum_hidden=$_SESSION["index_qaydalar_oxudum_hidden"];
	$seferlerin_sayi=$_SESSION["seferlerin_sayi"];
	$sengen=intval($_SESSION["sengen"]);
}
if($meqsed=="") $meqsed="-";				$meqsed=explode("-",$meqsed);
if($insanlar=="") $insanlar="```";			$insanlar=explode("```",$insanlar);


preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
$version = $matches[1];
//echo "<script>alert('".$_SERVER['HTTP_USER_AGENT']."')</script>";
//echo $_SERVER['HTTP_USER_AGENT'];
?>
<form action="index.php?do=hesab" method="post" onsubmit="return yoxla()">
	<div id="index_page">
		<p class="aktivlik_yoxla" style="background:red;"><a href="index.php?do=aktivliyin_yoxlanisi" style="color:#fff;font-weight:700;"><?php echo $lang13; ?></a></p>
		<p class="kredit_kalkulyatoru"><a href="index.php?do=sigorta_kalkulyatoru"><?php echo $lang14; ?></a></p>
		<div class="clear"></div>
		<p class="sigorta_polisini_al"><?php echo $lang15; ?></p>
		<p class="seyahet_haqqinda_melumat"><?php echo $lang16; ?></p>
		<div class="clear"></div>
		
		<div style="width:330px;overflow:hidden;float:left;margin-right: 13px;">
		<select class="select_bg_plane" id="olkeni_secin" name="zona" style="width:305px">
			<option value="0"><?php echo $lang17; ?></option>
			<?php
				$sql=mysql_query("select * from zonalar where lang_id='$esas_dil' and aktivlik='1' order by auto_id");
				while($row=mysql_fetch_assoc($sql))
				{
					if($zona==$row["auto_id"]) $selected='selected="selected"'; else $selected='';
					echo '<option value="'.$row["auto_id"].'" '.$selected.'>'.$row["name"].'</option>';
				}
			?>
		</select>
		</div>
		
		<div class="input_tarixden">
			<input name="tarixden" class="input_tarixden_text_bg" type="text" value="<?php if($tarixden!="") echo $tarixden; else echo $lang18; ?>" id="datepicker" />
		</div>
		
		<div class="input_tarixe">
			<input name="tarixe" class="input_tarixden_text_bg" type="text" value="<?php if($tarixe!="") echo $tarixe; else echo $lang19; ?>" id="datepicker1" />
		</div>
		<div class="clear"></div>
		<?php
		//if (count($matches)>1 && $version<11) $style='style="margin-left:-286px;height:40px;margin-top:-px;"'; else $style='';
		?>
		<div class="input_gunler_bg" style="margin-left:282px">
			<input name="gun_sayi" <?php echo $style; ?> id="index_gunlerin_sayi" class="input_gunler_text_bg" type="text" value="<?php if($gun_sayi>0) echo $gun_sayi; else echo '0'; ?>" maxlength="4" /> <p id="p_gunler"><?php echo $lang20; ?></p>
		</div>
		
		<div class="input_gunler_bg">
			<input name="kolidor_sayi" id="index_kolidor" class="input_gunler_text_bg" type="text" value="<?php echo $kolidor_sayi; ?>" maxlength="4"  /> <p id="p_kolidor"><?php echo $lang21; ?></p>
		</div>
		<div class="clear"></div>
		<p style="margin-top:5px;color:darkred;text-align:center;display:none" id="error_il"><?php echo $lang122; ?></p>
		<div class="clear"></div>
		
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		<?php
		if (count($matches)>1 && $version<11)
		{
			$sefer_sayi='<p class="seyahet_haqqinda_melumat" style="margin-top:0px">'.$lang125.': <input style="width:30px;height:30px;margin-bottom:-4px;" name="seferlerin_sayi" type="checkbox" id="seferlerin_sayi" value="1"'; if($seferlerin_sayi==1) {$sefer_sayi.='checked="checked"';} $sefer_sayi.=' />  <span class="type_radio" for="seferlerin_sayi">'.$lang126.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<input style="width:30px;height:30px;margin-bottom:-4px;" name="sengen" type="checkbox" id="sengen" value="1"'; if($sengen==1) {$sefer_sayi.='checked="checked"';} $sefer_sayi.=' />  <span class="type_radio" for="sengen">'.$lang132.'</span>
			
			</p>';
		}
		else
		{
			$sefer_sayi='<p class="seyahet_haqqinda_melumat" style="margin-top:0px">'.$lang125.':</p>
		<div class="type_radio" style="margin-top: -30px;margin-left: 200px;margin-bottom: -20px;">
			<input name="seferlerin_sayi" type="checkbox" id="seferlerin_sayi" value="1"'; if($seferlerin_sayi==1) {$sefer_sayi.='checked="checked"';} $sefer_sayi.=' />
			<label for="seferlerin_sayi">'.$lang126.'</label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="sengen" type="checkbox" id="sengen" value="1"'; if($sengen==1) {$sefer_sayi.='checked="checked"';} $sefer_sayi.=' />
			<label for="sengen">'.$lang132.'</label>
		</div>';
		}
		echo $sefer_sayi;
		?>
		
		
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		<div class="clear"></div>
		<p class="seyahet_haqqinda_melumat" style="margin-top:0px"><?php echo $lang22; ?></p>
		<?php
		if (count($matches)>1 && $version<11)
		{
			$meqsedler='<p class="seyahet_haqqinda_melumat" style="margin-top:0px"><input style="width:30px;height:30px;margin-bottom:-4px;" name="meqsed[]" type="checkbox" id="seferlerin_sayi" value="1"'; if(in_array("1",$meqsed)) {$meqsedler.='checked="checked"';} $meqsedler.=' />  <span class="type_radio">'.$lang47.'</span></p>';
			
			$meqsedler.='<p class="seyahet_haqqinda_melumat" style="margin-top:0px"><input style="width:30px;height:30px;margin-bottom:-4px;" name="meqsed[]" type="checkbox" id="seferlerin_sayi" value="1"'; if(in_array("2",$meqsed)) {$meqsedler.='checked="checked"';} $meqsedler.=' />  <span class="type_radio">'.$lang48.'</span></p>';
			
			$meqsedler.='<p class="seyahet_haqqinda_melumat" style="margin-top:0px"><input style="width:30px;height:30px;margin-bottom:-4px;" name="meqsed[]" type="checkbox" id="seferlerin_sayi" value="1"'; if(in_array("3",$meqsed)) {$meqsedler.='checked="checked"';} $meqsedler.=' />  <span class="type_radio">'.$lang49.'</span></p>';
			
			$meqsedler.='<p class="seyahet_haqqinda_melumat" style="margin-top:0px"><input style="width:30px;height:30px;margin-bottom:-4px;" name="meqsed[]" type="checkbox" id="seferlerin_sayi" value="1"'; if(in_array("4",$meqsed)) {$meqsedler.='checked="checked"';} $meqsedler.=' />  <span class="type_radio">'.$lang50.'</span></p>';
		}
		else
		{
			$meqsedler='<div class="type_radio">	
			<input name="meqsed[]" type="checkbox" id="meqsed1" value="1"'; if(in_array("1",$meqsed)) $meqsedler.='checked="checked"'; $meqsedler.=' />
			<label for="meqsed1">'.$lang47.'</label>
			
			<input name="meqsed[]" type="checkbox" id="meqsed2" value="2"'; if(in_array("2",$meqsed)) $meqsedler.='checked="checked"'; $meqsedler.=' />
			<label for="meqsed2">'.$lang48.'</label>
			
			<input name="meqsed[]" type="checkbox" id="meqsed3" value="3"'; if(in_array("3",$meqsed)) $meqsedler.='checked="checked"'; $meqsedler.=' />
			<label for="meqsed3">'.$lang49.'</label>
			
			<input name="meqsed[]" type="checkbox" id="meqsed4" value="4"'; if(in_array("4",$meqsed)) $meqsedler.='checked="checked"'; $meqsedler.=' />
			<label for="meqsed4">'.$lang50.'</label>
		</div>';
		}
		echo $meqsedler;
		?>
		
		<div class="clear"></div>
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		<p class="seyahet_haqqinda_melumat" style="margin-top:0px" id="valyuta_check_label"><?php echo $lang23; ?></p>
		
		
			<?php
			if (count($matches)>1 && $version<11)
			{
				$sql=mysql_query("select * from valyuta where lang_id='$esas_dil' and aktivlik='1' order by sira");
				while($row=mysql_fetch_assoc($sql))
				{
					if($valyuta==$row["auto_id"]) $selected='checked="checked"'; else $selected='';
					echo '<input name="valyuta" type="radio" id="valyuta'.++$inc_valyuta.'" value="'.$row["auto_id"].'" '.$selected.' style="margin-left:45px;" />
					<span class="type_radio">'.$row["name"].'</span>';
				}
			}
			else
			{
			?>
			<div class="type_radio">
				<?php
				$sql=mysql_query("select * from valyuta where lang_id='$esas_dil' and aktivlik='1' order by sira");
				while($row=mysql_fetch_assoc($sql))
				{
					if($valyuta==$row["auto_id"]) $selected='checked="checked"'; else $selected='';
					echo '<input name="valyuta" type="radio" id="valyuta'.++$inc_valyuta.'" value="'.$row["auto_id"].'" '.$selected.' />
					<label for="valyuta'.++$inc_valyuta2.'" style="margin-right:-30px">'.$row["name"].'</label>';
				}
				?>
			</div>
			<?php
			}
			?>
		<input type="hidden" value="<?php if($valyuta>0) echo $valyuta; else echo '0'; ?>" id="valyuta_check" />
		<div class="clear"></div>
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		<p class="seyahet_haqqinda_melumat" style="margin-top:0px" id="plan_check_label"><?php echo $lang51; ?></p>
		<p style="color:white;margin-left:45px;margin-top:-5px;margin-bottom:10px;"><?php echo $lang52; ?></p>
			<?php
			if(intval($zona)==2)
			{
				$view1='display:none';
				$view2='';
			}
			else
			{
				$view1='';
				$view2='display:none';
			}
			?>
			
			<?php
			if (count($matches)>1 && $version<11)
			{
				if($valyuta==$row["auto_id"]) $selected='checked="checked"'; else $selected='';
				/*
				echo '<input name="valyuta" type="radio" id="valyuta'.++$inc_valyuta.'" value="'.$row["auto_id"].'" '.$selected.' style="margin-left:45px;" />
				<span class="type_radio">'.$row["name"].'</span>';
				*/
				echo '<input name="plan" id="plan1" type="radio" style="margin-left:45px;'.$view1.'" value="1"'; if($plan=='1') echo 'checked="checked"'; echo ' >
						<span class="type_radio" style="'.$view1.'" id="plan1_label">15 000</span>';
						
				echo '<input name="plan" id="plan2" type="radio" style="margin-left:45px;'.$view1.'" value="2"'; if($plan=='2') echo 'checked="checked"'; echo ' >
						<span class="type_radio" style="'.$view1.'" id="plan2_label">20 000</span>';
					
				echo '<input name="plan" id="plan3" type="radio" style="margin-left:45px;'.$view1.'" value="3"'; if($plan=='3') echo 'checked="checked"'; echo ' >
						<span class="type_radio" style="'.$view3.'" id="plan3_label">50 000</span>';
						
				echo '<input name="plan" id="plan4" type="radio" style="margin-left:45px;'.$view2.'" value="4"'; if($plan=='4') echo 'checked="checked"'; echo ' >
						<span class="type_radio" style="'.$view2.'" id="plan4_label">30 000</span>';
						
				echo '<input name="plan" id="plan5" type="radio" style="margin-left:45px;'.$view2.'" value="5"'; if($plan=='5') echo 'checked="checked"'; echo ' >
						<span class="type_radio" style="'.$view2.'" id="plan5_label">50 000</span>';
			}
			else
			{
			?>
			<div class="type_radio">
			<input name="plan" type="radio" id="plan1" value="1" <?php if($plan=='1') echo 'checked="checked"'; ?> >
			<label for="plan1" style="margin-right:-30px;<?php echo $view1; ?>" id="plan1_label">15 000</label>
			
			<input name="plan" type="radio" id="plan2" value="2" <?php if($plan=='2') echo 'checked="checked"'; ?> >
			<label for="plan2" style="margin-right:-30px;<?php echo $view1; ?>" id="plan2_label">30 000</label>
			
			<input name="plan" type="radio" id="plan3" value="3" <?php if($plan=='3') echo 'checked="checked"'; ?> >
			<label for="plan3" style="margin-right:-30px;<?php echo $view1; ?>" id="plan3_label">50 000</label>
			
			<input name="plan" type="radio" id="plan4" value="4" <?php if($plan=='4') echo 'checked="checked"'; ?> >
			<label for="plan4" style="margin-right:-30px;<?php echo $view2; ?>" id="plan4_label">30 000</label>
			
			<input name="plan" type="radio" id="plan5" value="5" <?php if($plan=='5') echo 'checked="checked"'; ?> >
			<label for="plan5" style="margin-right:-30px;<?php echo $view2; ?>" id="plan5_label">50 000</label>
			</div>
			<?php
			}
			?>
		<input type="hidden" value="<?php if (count($matches)>1 && $version<11) echo 'explorer'; else echo 'other'; ?>" id="browseri" />
		<input type="hidden" value="<?php if($plan>0) echo $plan; else echo '0'; ?>" id="plan_check" />
		<div class="clear"></div>
		<img class="hr_line2" src="images/hr_line2.png" alt="" style="margin-top:10px;margin-bottom:25px" />
		<p class="seyahet_haqqinda_melumat" style="margin-top:0px;float:left"><?php echo $lang27; ?></p>
		<p class="kredit_kalkulyatoru" id="person_elave_et" style="width:auto;padding-left:15px;padding-right:15px;cursor:pointer"><?php echo $lang28; ?></p>
		<input name="hidden_person_count" type="hidden" value="<?php if($hidden_person_count>1) echo $hidden_person_count; else echo '1'; ?>" id="hidden_person_count" />
		<div id="person_info">
			<?php
			if($hidden_person_count>1)
			{
				for($i=$hidden_person_count;$i>=2;$i--)
				{
					echo '<div id="person_copy_html_'.$i.'">
						<div class="clear"></div>
						<p class="about_ad" id="text_ad_'.$i.'">'.$lang29.' *</p>
						<p class="about_ad" style="margin-left:0px;" id="text_pasport_'.$i.'">'.$lang30.' *</p>
						<p class="about_ad" style="margin-left:0px;" id="text_dogum_gunu_'.$i.'">'.$lang31.' *</p>
						<div class="clear"></div>';
					$bu_insan=explode("`",$insanlar[$i-1]);
					echo '<input class="about_input_text" value="'.$bu_insan[0].'" type="text" placeholder="'.$lang32.'" name="ad_'.$i.'" id="ad_'.$i.'" onblur="person_ad_input(this.id)" />';
					
					echo '<input class="about_input_text" value="'.$bu_insan[1].'" type="text" placeholder="'.$lang33.'" style="margin-left:0px;" name="pasport_'.$i.'" id="pasport_'.$i.'" onblur="person_pasport_input(this.id)" />';
					
					echo '<select class="about_select" name="gun_'.$i.'" id="gun_'.$i.'" onchange="person_gun_input(this.id)">
							<option value="0">'.$lang35.'</option>';
							for($j=1;$j<=31;$j++)
							{
								if($j==$bu_insan[2]) $selected='selected="selected"'; else $selected='';
								echo '<option value="'.$j.'" '.$selected.'>'.$j.'</option>';
							}
					echo '</select>';
					
					echo '<select class="about_select" name="ay_'.$i.'" id="ay_'.$i.'" onchange="person_ay_input(this.id)">
							<option value="0">'.$lang36.'</option>';
							$neyi=array('12','11','10','9','8','7','6','5','4','3','2','1');
							$neye=array($lang12,$lang11,$lang10,$lang9,$lang8,$lang7,$lang6,$lang5,$lang4,$lang3,$lang2,$lang1);
							for($j=1;$j<=12;$j++)
							{
								if($j==$bu_insan[3]) $selected='selected="selected"'; else $selected='';
								$ay1=str_replace($neyi,$neye,$j);
								echo '<option value="'.$j.'" '.$selected.'>'.$ay1.'</option>';
							}
					echo '</select>';
					
					echo '<select class="about_select" name="il_'.$i.'" id="il_'.$i.'" onchange="person_il_input(this.id)">
							<option value="0">'.$lang37.'</option>';
							for($j=date("Y");$j>=date("Y")-80;$j--)
							{
								if($j==$bu_insan[4]) $selected='selected="selected"'; else $selected='';
								echo '<option value="'.$j.'" '.$selected.'>'.$j.'</option>';
							}
					echo '</select>';
					
					echo '<img onclick="person_sil(this.id)" id="_'.$i.'" src="images/del_icon.png" alt="" style="margin-top:14px;cursor:pointer;" />
				<div class="clear">&nbsp;</div>';
				if(date("Y")-$bu_insan[4]>16) $stylesi='display:none'; else $stylesi='';
				echo '<p class="about_ad" id="text_valideyn_empty_'.$i.'" style="'.$stylesi.'">&nbsp;</p>
				<p class="about_ad" id="text_valideyn_ad_'.$i.'" style="margin-left: 0px;'.$stylesi.'">'.$lang123.' *</p>
				<input class="about_input_text" value="'.$bu_insan[5].'" type="text" placeholder="'.$lang123.'" style="margin-left:0px;margin-top:-10px;'.$stylesi.'" name="valideyn_ad_'.$i.'" id="valideyn_ad_'.$i.'" onblur="person_valideyn_ad_input(this.id)" />
				<div class="clear" id="div_clear_valideyn_ad_'.$i.'" style="'.$stylesi.'">&nbsp;</div>
			</div>';
				}
			}
			$ilk_insani=explode("`",$insanlar[0]);
			?>
			<div id="person_copy_html_1">
				<div class="clear"></div>
				<p class="about_ad" id="text_ad_1"><?php echo $lang29; ?> *</p>
				<p class="about_ad" style="margin-left:0px;" id="text_pasport_1"><?php echo $lang30; ?> *</p>
				<p class="about_ad" style="margin-left:0px;" id="text_dogum_gunu_1"><?php echo $lang31; ?> *</p>
				<div class="clear"></div>
				<input class="about_input_text" value="<?php echo $ilk_insani[0]; ?>" type="text" placeholder="<?php echo $lang32; ?>" name="ad_1" id="ad_1" onblur="person_ad_input(this.id)" />
				
				<input class="about_input_text" value="<?php echo $ilk_insani[1]; ?>" type="text" placeholder="<?php echo $lang33; ?>" style="margin-left:0px;" name="pasport_1" id="pasport_1" onblur="person_pasport_input(this.id)" />
				
				<select class="about_select" name="gun_1" id="gun_1" onchange="person_gun_input(this.id)">
					<option value="0"><?php echo $lang35; ?></option>
					<?php
					for($i=1;$i<=31;$i++)
					{
						if($i==$ilk_insani[2]) $selected='selected="selected"'; else $selected='';
						echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
					}
					?>
				</select>
				<select class="about_select" name="ay_1" id="ay_1" onchange="person_ay_input(this.id)">
					<option value="0"><?php echo $lang36; ?></option>
					<?php
					$neyi=array('12','11','10','9','8','7','6','5','4','3','2','1');
					$neye=array($lang12,$lang11,$lang10,$lang9,$lang8,$lang7,$lang6,$lang5,$lang4,$lang3,$lang2,$lang1);
					for($i=1;$i<=12;$i++)
					{
						if($i==$ilk_insani[3]) $selected='selected="selected"'; else $selected='';
						$ay1=str_replace($neyi,$neye,$i);
						echo '<option value="'.$i.'" '.$selected.'>'.$ay1.'</option>';
					}
					?>
				</select>
				<input type="hidden" value="<?php echo date("Y"); ?>" id="indiki_il" />
				<select class="about_select" name="il_1" id="il_1" onchange="person_il_input(this.id)">
					<option value="0"><?php echo $lang37; ?></option>
					<?php
					for($i=date("Y");$i>=date("Y")-80;$i--)
					{
						if($i==$ilk_insani[4]) $selected='selected="selected"'; else $selected='';
						echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
					}
					?>
				</select>
				<img onclick="person_sil(this.id)" id="_1" class="sil_img_1" src="images/del_icon.png" alt="" style="margin-top:14px;cursor:pointer;display:none" />
				<div class="clear">&nbsp;</div>
				
				<?php if(date("Y")-$ilk_insani[4]>16) $stylesi='display:none'; else $stylesi=''; ?>
			<p class="about_ad" id="text_valideyn_empty_1" style="<?php echo $stylesi; ?>">&nbsp;</p>
			<p class="about_ad" id="text_valideyn_ad_1" style="margin-left: 0px;<?php echo $stylesi; ?>"><?php echo $lang123; ?> *</p>
			<input class="about_input_text" value="<?php echo $ilk_insani[5]; ?>" type="text" placeholder="<?php echo $lang123; ?>" style="margin-left:0px;margin-top:-10px;<?php echo $stylesi; ?>" name="valideyn_ad_1" id="valideyn_ad_1" onblur="person_valideyn_ad_input(this.id)" />
			<div class="clear" id="div_clear_valideyn_ad_1" style="<?php echo $stylesi; ?>">&nbsp;</div>
			</div>
		</div>
		<p class="about_ad" id="ad_check_label"><?php echo $lang34; ?> *</p>
		<p class="about_ad" style="margin-left:0px;" id="unvan_check_label"><?php echo $lang38; ?> *</p>
		<div class="clear"></div>
		<input name="elaqe_nomresi" class="about_input_text" type="text" value="<?php if($elaqe_nomresi!="") echo $elaqe_nomresi; ?>" placeholder="<?php echo $lang39; ?>" id="index_elaqe_nomresi" maxlength="26" />
		
		<input name="unvani" id="index_unvan" class="about_input_text" type="text" value="<?php if($unvani!="") echo $unvani; ?>" placeholder="<?php echo $lang40; ?>" style="margin-left:0px;width:409px;background: url(images/about_input_text2_bg.png) no-repeat;" />
		
		<div class="clear"></div>
		<p class="about_ad">&nbsp;</p>
		<p class="about_ad" style="margin-left:0px;width:640px;margin-top:5px;"><?php echo $lang41; ?></p>
		<div class="clear"></div>
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		
		<?php
		if($index_qaydalar_oxudum_hidden==0) echo '<div class="seyahet_haqqinda_melumat" style="margin-top:0px;font-size:17px;">'.$lang42.'<label>'.$lang43.'</label> '.$lang44.'</div>
		<div class="clear"></div>';
		?>
		
		<?php
		/*
		<div class="type_radio" style="text-align:center;margin-left:-20px;margin-top:15px;display:none" id="index_qaydalar_raziyam">
			<input name="raziyam" type="checkbox" id="raziyam1" onchange="qaydalar_raziyam()" />
			<label id="label_raziyam" for="raziyam1" style="margin-right:-30px"><?php echo $lang45; ?></label>
		</div>
		*/
		?>
		<input value="0" type="hidden" id="index_qaydalar_raziyam_hidden" />
		<input value="<?php echo $index_qaydalar_oxudum_hidden; ?>" type="hidden" id="index_qaydalar_oxudum_hidden" name="index_qaydalar_oxudum_hidden" />
		<input value="0" type="hidden" id="is_edit" name="is_edit" />
		<div class="clear"></div>
		
		<div class="index_submit_div">
			<img src="images/protected1.png" alt="" style="margin-top:-4px;margin-left:130px" />
			<img src="images/protected2.png" alt="" />
			<img src="images/protected3.png" alt="" />
			<img src="images/protected4.png" alt="" style="margin-top:7px;" />
			

		</div>
		<div class="clear">&nbsp;</div>
	</div>
	
	<div id="index_qaydalar">
		<p class="aktivliyin_yoxlanmasi" style="font-size:30px"><?php echo $lang65; ?></p>
		<img class="hr_line2" src="images/hr_line2.png" alt="" />
		<div class="qaydalar_inner"><?php echo stripslashes(html_entity_decode($info_sigorta_qaydalari["text"])); ?></div>
		<div class="clear">&nbsp;</div>
		<p class="aktivlik_yoxla_button" style="width:250px;margin-left:375px;" id="index_tanis_oldum"><?php echo $lang66; ?></p>
		<div class="clear">&nbsp;</div>
	</div>
</form>