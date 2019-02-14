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
    $header[] = "Authorization: Bearer R3BJ8ARpdwTfAwKPgmq2xfmwWh5MgTnGan4tfdB8fu3MrHlqSjaMKnLiH+5+9YXX2r4arKqpB1P5fdG+DiOXtjVcz1F0CgwjhHg8Be0FNlVRus2RpdfLIL0izDjCfcPC75QhTVHOtonSmog7JVk8wQdB04t89/1O/w1cDnyilFU=";
    $ch = curl_init("https://api.line.me/v2/bot/message/push");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
    $result = curl_exec($ch);
    curl_close($ch);
?>
?>
