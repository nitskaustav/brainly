<?php
function getConnection() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="Host@2017";
	$dbname="perfectshade";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

function getAll($table) {
	$sql = "select * FROM ".$table." ORDER BY id desc";
	
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		return '{"'.$table.'": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function findById($id,$table) {
	$sql = "SELECT * FROM ".$table." WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();			
		$user = $stmt->fetchObject();  
		$db = null;
		return json_encode($user); 
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function findByIdObject($id,$table) {
	$sql = "SELECT * FROM ".$table." WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();			
		$user = $stmt->fetchObject();  
		$db = null;
		return $user; 
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
function findByIdArray($id,$table) {
    $rarray = array();
    $sql = "SELECT * FROM ".$table." WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);  
        $stmt->bindParam("id", $id);
        $stmt->execute();			
        $rarray = $stmt->fetch(PDO::FETCH_ASSOC);
        $db = null;
        return $rarray; 
    } catch(PDOException $e) {
        return $rarray; 
    }
}

function findByConditionArray($conditions,$table) {        
        $rarray = array();
	$sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                $sql_cond = '';
                foreach ($conditions as $key=>$condition)
                {
                    
                    if(!empty($sql_cond)){
                        $sql_cond .= "and $key=:$key ";
                    }else{
                        $sql_cond = "$key=:$key ";
                    }
                    $$key = $condition;                    
                }
                $sql .= $sql_cond;
            }
            
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $s = json_decode(json_encode($conditions));
            if(!empty($s))
            {
                foreach ($s as $key => $t) 
                {
                    //echo $t.$key;
                    $stmt->bindValue($key, $s->$key);
                    //$sql .= "$key=:$key ";
                }
            }
            //exit;

            $stmt->execute();			
            $rarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            return $rarray; 
	} catch(PDOException $e) {
		return $rarray; 
	}
}
function findSingleArray($conditions,$table) {        
        $rarray = array();
	$sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                $sql_cond = '';
                foreach ($conditions as $key=>$condition)
                {
                    
                    if(!empty($sql_cond)){
                        $sql_cond .= "and $key=:$key ";
                    }else{
                        $sql_cond = "$key=:$key ";
                    }
                    $$key = $condition;                    
                }
                $sql .= $sql_cond;
            }
            
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $s = json_decode(json_encode($conditions));
            if(!empty($s))
            {
                foreach ($s as $key => $t) 
                {
                    //echo $t.$key;
                    $stmt->bindValue($key, $s->$key);
                    //$sql .= "$key=:$key ";
                }
            }
            //exit;

            $stmt->execute();			
            $rarray = $stmt->fetch(PDO::FETCH_ASSOC);
            $db = null;
            return $rarray; 
	} catch(PDOException $e) {
		return $rarray; 
	}
}
function findByConditionObject($conditions,$table,$orderBY='') {        
        $rarray = array();
	$sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                $sql_cond = '';
                foreach ($conditions as $key=>$condition)
                {
                    
                    if(!empty($sql_cond)){
                        $sql_cond .= "and $key=:$key ";
                    }else{
                        $sql_cond = "$key=:$key ";
                    }
                    $$key = $condition;                    
                }
                
                $sql .= $sql_cond;
                
                if(!empty($orderBY))
                {
                  $sql.=" order by  ".$orderBY." ";  
                }
                
                
            }
            
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $s = json_decode(json_encode($conditions));
            if(!empty($s))
            {
                foreach ($s as $key => $t) 
                {
                    //echo $t.$key;
                    $stmt->bindValue($key, $s->$key);
                    //$sql .= "$key=:$key ";
                }
            }
            //exit;

            $stmt->execute();			
            $rarray = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return $rarray; 
	} catch(PDOException $e) {
		return $rarray; 
	}
}

/*
 * $sql : Sql query with conditions
 */
function updateByQuery($sql) {
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql); 
        $data = $stmt->execute();
        if($stmt->rowCount()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    catch(PDOException $e) {
        return false; 
    }
}

function saveByQuery($sql) {
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql); 
        $data = $stmt->execute();
        if(!empty($data))
        {
            return $db->lastInsertId();;
        }
        else
        {
            return false;
        }
    }
    catch(PDOException $e) {
        return false; 
    }
}
/*
 * $sql : Sql query with conditions
 * $type : all - find multiple row
 *         one - find one row
 */
