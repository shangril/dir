<?php ob_start();?><!DOCTYPE html>
<html><head><meta charset="UTF-8"/></head>
<body>
Attempting retitle, please wait…

<?php
ob_flush();

if (!isset($_GET['m'])){die();}

$title='';

$magic = basename($_GET['m']);

if (!file_exists('./t')){
	mkdir ('./t');
	}


$target = './t/'.$magic.'.dat';

$array = null;

if (file_exists($target)){
	$content=file_get_contents($target);
	if($content!==false){
		$aar=unserialize($content);
		if ($aar!==false){
			$array=$aar;
		}

	
	}
}
$old_title=$array;

$url='http://';
$url.='[';
$url.=str_replace('_', ']:', $magic);

$content=false;


if (is_array(get_headers($url))){

	$content = fopen($url, 'r');
	
	stream_set_timeout($content, 60);

	if (stream_get_meta_data($content)['timed_out']===true){
		fclose ($content);
		$content=false;
		die ('Connection to site timed out. <a href="./">Home</a>.');
	}
	else {
		$wrap = stream_get_meta_data($content)['wrapper_data'];
		
		$run = false;
		
		
		foreach ($wrap as $meal){
			if (strpos($meal, 'Content-Type: text/')==0||strpos($meal, 'Content-type: text/')==0){
				$run=true;
			}
			
		}
		if (!$run){
			$title="Not an text/* content-type served";
		}
		
		fclose($content);
		
		$content=$run;
		
		}


}
if ($content){
	$newhtml = file_get_contents($url);
	if (strpos($newhtml, '<!DOCTYPE html>')!=0){
	
		$newhtml= '<!DOCTYPE html>'."\n".$newhtml;
	
	}

	libxml_use_internal_errors(true);

	$dom = new DOMDocument();

	if($dom->loadHTML($newhtml)) { 

		$elems = $dom->getElementsByTagName("title");
		if ($elems->length > 0) {
			$title = $elems->item(0)->textContent;
		}
		else
		{
			
			
			$newhtml=str_replace('<!DOCTYPE html>', '', $newhtml);
			$title = explode("\n", strip_tags($newhtml))[0];
		}
	}
	else {
		$newhtml=strip_tags($newhtml);
		$toks=explode("\n", $newhtml);
		$i=0;
		while (str_replace ("\t", '', $toks[$i])==''){
		
		
			while (!strstr($toks[$i],"\t")&&isset($toks[$i])&&$toks[$i]===''&&trim($toks[$i])===''){
				$i++;
			}
			$i++;
		}
		$title=$toks[$i];
	}
}
//we don't want title of more than 140 chars long

if (strlen($title)>140){
	$title = substr($title, 0, 138).'…';
}
if (strlen(trim($title))==0&&isset($newhtml)){
	$title = preg_split('#\r?\n#', ltrim(strip_tags($newhtml)), 2)[0];
	

}
else if(strlen(trim($title))==0){
	$title='Site';
}
if ($old_title!==$title){
	
	echo '<br/>Trying to save title. If you cannot see a saved ok mention line below, it was not saved<br/>';
	

	$datz = serialize ($title);
	if ($datz!==false){
		if (file_put_contents($target, $datz)!==false){
				echo 'title saved ok, <a href="./">go home?</a><hr/>';
			}
		}
}
else
{
	echo 'title hasn\'t changed. <a href="./">go home?</a><hr/>';
	die('</html>');
}
?>
Retitle résult: <br/> 
<?php
echo htmlentities($title);
?>
</body>
</html>
