<?php
ini_set( 'display_errors', 1 );
require 'vendor/autoload.php'; // include Composer's autoloader

// エラーを例外に変換する
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // このエラーコードが error_reporting に含まれていない場合
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

// HTMLエスケープ関数
function e($html) {
    return htmlspecialchars($html, ENT_QUOTES);
}

/*
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ESP32 -> PHP -> MongoDB TEST</title>
</head>
<body>
    <h1>ESP32 -> PHP -> MongoDB TEST</h1>
*/

ini_set( 'display_errors', 1 );
//雛形
//$client = new MongoDB\Client("mongodb://sirius:sgt945518@localhost:27017");
//$collection = $client->esp32->powerdata;

switch($_SERVER['REQUEST_METHOD']){
	case 'GET':


		break;
	
	case 'POST':
		$in = json_decode(stripslashes(file_get_contents('php://input')),true);	
		$client = new MongoDB\Client("mongodb://localhost:27017");
		$collection_name = $in["sensor"];
		$collection = $client->aqi_data->$collection_name;
		$date = date('Y/m/d H:m:s');
		$result = $collection -> insertOne([
			"date" => $date,
			"text" => $in["text"],
			"number" => $in["number"],
			"location" => $in["location"]
		]);
		
		// タイムラグ用
		//$collection = $client -> esp32 -> time_lag;
		//$result = $collection -> insertOne([
		//	"timelag" => $in["timelag"]
		//]);
		
		//$collection -> insert($obj);

		/*		
		$result = $collection->find();
		foreach ($result as $entry) {	
			echo $entry['_id'], ': ';
		}
		 */
				
		echo json_encode("complete");

		break;

}
?>