function findByQuery($sql,$type='all')
{
    $rarray = array();
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();	
        if($type=='one')
            $rarray = $stmt->fetch(PDO::FETCH_ASSOC);
        else
            $rarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $rarray; 
    } catch(PDOException $e) {
	return $rarray; 
    }
}

function findByQueryObject($sql,$type='all')
{
    $rarray = array();
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();	
        if($type=='one')
            $rarray = $stmt->fetch(PDO::FETCH_ASSOC);
        else
            $rarray = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return $rarray; 
    } catch(PDOException $e) {
	return $rarray; 
    }
}

function findByCondition($conditions,$table) {
	$sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                foreach ($conditions as $key=>$condition)
                {
                    $sql .= "$key=:$key ";
                }
                
               
            }
            $db = getConnection();
            $stmt = $db->prepare($sql);  
            if(!empty($conditions))
            {
                foreach ($conditions as $key=>$condition)
                {
                    $stmt->bindParam("$key", $condition);
                    //$sql .= "$key=:$key ";
                }
            }

            $stmt->execute();			
            $user = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return json_encode($user); 
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function rowCount($uniqueData,$tableName) {
        $uniqueData = json_decode($uniqueData);
        $queryField='';
        $aliseField='';
        $db = getConnection();
	$sql = "SELECT * FROM ".$tableName." WHERE ";
	$i=0;
        foreach($uniqueData as $key=>$value){
                if($i ==0){
                        $sql .= $key."=:".$key;
                }else{
                        $sql .= ' or '.$key."=:".$key;
                }
                $i++;                
        }
	$stmt = $db->prepare($sql);
	foreach($uniqueData as $key=>$value){
	        $stmt->bindParam($key, $value);
	}		
	$stmt->execute();	
	$userCount = $stmt->rowCount();
	$stmt=null;
	$db=null;
	
	return $userCount;
}
function rowCountAnd($uniqueData,$tableName) {
        $uniqueData = json_decode($uniqueData);
        $queryField='';
        $aliseField='';
        $db = getConnection();
	$sql = "SELECT * FROM ".$tableName." WHERE ";
	$i=0;
        foreach($uniqueData as $key=>$value){
                if($i ==0){
                        $sql .= $key."=:".$key;
                }else{
                        $sql .= ' and '.$key."=:".$key;
                }
                $i++;                
        }
	$stmt = $db->prepare($sql);
	foreach($uniqueData as $key=>$value){
	        $stmt->bindParam($key, $value);
	}		
	$stmt->execute();	
	$userCount = $stmt->rowCount();
	$stmt=null;
	$db=null;
	
	return $userCount;
}
function rowCountByCondition($conditions,$table) {
        $sql = "SELECT * FROM ".$table;
	try {
            if(!empty($conditions)) 
            {
                $sql .= " WHERE ";
                foreach ($conditions as $key=>$condition)
                {
                    $sql .= "LOWER($key)=:$key ";
                }
            }
            $db = getConnection();
            $stmt = $db->prepare($sql);  
            if(!empty($conditions))
            {
                foreach ($conditions as $key=>$condition)
                {
                    $stmt->bindParam("$key", strtolower($condition));
                    //$sql .= "$key=:$key ";
                }
            }

            $stmt->execute();			
            $userCount = $stmt->rowCount();
            $db = null;
            return $userCount; 
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function add($data,$table) {
        $data = json_decode($data);       
        
        $queryField='';
        $aliseField='';
        $rowCount = 0;
        if(!empty($data->unique_data)){
               //$rowCount = rowCount(json_encode($data->unique_data),$table);               
        }
        if(!empty($data->save_data)){
	    
                foreach($data->save_data as $key=>$value){
                        if(empty($queryField)){
                                $queryField = $key;
                        }else{
                                $queryField = $queryField.', '.$key;
                        }
                        if(empty($aliseField)){
                                $aliseField = ':'.$key;
			}
			else{
                                $aliseField = $aliseField.', :'.$key;
			}
			
                }
                /*if($rowCount == 0){
                        $sql='';*/
                         $sql = "INSERT INTO ".$table."(".$queryField.") VALUES (".$aliseField.")";
                        try {		
		                $db = getConnection();
		                $stmt = $db->prepare($sql);
		                
		                foreach($data->save_data as $key=>$value){
					 $stmt->bindParam($key, $data->save_data->$key);	                        
		                        
		                }		               
		               	
		                //$stmt = $db->prepare("INSERT INTO users(first_name, last_name, merchant_name, email, username, password, registration_date, user_type_id) values('".$user->first_name."','".$user->last_name."','".$user->merchant_name."','".$user->email."','".$user->username."','".$user->password."','2016-02-1', 2)");           
                                          
		
		                $stmt->execute();
		                $data->save_data->id = $db->lastInsertId();
		                //sendMail('nits.sandeeptewary@gmail.com',$data->save_data->email,'Welcome to mFoodGate','Hii');
		                $db = null;
                                return  $data->save_data->id;
		                //return json_encode($data->save_data); 
	                }
	                catch(PDOException $e) {
                            
                            print_r($e);exit;
		                //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		                return '{"error":{"text":'. $e->getMessage() .'}}'; 
	                }
                        
               /* }else{
                        return '{"error":{"text":"already exist"}}'; 
                }*/
        }
}
function edit($data,$table,$id) {
        $data = json_decode($data); 
        
        if(!empty($data->save_data)){
                $sql = "UPDATE ".$table." SET ";
                $updatequery = '';
                foreach($data->save_data as $key=>$value){
                        if(empty($updatequery)){
                                $updatequery = $key."=:".$key;
                        }else{
                                $updatequery .= ", ".$key."=:".$key;
                        }                        
                }
                $sql .= $updatequery." WHERE id=:id";
        
			   try {
		        $db = getConnection();
		        $stmt = $db->prepare($sql); 
		        foreach($data->save_data as $key=>$value){
		                $stmt->bindParam($key, $data->save_data->$key);
		        }			
		        $stmt->bindParam("id", $id);		
		        $stmt->execute();
		        $data->save_data->id=$id;
		        $db = null;
		        return json_encode($data->save_data); 
	        }
	        catch(PDOException $e) {
		        return '{"error":{"text":'. $e->getMessage() .'}}'; 
	        }
        }
}

function editByField($data,$table,$conditions) {
        $data = json_decode($data); 
       
        if(!empty($data->save_data)){
                $sql = "UPDATE ".$table." SET ";
                $updatequery = '';
                foreach($data->save_data as $key=>$value){
                        if(empty($updatequery)){
                                $updatequery = $key."=:".$key;
                        }else{
                                $updatequery .= ", ".$key."=:".$key;
                        }                        
                }
                $sql .= $updatequery." WHERE ";
                foreach($conditions as $key=>$condition)
                {
                    $sql .= "$key=:$key";
                }
                
                try {
		        $db = getConnection();
		        $stmt = $db->prepare($sql); 
		        foreach($data->save_data as $key=>$value){
		                $stmt->bindParam($key, $data->save_data->$key);
		        }
                        foreach($conditions as $key=>$condition)
                        {
                            $stmt->bindParam("$key", $condition);
                        }
		        		
		        $stmt->execute();
		        //$data->save_data->id=$id;
		        $db = null;
		        return json_encode($data->save_data); 
	        }
	        catch(PDOException $e) {
		        return '{"error":{"text":'. $e->getMessage() .'}}'; 
	        }
        }
}

function delete($table,$id) {
        $sql = "DELETE FROM ".$table." WHERE id=:id";
        try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
                return 1;
		
	} catch(PDOException $e) {
            return 0;	
                
        }
        
}

/*
 * deleteAll - Delete multiple fields by multiple conditions
 * $table - Tablename
 * $conditions - conditions
 */
function deleteAll($table,$conditions){
    $sql = "DELETE FROM ".$table;
    try {
            if(!empty($conditions))
            {
                $sql .= " WHERE ";
                foreach($conditions as $key=>$condition)
                {
                    $sql .= "$key=:$key ";
                }
            }
            $db = getConnection();
            $stmt = $db->prepare($sql);  
            
            if(!empty($conditions))
            {
                foreach($conditions as $key=>$condition)
                {
                    $stmt->bindParam($key, $condition);
                }
            }
            $stmt->execute();
            $db = null;
            return '{"success":{"text":"Deleted successfully"}}';
    } catch(PDOException $e) {
            return '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}


/*function getlist($table,$conditions) {
        $sql = "select * FROM ".$table." where order_id=:order_id ORDER BY id desc";
	
	try {
            
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();			
		$user = $stmt->fetchObject();  
		$db = null;
		return json_encode($user); 
	} catch(PDOException $e) {
		return '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}*/

//function array_column($arr,$field)
//{
//    $temp = array();
//    if(!empty($arr))
//    {
//       foreach($arr as $t)
//       {
//           if(!empty($t[$field]))
//            $temp[] = $t[$field];
//       }
//    }
//    
//    return $temp;
//}

function get_dpi($filename){
    $a = fopen($filename,'r');
    $string = fread($a,20);
    fclose($a);

    $data = bin2hex(substr($string,14,4));
    $x = substr($data,0,4);
    $y = substr($data,0,4);

    return array(hexdec($x),hexdec($y));
} 

function send_mail($from,$to,$subject,$message,$FromName='Westatement')
{
    $mail = new PHPMailer;
    $mail1->FromName = $FromName;
    $mail->From    = $from;
    $mail->Subject = $subject;
    $mail->Body    = stripslashes($message);
    $mail->AltBody = stripslashes($message);
    $mail->IsHTML(true);
    $mail->AddAddress($to,"westatement.com");//info@salaryleak.com
    if($mail->Send())
    {
        return 1;
    }
 else 
    {
        return 0;
    }
}

function sendMailByCurl($to,$subject,$content)
{
     $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => SITE_URL."users/emailnotification",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"to\"\r\n\r\n".$to."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"subject\"\r\n\r\n".$subject."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"message\"\r\n\r\n".$content."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
        ),
      ));

        $response = curl_exec($curl);
        if($response)
        {
            return true;
        }
        else
        {
            return false;
        }
}

