<?php
$a = array(0,1,2,3,4);
$b = -1;
$am = array();
foreach($a as $at){
	if($b == -1){
		array_push($am, $at);
	}
	else{
		array_push($am,"jinx");
	}
	$b *= -1;
}
print_r($am);
?>