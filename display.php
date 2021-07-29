<?php
ini_set('display_errors',1);
require 'vendor/autoload.php';

//エラーを例外に変換する
function exception_error_handler($senverity, $message, $line){
        if(!(error_reporting() & $severity)) {
                return;
        }
        throw new ErrorException($message, 0, $severity,$file,$line);
}
set_error_handler("exception_error_handler");

function e($html){
        return htmlspecialchars($html,ENT_QUOTES);
}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
        <meta charset = "UTF-8">
        <title>HTTP-POST data</title>
</head>
<body>
        <h1> AQI_DATA LIST</h1>


<?php
ini_set('display_errors',1);
$client = new MongoDB\Client("mongodb://localhost:27017");
if(isset($_GET['sensor'])){
	$sensor_name = $_GET['sensor'];

	//$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->aqi_data->$sensor_name;
	$result = $collection -> find();
	foreach ($result as $entry){	
		echo $entry['date'], ',   location : ', $entry['location']  ,',    text：',$entry['text'], ',    number：',$entry['number'],'<br />';
	}
	echo '<br /><a href="https://ij-collab.tak-cslab.org/recieve/post/display.php">top page</a><br />';
}else{
	#echo 'Please enter the sensor name in the query parameter', '<br />';
	//$col = $client -> find();
	//foreach($col->$entry){
	//	echo $entry, '<br />';
	//}
	//$db = $client->selectDB("aqi_data");
	$m = new MongoDB\Client("mongodb://localhost:27017");
	$db = $m->aqi_data;;
	$collections = $db->listCollections();

	foreach ($collections as $collectionName) {
		#echo "Found sensor: ", $collectionName['name'], "<br />";
		echo '<a href="https://ij-collab.tak-cslab.org/recieve/post/display.php?sensor=',$collectionName['name'],'">sensor name : ',$collectionName['name'],'</a><br />';
	}
}

?>

</body>
</html>
