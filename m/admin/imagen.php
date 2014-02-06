<?
	include("../application.php");
	
	$campo=$_GET["field"];
	$strQuery="
		SELECT
			$campo,
			mmdd_" . $campo . "_filetype,
			mmdd_" . $campo . "_filesize,
			mmdd_" . $campo . "_filename
		FROM $_GET[table]
		WHERE id = '$_GET[id]'
	";
	$qid=$db->sql_query($strQuery);
	if($result=$db->sql_fetchrow($qid)){
		$imgName=$result["mmdd_" . $campo . "_filename"];
		$imgType=$result["mmdd_" . $campo . "_filetype"];
		$imgSize=$result["mmdd_" . $campo . "_filesize"];
		$imgImg=base64_decode($result[$campo]);
		header("Content-type: " . $imgType);
		header('Content-Disposition: inline; filename="' . $imgName . '"');
		echo $imgImg;
	}
?>
