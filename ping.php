<?php ob_start();?><!DOCTYPE html>
<html><head><meta charset="utf-8"/></head>
<body>
Attempting ping, please wait…

<?php
ob_flush();

if (!isset($_GET['m'])){die();}


$magic = basename($_GET['m']);

if (!file_exists('./p')){
	mkdir ('./p');
	}


$target = './p/'.$magic.'.dat';

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
$ping_result=array();

$url='http://';
$url.='[';
$url.=str_replace('_', ']:', $magic);


$startping = microtime(true);
$ping_result[floor($startping)]=array();                                    

$content=false;


if (is_array(get_headers($url))){

	$content = fopen($url, 'r');
	
	stream_set_timeout($content, 60);

	if (stream_get_meta_data($content)['timed_out']===true){
		fclose ($content);
		$content=false;

	}
	else {fclose($content);$content=true;}


}

$endping = microtime(true);

if (false===$content){
	$ping_result[$startping]['success']=false;
	$ping_result[$startping]['startping']=$startping;
	$ping_result[$startping]['endping']=$endping;
	$ping_result[$startping]['isHTTPS']=false;
	$mix=false;
	foreach ($array as $pongo){
		foreach ($pongo as $pongoo){
			if ($pongoo['success']){$mix=true;}
		}
	}
	$ping_result[$startping]['mixed']=$mix;
}
else{
	$ping_result[$startping]['success']=true;
        $ping_result[$startping]['startping']=$startping;
        $ping_result[$startping]['endping']=$endping;
        $ping_result[$startping]['isHTTPS']=false;
		$ping_result[$startping]['mixed']=false;

}

echo 'trying to save ping. If you see no "saved" line below, it wasn\'t saved<br/>';

array_push($array, $ping_result);
$datz = serialize ($array);
if ($datz!==false){
	if (file_put_contents($target, $datz)!==false){
			echo 'ping saved, <a href="./">go home?</a><hr/>';
		}
	}

?>
Ping résult: <br/>Status: 
<?php
if($ping_result[$startping]['success']){
	echo "Success";
	}
else{
	echo "Failure";
}
echo '<br/>';
echo 'Time: '.$endping-$startping." seconds<br/>";


?>
</body>
</html>
