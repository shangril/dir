<?php
header('Content-Type: text/plain; charset=utf-8');

if (!isset($_GET['c'])){
	die();
}



//***********
//building the dataset
//***********

$htmlpinged='';
$htmlunpinged='';
$htmlpingfails='';
$htmlpingmixed='';
$htmlunpinged='';
$sitetags=array();
$sitetitles=array();
//we'll cache it for 36 hours
if (file_exists('./apicache.dat')&&filemtime('./apicache.dat')+(60*60*36)<time()||!file_exists('./apicache.dat')){
	$data = file_get_contents('./listed.txt');

	$data = explode ("\n", $data);

	foreach ($data as $dat){

		if (trim($dat)!=''){
			$tok = explode (' ', $dat);
			

			if (count ($tok)>0){
				$html='';
				$title=implode (' ',array_slice ($tok, 1));
				
				
				$magic = str_replace( 'http://', '', $tok[0]);
				$magic = str_replace( 'https://', '', $magic);
				$magic = str_replace( ']:', '_', $magic);
				$magic = str_replace( '[', '', $magic);
				$magic = str_replace( '/', '', $magic);
				$magic = basename($magic);			
				if (file_exists('./t/'.$magic.'.dat')){
					$d = file_get_contents('./t/'.$magic.'.dat');



					if ($d!==false){
						$da = unserialize ($d);
						if ($da!==false){
							$sitetitles[str_replace('_', ' ', $magic)]=$da;
						}
					}

					
				}

				
	//fill tag array			
				$file = './d/'.$magic.'.dat';
				
				if (file_exists($file)){
				
					$filedat=file_get_contents($file);
					if ($filedat !== false)
					{
						$thing = unserialize($filedat);
				
						if ($thing !== false && is_array($thing)){
								 $sitetags[str_replace('_', ' ', $magic)]=$thing;

						}
					}
				}
				$pingarray = array();

				$target = './p/'.$magic.'.dat';


				if (file_exists($target)){
						$content=file_get_contents($target);
						if($content!==false){
								$aar=unserialize($content);
								if ($aar!==false){
										$pingarray=$aar;
								}


						}
				}





				if (count($pingarray)==0){
					$htmlunpinged.=str_replace('_', ' ', $magic)."\n";
					}			
				else {  

								
					$pingarray = $pingarray[count($pingarray)-1];

					krsort($pingarray, SORT_NUMERIC);

					
					$startping = array_keys($pingarray)[0];

					

					if($pingarray[$startping]['success']&&(!isset($pingarray[$startping]['mixed'])||!$pingarray[$startping]['mixed'])){
							$htmlpinged.=str_replace('_', ' ', $magic)."\n";
							}
					else if (!isset($pingarray[$startping]['mixed'])||!$pingarray[$startping]['mixed']){   
							$htmlpingfails.=str_replace('_', ' ', $magic)."\n";
					}
					else {$htmlpingmixed.=str_replace('_', ' ', $magic)."\n";}
				}

			}

		}
	}
	//***********
	//dataset built
	//***********	
	//now cache it
	$cache=array();
	
	$cache['sitetags']=$sitetags;
	$cache['htmlpinged']=$htmlpinged;
	$cache['pingfails']=$htmlpingfails;
	$cache['pingmixed']=$htmlpingmixed;
	$cache['unpinged']=$htmlunpinged;
	$cache['sitetitles']=$sitetitles;
	
	file_put_contents('./apicache.dat',serialize($cache));
	
} else //cache is still fresh enough

{
	$cacheddat=unserialize(file_get_contents('./apicache.dat'));
	
	$sitetags=$cacheddat['sitetags'];
	$htmlpinged=$cacheddat['htmlpinged'];
	$htmlpingfails=$cacheddat['pingfails'];
	$htmlpingmixed=$cacheddat['pingmixed'];
	$htmlunpinged=$cacheddat['unpinged'];
	$sitetitles=$cacheddat['sitetitles'];


}	
if ($_GET['c']=='list'){

	echo $htmlpinged;
	
	if (!isset($_GET['l'])){die();}
	
	if ($_GET['l']=='m'){
		echo $htmlpingmixed;
		die();
	}
	if ($_GET['l']=='f'){
		echo $htmlpingmixed;
		echo $htmlpingfails;
		die();
	}			
	if ($_GET['l']=='a'){
		echo $htmlpingmixed;
		echo $htmlpingfails;
		echo $htmlunpinged;
		die();
	}			
	
}
if ($_GET['c']=='title'){
	if (!isset($_GET['i'])&&!isset($_GET['p'])){die();}
	echo $sitetitles[$_GET['i'].' '.$_GET['p']];
	die();
}
if ($_GET['c']=='tags'){
	if (!isset($_GET['i'])&&!isset($_GET['p'])){die();}
	$tagz=$sitetags[$_GET['i'].' '.$_GET['p']];
	if (is_array($tagz)){
		foreach ($tagz as $t){
			echo $t."\n";
		}
	}
	die();
}


die();
?>
