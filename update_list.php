<!DOCTYPE html>
<html><head><meta charset="utf-8"/></head>
<?php
$data = file_get_contents('http://hia.cjdns.ca/watchlist/hia-parse-http-titles.html');
$output = '';

if ($data!==false){
	if (strlen($data)>0){
		if (strstr($data, "\n")){
			$data=strip_tags($data);
			
			file_put_contents('./listed.txt', $data);

		}
	}
}

?>



<body>
An update attempt has been made and may have failed or not. <a href="./">You are done</a>. 
</body>
</html>
