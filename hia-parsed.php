<!DOCTYPE html>
<html>
<head><meta charset="utf-8"/><title>List of Hyperboria parsed websites -with a title at root document- as retreived by hia.cjdns.ca</title></head>
<body>
<?php
$date=0;
$htmlpinged='';
$htmlunpinged='';
$htmlpingfails='';
$htmlpingmixed='';
$htmlpinguntagged='';



if (file_exists('./listed.txt')){
	$date=filemtime('./listed.txt');

}

echo 'This list was last updated on '.date(DATE_RSS, $date).'. <a href="update_list.php">Update now</a> - <a href="./listed.txt">txt export</a> - <a href="./">DIR! Homepage</a><br/> ';

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
						$title=$da;
					}
				}

				
			}
			if (strlen(trim($title))==0){
				$title="The Dir currently don't know the title of this site";
			}


			$html.='<hr/>';
			$html.=htmlspecialchars($tok[0]).' <a href="'.htmlspecialchars($tok[0]).'">'.htmlspecialchars($title).'</a>';
			$html.='<br/>';
			
			$file = './d/'.$magic.'.dat';
			
			if (file_exists($file)){
			
				$filedat=file_get_contents($file);
				if ($filedat !== false)
				{
					$thing = unserialize($filedat);
			
					if ($thing !== false && is_array($thing)){
						
						foreach ($thing as $thi){
							$html.= ' ['.htmlspecialchars($thi).']';
						}

					}
				}
			}
			$html.= ' - <a href="./update.php?m='.urlencode($magic).'">add tags</a>';
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





			$html.= '<br/>';
			
			
			
			
			
			$html.= 'ping status : ';
			if (count($pingarray)==0){
				$html.= 'No ping attempted as far as it can be known, and never.';
				$html.= '<a href="./ping.php?m='.urlencode($magic).'">Ping now</a>';
				$htmlunpinged.=$html;
				}			
			else {  

                           	
                $pingarray = $pingarray[count($pingarray)-1];

				krsort($pingarray, SORT_NUMERIC);

				
				$startping = array_keys($pingarray)[0];

				

				if($pingarray[$startping]['success']&&(!isset($pingarray[$startping]['mixed'])||!$pingarray[$startping]['mixed'])){
				        $html.= '<strong style="color:green;">Success</strong>';
				        }
				else if (!isset($pingarray[$startping]['mixed'])||!$pingarray[$startping]['mixed']){   
				        $html.= '<em style="color:red;">Failure</em>';
				}
				else {$html.='<em style="color:blue;">Mixed</em>';}
				$html.= '<br/>';
				$html.= 'Time: '.$pingarray[$startping]['endping']-$pingarray[$startping]['startping']." seconds. Date: ".date(DATE_RSS, $startping);

			
				$html.= '<br/><a href="./ping.php?m='.urlencode($magic).'">Ping now</a> - <a href="./retitle.php?m='.urlencode($magic).'">Retitle now</a>';
				if (isset($pingarray[$startping]['detagged'])&&$pingarray[$startping]['detagged']){
					$html.='<br/><strong>This site as been detagged, which means it has been online, valuable, tagged, but <em>probably</em> went offline for a while, and someone detagged it</strong>';
				}


				if ($pingarray[$startping]['success']){$htmlpinged.=$html;}
				else if(!$pingarray[$startping]['success']&&!(isset($pingarray[$startping]['detagged'])&&$pingarray[$startping]['detagged'])&&(!isset($pingarray[$startping]['mixed'])||(isset($pingarray[$startping]['mixed'])&&!$pingarray[$startping]['mixed']))){$htmlpingfails.=$html;}
				else if((isset($pingarray[$startping]['mixed'])&&$pingarray[$startping]['mixed'])){$htmlpingmixed.=$html;}
				else {$htmlpinguntagged.=$html;}
			}

		}

	}
}

echo $htmlpinged;
echo $htmlpingmixed;
echo $htmlpinguntagged;
echo $htmlpingfails;
echo $htmlunpinged;
?>
</body>
</html>

