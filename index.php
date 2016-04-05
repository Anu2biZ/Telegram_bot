<?
set_time_limit(0);// auto
/*
author: Anu2biZ
*/

// Работа с API Telegram 
error_reporting(E_ALL);
$botToken = "193423711:AAGt-t9aBOUQDaHhS4Z0m9UTCoK53UoSBeg";
$url = "https://api.telegram.org/bot".$botToken."/getupdates";
$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = json_decode(curl_exec($ch), true);
	curl_close($ch);

$chat_id = $response["result"][0]["message"]["from"]["id"];

// Работа с API VK

// https://api.vk.com/method/users.get?user_id=66748&v=5.50 - пример запроса
$group_id = "-107693818";
$vk =  "https://api.vk.com/method/wall.get?owner_id=".$group_id."&count=1";
while( true ) {
$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, $vk);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	$responseVK = json_decode(curl_exec($ch2), true);
	curl_close($ch2);

print_r ( $responseVK);

echo "<br> <br> _____";
$last_id = $responseVK["response"][1]["id"];
$idTxt = file_get_contents("id.txt");
	if ( $last_id > $idTxt) {
		$messageToTel = $responseVK["response"][1]["text"];
		file_put_contents("id.txt", $last_id);	
		$tel = "https://api.telegram.org/bot".$botToken."/sendMessage?chat_id=".$chat_id."&text=".$messageToTel;
		
		$ch3= curl_init();
	curl_setopt($ch3, CURLOPT_URL, $tel);
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
	$response3 = json_decode(curl_exec($ch3), true);
	curl_close($ch3);
	}
	
	sleep(30);
}