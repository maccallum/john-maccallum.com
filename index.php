<?php
$mainpage = "index.php";
$dim = NULL;
$indices = NULL;
$page = $_GET["page"];

$enablelogging = false;
$enablelogging = $_GET["enablelogging"];
$logstring = "";
if($enablelogging == true){
	$logstring = "&enablelogging=true";
}
$logfilename = "log.txt";
if($_GET["clearlog"] == true){
	if(file_exists($logfilename)){
		unlink($logfilename);
	}
}

$excludes = array("index.php" => true, "index.alpha.php" => true, "index.php.bak" => true, "bg.png" => true, "map.txt" => true, "dontmessup" => true, "log.txt" => true, "dl" => true, "niftyplayer" => true, "make-bg.pl" => true, "favicon.gif" => true, "favicon.ico" => true, "test.php" => true, "wind.js" => true, "title.txt" => true, "diss" => true, "blog" => true, "blog.old" => true, "dav" => true, "scripts" => true, "wp-content" => true, "scordatura.php" => true);
$functions_for_extensions = array("txt" => "writetext", "pdf" => "writelinktofile", "mp3" => "makeplaya");
$functions_for_files = array("soundcloud" => "makescplaya");

if(!$page){
	$page = '.';
}

function makescplaya($filename, $x, $y, $inv)
{
	global $page;
	if($inv != false){
		echo "<div id=\"$inv\" style=\"position: absolute; left: $x; top: $y; visibility: hidden\">";
	}
	$fullpath = "$page/$filename";
	$fh = fopen($fullpath, 'r');
	$sctag = fread($fh, filesize($fullpath));
	echo $sctag . "\n";
	echo "</div>";
	fclose($fh);
}

function makeplaya($sf, $x, $y, $inv){
	global $page;
	$sfpath = "$page/$sf";
	if($inv != false){
		echo "<div id=\"$inv\" style=\"position: absolute; left: $x; top: $y; visibility: hidden\">";
	}else{

	}
	//echo '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F88359439&amp;color=505050&amp;auto_play=false&amp;show_artwork=false"></iframe>';
	echo "</div>";
}

function getext($filename){
	if(is_dir($filename)){
		return "";
	}
	$filename = strtolower($filename);
	$ext = preg_split("/\./", $filename);
	if(count($ext) == 1){
		return "";
	}else{
		return $ext[count($ext) - 1];
	}
}

