<!DOCTYPE html>
<html><head><meta charset="utf-8"/></head>
<body>
<?php
$file = basename ($_GET['m']);
echo 'Browsing record '.htmlspecialchars($file);
if (file_exists ('./d/'.$file.'.dat')){
	if (isset($_GET['delete'])){
		rename ('./d/'.$file.'.dat', './d/'.$file.'__'.microtime(true).'.bkp');
		
		//mark the ping record as manually untagged
		
		$target = './p/'.$file.'.dat';

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
		$startping=microtime(true);
		$ping_result[floor($startping)]=array();                                    

		$ping_result[$startping]['success']=false;
		$ping_result[$startping]['startping']=$startping;
		$ping_result[$startping]['endping']=$startping;
		$ping_result[$startping]['isHTTPS']=false;
		if ($array[array_key_last($array)]['success']&&((isset($array[array_key_last($array)]['mixed'])&&!$array[array_key_last($array)]['mixed']))||!isset($array[array_key_last($array)]['mixed'])){
			$ping_result[$startping]['mixed']=true;
			
		}
		$ping_result[$startping]['detagged']=true;
		
		
		echo 'trying to save detagg marker. If you see no "saved" line below, it wasn\'t saved<br/>';

		array_push($array, $ping_result);
		$datz = serialize ($array);
		if ($datz!==false){
			if (file_put_contents($target, $datz)!==false){
					echo 'marker saved OK<hr/>';
				}
			}

		
		die ('Site marked "manually detagged", record archived and no longer considered active <a href="./">ok?</a></body></html>');
	}

	$thing = unserialize(file_get_contents('./d/'.$file.'.dat'));

	if ($thing!==false){
		foreach ($thing as $thi){
			echo ' '.htmlspecialchars($thi);
		}		
	   }

	}
echo '<br/><form method="GET" action="add.php"><input type="hidden" value="'.htmlspecialchars($file).'" name="m"/><input type="text" name="t"/><input type="submit" value="add tag"/></form><br/>';
echo '<a href="?delete=delete&m='.urlencode($file).'">delete all tags</a><br/>';
	


?>
</body>
</html>

