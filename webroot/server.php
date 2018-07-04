<?php
//echo "hello";exit;
ini_set("log_errors", 1);
ini_set("error_log", "log/php-error.log");
error_log( "Hello, errors!" );

ini_set('max_execution_time', 0);
$host = '111.93.169.90'; //host 
$port = '25778'; //port
$null = NULL; //null var

require 'crud.php';

//$dblink = mysql_connect('localhost', 'root', 'Host@123456');
//mysql_select_db('listing_db');

//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
//socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
if ( ! socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) 
{ 
    echo socket_strerror(socket_last_error($socket)); 
    exit; 
}
//bind socket to specified host
try
{
    socket_bind($socket, 0, $port);
} catch (Exception $ex) {
    exit;
}


//listen to port
socket_listen($socket);

//create & add listning socket to the list
$clients = array($socket);

//start endless loop, so that our script doesn't stop
while (true) {
	//manage multipal connections
	$changed = $clients;
	//returns the socket resources in $changed array
	socket_select($changed, $null, $null, 0, 10);
	
	//check for new socket
	if (in_array($socket, $changed)) {
		$socket_new = socket_accept($socket); //accpet new socket
		$clients[] = $socket_new; //add socket to client array
		
		$header = socket_read($socket_new, 1024); //read data sent by the socket
		perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
		
		socket_getpeername($socket_new, $ip); //get ip address of connected socket
		$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
		send_message($response); //notify all users about new connection
		
		//make room for new socket
		$found_socket = array_search($socket, $changed);
                print_r($found_socket);
		unset($changed[$found_socket]);
	}
	
	//loop through all connected sockets
	foreach ($changed as $changed_socket) {	
		$fullResult = '';
		//check for any incomming data
//		while(0 != socket_recv($changed_socket, $buf, 1024, 0))
//		{
//                    if($buf != null)
//                    {
//                        $fullResult .= $buf;
//                        
//                    }
//                        
//                    
//                }
                
                $data = '';
                $done = false;
//                while(!$done) {
//                    socket_clear_error($changed_socket);
//                    $bytes = @socket_recv($changed_socket, $r_data, 4000, MSG_DONTWAIT);
//
//                    $lastError = socket_last_error($changed_socket);
//
//                    if ($lastError != 11 && $lastError > 0) {
//                        // something went wrong! do something
//                        $done = true;
//                    }
//                    else if ($bytes === false) {
//                        // something went wrong also! do something else
//                        $done = true;
//                    }
//                    else if (intval($bytes) > 0) {
//                        $data .= $r_data;
//                    }
//                    else {
//                        usleep(2000); // prevent "CPU burn"
//                    }
//                }
                $query = '';
                while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
			$received_text = unmask($buf); //unmask data
			$tst_msg = json_decode($received_text); 
                        print_r($tst_msg);
                        //json decode 
                 //$query1 = "insert into chats set message='".$data."'";
                            //mysql_query($query1);
			//$received_text = unmask($data); //unmask data
                       //$query1 = "insert into chats set message='".$received_text."'";
                            //mysql_query($query1);
			//$tst_msg = json_decode($received_text); //json decode 
                        
                        if(!empty($tst_msg->connection_status))
                        {                            
                            $user_id = $tst_msg->user_id;
                            $user_to = $tst_msg->user_to;
                            echo "new user connected";
                            if($tst_msg->is_connected)
                            {
                                //$q = "SELECT * from chat_users where user_id='".$user_id."',post_id='".$post_id."'";
                                //mail('nits.bikash@gmail.com','Query',$q);
                                //$exist_query = mysql_query("SELECT * from chat_users where user_id='".$user_id."' and post_id='".$post_id."'");
                                //$exist_count = mysql_num_rows($exist_query);
//                                $exist_count = findByQuery("SELECT * from chat_users where user_id='".$user_id."' and user_to='".$user_to."'");
//                                if(empty($exist_count))
//                                {
//                                   $query = "INSERT into chat_users set user_id='".$user_id."',user_to='".$user_to."',last_seen='".date('Y-m-d H:i:s')."'"; 
//                                   //mysql_query($query);
//                                    updateByQuery($query);
//                                }
                            }
                            else
                            {
//                                $query = "DELETE from chat_users where user_id='".$user_id."',post_id='".$post_id."'"; 
//                                //mysql_query($query);
//                                updateByQuery($query);
                            }
                        }
                        else if(!empty($tst_msg->read_msg))
                        {
                            $query = "UPDATE chats set is_read=1 where receiver_id=".$tst_msg->user_id." and offer_id=".$tst_msg->offer_id;
                            //mysql_query($query);
                            updateByQuery($query);
                        }
                        else if(!empty($tst_msg->typing)){
                            $user_name = $tst_msg->name; //sender name
                            $user_color = $tst_msg->color; //color
                            $user_receiver_name = $tst_msg->receive_name; //color
                            $user_sender_id = $tst_msg->sender_id; //color
                            $user_receiver_id = $tst_msg->receiver_id;
                            $r_name = $tst_msg->r_name;
                            $r_image = $tst_msg->r_image;
                            $s_name = $tst_msg->s_name;
                            $s_image = $tst_msg->s_image;
                            $offer_id = $tst_msg->offer_id;
                            
                             $response_text = mask(json_encode(array('type'=>'typing', 'name'=>$user_name, 'message'=>'Typing', 'color'=>$user_color, 'receive_name'=>$user_receiver_name, 'sender_id'=>$user_sender_id, 'receiver_id'=>$user_receiver_id, 'r_name'=>$r_name, 'r_image'=>$r_image, 's_name'=>$s_name, 's_image'=>$s_image,'offer_id' => $offer_id)));  


                            send_message($response_text); 
                        }
                        else if(!empty($tst_msg->stop_typing)){
                            $user_name = $tst_msg->name; //sender name
                            $user_color = $tst_msg->color; //color
                            $user_receiver_name = $tst_msg->receive_name; //color
                            $user_sender_id = $tst_msg->sender_id; //color
                            $user_receiver_id = $tst_msg->receiver_id;
                            $r_name = $tst_msg->r_name;
                            $r_image = $tst_msg->r_image;
                            $s_name = $tst_msg->s_name;
                            $s_image = $tst_msg->s_image;
                            $offer_id = $tst_msg->offer_id;
                            
                             $response_text = mask(json_encode(array('type'=>'stop_typing', 'name'=>$user_name, 'message'=>'Typing Stopped', 'color'=>$user_color, 'receive_name'=>$user_receiver_name, 'sender_id'=>$user_sender_id, 'receiver_id'=>$user_receiver_id, 'r_name'=>$r_name, 'r_image'=>$r_image, 's_name'=>$s_name, 's_image'=>$s_image,'offer_id' => $offer_id)));  


                            send_message($response_text); 
                        }
                        else if(!empty($tst_msg->attach)){
                            //move_uploaded_file($tst_msg->file['afile']['tmp_name'], 'chat_files/img.png');
                            $query1 = "insert into chats set message='".$tst_msg->file."'";
                            //mysql_query($query1);
                            updateByQuery($query1);
                            #file_put_contents('chat_files/img.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $tst_msg->file)));
                            #send_message($tst_msg);
                            $response_text = mask(json_encode(array('type'=>'text','conn' => $query1)));  


                            send_message($response_text);
                        }
                        else if(!empty($tst_msg))
                        {
                           
                            $user_name = $tst_msg->name; //sender name
                            $user_message = $tst_msg->message; //message text
                            $user_color = $tst_msg->color; //color
                            $user_receiver_name = $tst_msg->receive_name; //color
                            $user_sender_id = $tst_msg->sender_id; //color
                            $user_receiver_id = $tst_msg->receiver_id;
                            $r_name = $tst_msg->r_name;
                            $r_image = $tst_msg->r_image;
                            $s_name = $tst_msg->s_name;
                            $s_image = $tst_msg->s_image;
                            $offer_id = $tst_msg->offer_id;

                            $msg_id = 0;
                            $qr = '';
                            echo "hellooo ==============".$user_message;
                            if(!empty($user_message))
                            {
                                echo "heyy";
                                $query = "INSERT into chats set name = '".$user_name."',message = '".$user_message."',receive_name='".($user_receiver_name)."',sender_id='".$user_sender_id."',receiver_id='".$user_receiver_id."',r_name='".$r_name."',r_image='".($r_image)."',s_name='".$s_name."',s_image='".($s_image)."',offer_id='".$offer_id."'";
                                echo $query;
                                $qr = false;
//                                try
//                                {
                                    //$qr = mysql_query($query);
                                    //$msg_id = mysql_insert_id();
                                     $msg_id = saveByQuery($query);
                                    
//                                } catch (Exception $ex) {
//                                    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//                                    fwrite($myfile, $query);
//                                    fclose($myfile);
//                                }
                                
                            }
                            
                            //prepare data to be sent to client
                            $response_text = mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color, 'receive_name'=>$user_receiver_name, 'sender_id'=>$user_sender_id, 'receiver_id'=>$user_receiver_id, 'r_name'=>$r_name, 'r_image'=>$r_image, 's_name'=>$s_name, 's_image'=>$s_image,'offer_id' => $offer_id,'msg_id' => $msg_id,'conn' => $query)));  


                            send_message($response_text); //send data
                            
                             $response_text = mask(json_encode(array('type'=>'stop_typing', 'name'=>$user_name, 'message'=>'Typing Stopped', 'color'=>$user_color, 'receive_name'=>$user_receiver_name, 'sender_id'=>$user_sender_id, 'receiver_id'=>$user_receiver_id, 'r_name'=>$r_name, 'r_image'=>$r_image, 's_name'=>$s_name, 's_image'=>$s_image,'offer_id' => $offer_id)));  
                             send_message($response_text);
                        }
			break 2; //exist this loop
		
		
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		if ($buf === false) { // check disconnected client
			// remove client for $clients array
			$found_socket = array_search($changed_socket, $clients);
			socket_getpeername($changed_socket, $ip);
			unset($clients[$found_socket]);
			
			//notify all users about disconnected connection
			$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
			send_message($response);
		}
                }
	}
}
// close the listening socket
socket_close($socket);

function send_message($msg)
{
	global $clients;
	foreach($clients as $changed_socket)
	{
		@socket_write($changed_socket,$msg,strlen($msg));
	}
	return true;
}


//Unmask incoming framed message
function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

//Encode message for transfer to client.
function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = (!empty($headers['Sec-WebSocket-Key'])?$headers['Sec-WebSocket-Key']:time());
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}