function getfilenames($page){
	global $excludes;
	$l = array();
	if(is_dir($page)){
		if($dir = opendir($page)){
			while(($f = readdir($dir)) !== false){
				if(preg_match('/^[^.].*[^~]$/', $f) && !array_key_exists($f, $excludes)){
					array_push($l, $f);
				}
			}
			return $l;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function domapping($key){
	global $page;
	$val = $key;
	$mapfile = "$page/map.txt";
	if(file_exists($mapfile)){
		$mh = fopen($mapfile, 'r');
		$map = fread($mh, filesize($mapfile));
		if(preg_match("/$key\s(.*)(?>\n|$)/", $map, $matches)){
			$val = $matches[1];
		}
	}
	return $val;
}

function writelinktodir($dir, $x, $y, $inv){
	global $page, $enablelogging, $mainpage;
	$messedup = domapping($dir);
	//$messedup = $dir;
	if(!file_exists("$page/dontmessup")){
		$messedup = messup($messedup);
	}
	if($inv != false){
		echo "<span id=\"$inv\" style=\"position: absolute; left: $x; top: $y; visibility: hidden;\"> <a href=\"$mainpage?page=$page/$dir$logstring\">$messedup</a> </span>\n";
	}else{
		echo "<span style=\"position: absolute; left: $x; top: $y\"> <a href=\"$mainpage?page=$page/$dir$logstring\">$messedup</a> </span>\n";
	}
}

function writelinktofile($filename, $x, $y, $inv){
	global $page, $mainpage;
	$messedup = domapping($filename);
	if(!file_exists("$page/dontmessup")){
		$messedup = messup($messedup);
	}
	if($inv != false){
		echo "<span id=\"$inv\" style=\"position: absolute; left: $x; top: $y; visibility: hidden;\"> <a href=\"$page/$filename\">$messedup</a> </span>\n";
	}else{
		echo "<span style=\"position: absolute; left: $x; top: $y\"> <a href=\"$page/$filename\">$messedup</a> </span>\n";
	}
}

function writetext($filename, $x, $y, $inv){
	global $page, $mainpage;
	$fh = fopen("$page/$filename", 'r');
	$text = fread($fh, filesize("$page/$filename"));
	if($inv != false){
		echo "<span id=\"$inv\" class=\"text\" style=\"position: absolute; left: $x; top: $y; visibility: hidden\">\n";
	}else{
		echo "<span class=\"text\" style=\"position: absolute; left: $x; top: $y\">\n";
	}
	echo $text;
	echo "</span>\n";
}

function writeboguspage(){
	echo "<html><head></head><body>";
	for($i = 0; $i < 200; $i++){
		$x = rand(0, 1200);
		$y = rand(0, 1000);
		echo "<span style=\"position: absolute; left: $x; top: $y\">" . rand(0, 1) . "</span>\n";
	}
	echo "</body></html>";
}

function writeheader($bgfile){
	echo "<html><head>";
	echo "<meta http-equiv=\"cache-control\" content=\"no-cache\">";
	echo "<meta http-equiv=\"expires\" content=\"0\">";
	echo "<meta http-equiv=\"pragma\" content=\"no-cache\">";
	echo "<script type=\"text/javascript\" language=\"javascript\">";
        echo "function messup(word){";
        echo "var st = \"\";";
        echo "var ar = word.split(\"\");";
        echo "for(var i = 0; i < ar.length; i++){";
        echo "st = st + ar[i];";
        echo "r = Math.floor(Math.random() * 3);";
        echo "for(var j = 0; j < r; j++){";
        echo "st = st + \"&mdash;\";";
        echo "}";
        echo "}";
        echo "st = st.replace(\"_\", \"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\");";
        echo "return st;";
        echo "}";
        echo "</script>";
	echo "</head>";
	echo "<style>";
	echo "a{font-family: \"Courier New\", Courier, monospace; text-decoration:none; color:#000000;}";
	echo "body{font-family: \"Courier New\", Courier, monospace; margin: 0px; padding: 0px; background-image: url(\"$bgfile\"); background-repeat: no-repeat;}";
	echo ".text{border: 1px black; border-style: solid; padding: 4px;}";
	echo ".invisible{border: 1px black; border-style: solid; padding: 4px; visibility: hidden}";
	echo "</style>";
	echo "<body>";
}

function writefooter(){
	echo "</body></html>";
}

function messup($word){
	$st = "";
	$ar = str_split($word);
	foreach($ar as $ch){
		$st = $st . $ch;
		$r = rand(0, 3);
		for($i = 0; $i < $r; $i++){
			$st = $st . "&mdash;";
		}
	}
	$st = str_replace("_", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $st);
	//echo $st . "\n";
	return $st;
}

function makebg($width, $height, $xmin, $coords, $bgfile){
	global $makebgscript;
	$command = "perl $makebgscript " . (string)$width . " " . (string)$height . " " . $xmin . " " . implode(" ", $coords) . " > $bgfile";
	log2file($command);
	shell_exec($command);
}

function makecoords($dim){
	$imgwidth = array_shift($dim);
	$imgheight = array_shift($dim);
	$coords = array();
	$currenty = 10;
	for($i = 0; $i < sizeof($dim) / 2; $i++){
		$w = $dim[$i * 2];
		$h = $dim[$i * 2 + 1];
		$x = rand(10, 200);
		$y = rand($currenty + 10, $currenty + 10 + 100);
		array_push($coords, $x);
		array_push($coords, $y);
		$currenty = $y + $h;
	}
	return $coords;
}

function trashbg(){
	$files = getfilenames(".");
	foreach($files as $f){
		if(preg_match("/bg_[0-9]+\.png/", $f)){
			unlink($f);
		}
	}
}

function log2file($msg){
	global $enablelogging;
	if($enablelogging == false){
		return;
	}
	global $logfilename;
	$fh = fopen($logfilename, 'a');
	fwrite($fh, date("D M j G:i:s T Y") . "  ");
	fwrite($fh, $msg . "\n");
	fclose($fh);
}

function gettitle(){
	global $page;
	if(file_exists("$page/title.txt")){
		$fp = fopen("$page/title.txt", "r");
		$title = fread($fp, filesize("$page/title.txt"));
		return $title;
	}else{
		$title = explode("/", $page);
		return $title[sizeof($title) - 1];
	}
}

function writeprobeheader(){
	echo "<html><head>\n";
	echo "<script type=\"text/javascript\" src=\"wind.js\"></script>\n";
	echo "<script type=\"text/javascript\" language=\"javascript\">";
        echo "function messup(word){";
        echo "var st = \"\";";
        echo "var ar = word.split(\"\");";
        echo "for(var i = 0; i < ar.length; i++){";
        echo "st = st + ar[i];";
        echo "r = Math.floor(Math.random() * 3);";
        echo "for(var j = 0; j < r; j++){";
        echo "st = st + \"&mdash;\";";
        echo "}";
        echo "}";
        echo "st = st.replace(\"_\", \"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\");";
        echo "return st;";
        echo "}";
        echo "</script>";
	echo "<title>" . messup("john") . "&mdash;&mdash;&mdash;&mdash;" . messup("maccallum") . "</title>\n";
	echo "<style>\n";
	echo "a{font-family: \"Courier New\", Courier, monospace; text-decoration:none; color:#000000;}\n";
	echo "body{font-family: \"Courier New\", Courier, monospace; margin: 0px; padding: 0px}\n";
	//echo ".text{border: 1px black; border-style: solid; padding: 4px;}\n";
	echo ".txt{border-style: none}\n";
	echo ".invisible{border: 1px black; border-style: solid; padding 4px; visibility: hidden}\n";
	echo "</style>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<canvas id=\"mycanvas\" width=0 height=0 style=\"position: absolute; left: 0; top: 0\"></canvas>\n";
}

trashbg();
$filenames = getfilenames($page);
$maxwidth = 750;
if(count($filenames) > 0){
	$indices = range(0, sizeof($filenames) - 1);
	shuffle($indices);
	$counter = 0;
	writeprobeheader();
	$title = gettitle();
	$title = messup($title);
	if($page != "."){
		$ar = explode("/", $page);
		$prev = $ar[sizeof($ar) - 2];
		$prevpage = $ar[0];
		for($i = 1; $i < sizeof($ar) - 1; $i++){
			$prevpage = $prevpage . "/" . $ar[$i];
		}
		if($prev != "."){
			$prev = messup($prev);
			echo "<a href=\"http://john-maccallum.com/$mainpage?page=$prevpage\" id=\"prev\" style=\"position: absolute; left: 0; top: 0; color: gray\">$prev</a>\n";
		}
		echo "<span id=\"mytitle\" class=\"text\" style=\"position: absolute; left: 0; top: -2; visibility: hidden; color: gray; border: none\">$title</span>\n";
		echo "<a href=\"http://john-maccallum.com/$mainpage\" id=\"home\" style=\"position: absolute; left: 0; top: 0; visibility: hidden; color: gray; border: none; color: gray\">h<br>o<br>m<br>e</a>\n";
	}
	echo "<script type=\"text/javascript\">var foo=\"mailto:john.m\";var bar=\"@\";var bloo=\"somebullshit.edu\";var sploo=\"ccallum.com\";document.write(\"<a href=\" + foo + bar + sploo + \" id=\\\"666\\\" style=\\\"border-bottom-style: solid; border-width: 1px; position: absolute; top: 0; left: 0; color: gray; visibility: hidden\\\">john maccallum, composer</a>\");</script>\n";

	foreach($indices as $idx){
		$f = $filenames[$idx];
		$path = "$page/$f";
		//echo "<span class=\"invisible\"; id=\"invisible_$counter\">\n";
		if(is_dir($path)){
			writelinktodir($f, 0, 0, "invisible_$counter");
		}else{
			$ext = getext($f);
			if($ext){
				if(array_key_exists($ext, $functions_for_extensions)){
					$func = $functions_for_extensions[$ext];
					call_user_func($func, $f, 0, 0, "invisible_$counter");
				}else{
					writelinktofile($f, 0, 0, "invisible_$counter");
				}
			}else{
				if(array_key_exists($f, $functions_for_files)){
					$func = $functions_for_files[$f];
					call_user_func($func, $f, 0, 0, "invisible_$counter");
				}else{
					writelinktofile($f, 0, 0, "invisible_$counter");
				}
			}
		}
		//echo "</span>\n";
		$counter++;
	}
	echo "<script type=\"text/javascript\">\n";
	echo "var pw = pageWidth();\n";
	echo "var ph = pageHeight();\n";

	//echo "document.write(\"<canvas id=\\\"mycanvas\\\" width=\" + pw + \" height=\" + ph + \" style=\\\"position: absolute; left: 0; top: 0\\\">\");\n";

	//echo "document.write(\"</canvas>\");\n";

	echo "var ypos = 0;\n";
	echo "var xmin = 1000000;\n";
	echo "var xmax = 0;\n";
	echo "var ymax = 0;\n";
	echo "var coords = new Array();\n";
	echo "for(var i = 0; i < $counter; i++){\n";
	echo "var txt = document.getElementById(\"invisible_\" + i);\n";
	echo "var w = txt.offsetWidth + 1;\n";
	echo "if(w > $maxwidth){w = pw - 200 - Math.floor((Math.random() * 200));}\n";
	echo "txt.style.width = w;\n";
	echo "var h = txt.offsetHeight + 1;\n";
	echo "var x = (Math.random() * 100) + 20;\n";
	echo "var y = (Math.random() * 100) + (ypos + 30);\n";
	echo "if(x < xmin){xmin = x;}\n";
	echo "if(x > xmax){xmax = x;}\n";
	echo "if((y + h) > ymax){ymax = y + h;}\n";
	echo "ypos = y + h;\n";
	echo "coords.push(x);\n";
	echo "coords.push(y);\n";
	echo "txt.style.left = x;\n";
	echo "txt.style.top = y;\n";
	echo "txt.style.visibility = \"visible\";\n";
	echo "}\n";
	echo "xmin -= 10;\n";
	echo "ymax += 20;\n";

	//echo "document.write(\"<canvas id=\\\"mycanvas\\\" style=\\\"width: \" + pw + \"; height: \" + ph + \"; position: absolute; left: 0; top: 0\\\">\");\n";
	echo "var canvas = document.getElementById(\"mycanvas\");\n";
	echo "canvas.width = pw;\n";
	echo "if(ymax > ph){canvas.height = ymax}else{canvas.height = ph};\n";
	echo "var ctx = canvas.getContext('2d');\n";
	echo "ctx.lineWidth = 0.33;\n";
	echo "for(var i = 0; i < $counter; i++){\n";
	echo "ctx.moveTo(coords[i * 2] - 1, coords[i * 2 + 1] + 8);\n";
	echo "ctx.lineTo(xmin, coords[i * 2 + 1] + 8);\n";
	echo "ctx.stroke();\n";
	echo "}\n";
	echo "ctx.moveTo(xmin, coords[1] + 8);\n";
	echo "ctx.lineTo(xmin, coords[coords.length - 1] + 8);\n";
	echo "ctx.stroke();\n";

	echo "var mytitle = document.getElementById(\"mytitle\");\n";
	echo "if(mytitle){\n";
	echo "var mytitle_width = mytitle.offsetWidth;\n";
	echo "var mytitle_height = mytitle.offsetHeight;\n";
	echo "if(ymax > ph){mytitle_width += 20;}\n";
	echo "mytitle.style.left = pw - mytitle_width;\n";
	echo "mytitle.style.visibility = \"visible\";\n";
	echo "}\n";

	echo "var home = document.getElementById(\"home\");\n";
	echo "if(home){\n";
	echo "var home_width = home.offsetWidth;\n";
	echo "var home_height = home.offsetHeight;\n";
	echo "var pad = 0;\n";
	echo "if(ymax > ph){pad = 20;}\n";
	echo "home.style.left = pw - home_width - pad;\n";
	echo "home.style.top = ph - home_height - pad;\n";
	echo "home.style.visibility = \"visible\";\n";
	echo "}\n";

	if($page == "."){
		echo "var nn = document.getElementById(\"666\");\n";
		echo "w = nn.offsetWidth;\n";
		echo "h = nn.offsetHeight;\n";
		echo "nn.style.top = (ph / 3) * 2;\n";
		echo "nn.style.left = (pw / 2) - (w / 2)\n";
		echo "nn.style.visibility = \"visible\";\n";
		echo "ctx.moveTo(pw / 2, ph);\n";
		echo "ctx.lineTo(pw / 2, ((ph / 3) * 2) + h);\n";
		echo "ctx.stroke();\n";
	}

	/*
	echo "ctx.moveTo(0, title_height / 2);\n";
	echo "ctx.lineTo(pw - title_width, title_height / 2);\n";
	echo "ctx.stroke();\n";
	echo "ctx.moveTo(pw - (home_width / 2), title_height);\n";
	echo "ctx.lineTo(pw - (home_width / 2), ph - home_height);\n";
	echo "ctx.stroke();\n";
	*/
	echo "</script>\n";
	writefooter();
}else{
	writeboguspage();
}

?>