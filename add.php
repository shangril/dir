<!DOCTYPE html>
<html><head><meta charset="utf-8"/></head>
<body>
<?php

if (!file_exists('./d')){
	mkdir ('./d');
	}


if (!isset($_GET['m'])&&!isset($_GET['t'])){die();}


$magic = basename($_GET['m']);
$tag = $_GET['t'];

$target = './d/'.$magic.'.dat';

$array = array();

if (file_exists($target)){
	$content=file_get_contents($target);
	if($content!==false){
		$aar=unserialize($content);
		if ($aar!==false){
			$array=$aar;
		}

	
	}
}
array_push($array, $tag);
$datz = serialize ($array);
if ($datz!==false){
	if (file_put_contents($target, $datz)!==false){
			echo 'tag saved <a href="./">ok</a>';
		}
	}

?>
</body>
</html>
