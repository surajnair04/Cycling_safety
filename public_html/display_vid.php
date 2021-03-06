<?php

function compare($a,$b)
{
	if ($a===$b)
  	{
  		return 0;
  	}
  return ($a > $b) ? 1 : -1;
}

function toArr($res){
	$arr = array();

	while($row = $res->fetch_assoc()){
		arr.array_push($arr, $row["videoid"]);
	}
	return $arr;
}

session_start();    //Start session

$db_name = "cyclings_vid1";
$conn = mysqli_connect("localhost","cyclings_jiahui","@2n54a=@]ZQ4", $db_name);

if(mysqli_connect_errno())
{
	echo"failed to connect to mysql:".mysqli_connect_error();
}

$sql = "SELECT videoid FROM Video";
$all_vids = $conn->query($sql);
$vids_arr = toArr($all_vids);
$num_vids = count($vids_arr);

if( $all_vids->num_rows == 0){
	echo "ERROR: Missing videos";
}

$sql = "SELECT videoid FROM Rating WHERE userid =" .$_SESSION["user_id"];
$rated_vids = $conn->query($sql);
$rated_arr = toArr($rated_vids);

$valid_vids = array();

for($x=0; $x<$num_vids; $x++){
	if(!in_array($vids_arr[$x], $rated_arr)){
		array_push($valid_vids, $vids_arr[$x]);
	}
}
$rand = 0;


if(count($valid_vids) == 0){
	$rand = rand(0, $num_vids-1);
	$sql = "SELECT URL FROM Video WHERE videoid=" .$vids_arr[$rand];
}

else{
	$rand = rand(0, count($valid_vids)-1);
	$sql = "SELECT URL FROM Video WHERE videoid=" .$valid_vids[$rand];
}

$_SESSION["videoid"] = $valid_vids[$rand];
$vid = $conn->query($sql);
$res = $vid->fetch_assoc();
echo($res["URL"]);

?>

