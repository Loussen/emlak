<?php
use backend\components\MyFunctions;
?>
<b><?=$id?> kodlu elanəm tarixçəsi:</b><hr />
<?php
foreach($archives as $row)
{
    //$src=MyFunctions::getImageUrl().'/'.$image;
    echo '<div style="border:1px solid #ccc;padding:7px;margin-bottom:15px;">
	Əməliyyat: <b>'.$row["operation"].' ('.$row["create_time"].')</b><br/>
	From: <b>'.$row["from_"].'</b><br/>
	To: <b>'.$row["to_"].'</b><br/>
	Mobiles: <b>'.$row["mobiles"].'</b><br/>
	Insert type: <b>'.$row["insert_type"].'</b><br/>
	Müddət: <b>'.$row["time_count"].'</b><br/>
	Gəlir: <b>'.$row["price"].'</b><br/>
	Qeyd: <b>'.$row["note"].'</b><br/>
	Mətn: <b>'.$row["text"].'</b>
	</div>';
}
?>
