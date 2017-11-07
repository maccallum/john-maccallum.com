<?php
if(isset($_GET["freq"])){
$freq = $_GET["freq"];
}else{
die();
}
$text = $_GET["text"];
if($text == NULL){
$text = "";
}
$transport = $_GET["transport"];

// echo "<h1>";
// if(text != ""){
// echo $text."<br>";
// echo "(".$freq." Hz)";
// }else{
// echo $freq." Hz";
// }
// echo "<br>";
if($transport == "start"){
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body>";
echo "<script>";
echo "var audioCtx = new (window.AudioContext || window.webkitAudioContext)();";
echo "var oscillator = audioCtx.createOscillator();";
echo "oscillator.type = 'triangle';";
echo "oscillator.frequency.value = ".$freq.";";
//echo "oscillator.connect(audioCtx.destination);";

echo "var gainNode = audioCtx.createGain();";
echo "oscillator.connect(gainNode);";
echo "gainNode.connect(audioCtx.destination);";
echo "gainNode.gain.value = .5;";

echo "oscillator.start();";
echo "</script>";
echo "<a href=\"".$_SERVER['PHP_SELF']."?transport=stop&freq=".$freq."&text=".$text."\">stop</a>";
}else{
echo "<a href=\"".$_SERVER['PHP_SELF']."?transport=start&freq=".$freq."&text=".$text."\">start</a>";
}
//echo "</h1>";
echo "</body>";
echo "</html>";
?>
