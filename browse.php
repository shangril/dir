<!DOCTYPE html>
<html>
<head><meta charset="utf-8"/>
<title>Dir</title>
</head>
<body>
<?php

$myt = $_GET['t'];

$tagz=array();

$ifles = array_diff(scandir('./d'), array ('.', '..'));

foreach ($ifles as $file){
	if (strstr ($file, '.dat')){




		$d = file_get_contents('./d/'.$file);



		if ($d!==false){
			$da = unserialize ($d);
			if ($da!==false){
				foreach ($da as $tag){
					if ($tag==$myt){

						$tagz[$file]=$file;

					}
				}
			}
		}

	}

}
$title=array();



if (file_exists('./t'))
{
	$tifles = array_diff(scandir('./t'), array ('.', '..'));

	foreach ($tifles as $file){
		if (strstr ($file, '.dat')){




			$d = file_get_contents('./t/'.$file);



			if ($d!==false){
				$da = unserialize ($d);
				if ($da!==false){
					$title[$file]=$da;
				}
			}

		}

	}
}




echo '<h1><a href="./">DIR</a>: '.htmlspecialchars($myt).'</h1>';


$data = file_get_contents('./listed.txt');

if ($data==false){$data='';}
$results = array();
$urls= array();

$data = explode ("\n", $data);

foreach ($data as $dat){

        if (trim($dat)!=''){
                $tok = explode (' ', $dat);


                if (count ($tok)>0){
			
			

                        $magic = str_replace( 'http://', '', $tok[0]);
                        $magic = str_replace( 'https://', '', $magic);
                        $magic = str_replace( ']:', '_', $magic);
                        $magic = str_replace( '[', '', $magic);
                        $magic = str_replace( '/', '', $magic);
                        $magic = basename($magic);

			$thefile = $magic.'.dat';

                        
                        $results[$thefile]=implode (' ',array_slice ($tok, 1));
                        $url[$thefile]=$tok[0];

                       
		}
	}
}








foreach (array_keys($tagz) as $t){
	$newtitle=$results[$t];
	if (isset($title[$t])){
		$newtitle=$title[$t];
	}
	echo '<br/> <a href="'.htmlspecialchars($url[$t]).'">'.htmlspecialchars($newtitle).'</a> ';	
}

?>


<hr/>
help curate: <a href="hia-parsed.php">the list</a> - also <a href="source.zip" download>download source</a> - contact? Shangri-l on HypeIRC
</body>
