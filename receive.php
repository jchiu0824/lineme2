<?php 
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
    
    $myfile = fopen("log.txt","w+") or die("Unable to open file!");
    //fwrite($myfile, "\xEF\xBB\xBF".$json_str);

    $sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
    $sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
    $sender_replyToken = $json_obj->events[0]->replyToken; //��硋�𡑒�𦠜�舐�replyToken
  
    if($sender_txt == "a12") {
	      $response = array (
		        "replyToken" => $sender_replyToken,
		        "messages" => array (
		        array (
			          "type" => "sticker",
			          "packageId" => "1",
			          "stickerId" => "2573"
		        )
		    )
	    );
    }
  
    fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
    $header[] = "Content-Type: application/json";
    $header[] = "Authorization: Bearer UImaIxSHE116XDn6awZlOFu739Juy59DTkLnUdNXTkXTDXo8mtZAW9Ga36eEZtpw7cQdjFMogO6kXESc30vKyNz4/dxoIYi99ScMtVYRgooqzYoub+jcwcwRRRpr7rMh1Hmu9+2Ln7HFINmXJNWRqAdB04t89/1O/w1cDnyilFU=";
    $ch = curl_init("https://api.line.me/v2/bot/message/push");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
    $result = curl_exec($ch);
    curl_close($ch);
?>
?>
