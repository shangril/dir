<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"/>
<title>Dir</title>
</head>
<body>
<?php

$tagz=array();

$ifles = array_diff(scandir('./d'), array ('.', '..'));

foreach ($ifles as $file){
	if (strstr ($file, '.dat')){




		$d = file_get_contents('./d/'.$file);



		if ($d!==false){
			$da = unserialize ($d);
			if ($da!==false){
				foreach ($da as $tag){
					$tagz[$tag]=$file;
				}
			}
		}

	}

}
echo '<h1>DIR!</h1>A project to help find Hype websites interesting for humans<hr/><h2>Here\'s the tags and then curated sites that have tags. <br/>';

foreach (array_keys($tagz) as $t){
	echo ' - <a href="browse.php?t='.urlencode($t).'">'.htmlspecialchars($t).'</a> - ';	
}

?></h2>
<hr/>
<span style="text-align:center;">
	<h1>How shalt thou help</h1>
	<ol>
		<li>If inclined to do so, visit pinging, untagged site, review them, and if they are interesting for humans to visit, add tags to them</li>
		<li>Lastly, if a site pinged over time, but is now and for very long marked "Mixed" for ping results, and has tags, remove its tags, so it gets out of homepage, and wait for better days</li>
	</ol>
</span>

<hr/>
help curate: <a href="hia-parsed.php">the list</a> - also <a href="source.zip" download">download source</a> - contact? Shangri-l on HypeIRC - v5.0 - <a href="sh.txt">example scheduled tasks shell scripts</a> - <a href="./api-doc.html">HTTP API documentation</a>
</body>