function create_slug($string, $ext=''){     
	$replace = '-';         
	$string = strtolower($string);     

	//replace / and . with white space     
	$string = preg_replace("/[\/\.]/", " ", $string);     
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);     

	//remove multiple dashes or whitespaces     
	$string = preg_replace("/[\s-]+/", " ", $string);     

	//convert whitespaces and underscore to $replace     
	$string = preg_replace("/[\s_]/", $replace, $string);     

	//limit the slug size     
	$string = substr($string, 0, 200);     

	//slug is generated     
	return ($ext) ? $string.$ext : $string; 
}


function checkCampaignGoal($campaign_id)
{
    $campaign=findByIdArray($campaign_id, "campaigns"); 
    $orders = findByQuery('SELECT * FROM orders where campaign_id='.$campaign_id);
    $total_profit = 0;
    if($campaign['campaign_type'] == 1)
    {
        foreach($orders as $order)
        {
            if($order['profit']<0)
            {
                $total_profit += $order['profit_digital'];
            }
            else {
                $total_profit += $order['profit'];
            }
        } 
        if($campaign['show_price'] <= $total_profit)
        {
            $user_details = findByIdArray($campaign['user_id'], "users"); 
            if(!empty(is_reach_mygoal))
            {
                $email_tpl=findByIdArray(20,"email_templates");
                $subject = str_replace('[USER]',$user_details['first_name'],$email_tpl['subject']);
                $campaign_link = '<a href="'.WEBURL.$campaign['slug'].'">'.$campaign['name'].'</a>';
                $content = str_replace(array('[USER]','[CAMPAIGNNAME]','[GOALAMOUNT]','[ENDDATE]'),array($user_details['first_name'],$campaign_link,'$'.number_format($campaign['show_price']),date('F d, Y',strtotime($campaign['campaign_end'])).' at '.date('H:i:s',strtotime($campaign['campaign_end']))),$email_tpl['content']);
                sendMailByCurl($user_details['email'],$subject,$content);
            }
        }
    }
}

//Contact@westatemet.com

?>
