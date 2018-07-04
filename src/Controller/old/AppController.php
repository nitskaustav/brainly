<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Mailer\Email;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        if (isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
            $this->viewBuilder()->layout('admin');
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'username',
                            'password' => 'password',
                        ],
                        'userModel' => 'Admins'
                    ]
                ],
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'home'
                ],
                'logoutRedirect' => [
                    'controller' => 'Users',
                    'action' => 'index',
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'index'
                ],
                'storage' => [
                    'className' => 'Session',
                    'key' => 'Auth.Admin'
                ]
            ]);
            $this->Auth->allow(['index']);
            //pr($this->Auth);
        } else {
            //echo "hello";
            
            $controller=$this->request->params["controller"];
            $action=$this->request->params["action"];
           if($controller=="Users" and ($action=='signin' or $action=="signup" or $action=="forgotpassword" or $action=='index'or 
                   $action=="setpassword" or $action=="activeaccount"))
           {
                $this->viewBuilder()->layout('default');
           }
           elseif ($controller=="Pages") {
               
                $this->viewBuilder()->layout('default');
           
       }
       else
       {
           $this->viewBuilder()->layout('default');
           
       }
            
            //$this->layout = 'default';
            $this->loadComponent('Auth', [
                //'authError' => $this->Flash->error('You Are Not Autheticate For This Section. Please Sign in.'),
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'email',
                            'password' => 'password'
                        ],
                        'userModel' => 'Users'
                    ]
                ],
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'dashboard'
                ],
                'logoutRedirect' => [
                    'controller' => 'Pages',
                    'action' => 'home',
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'index'
                ],
                'storage' => [
                    'className' => 'Session',
                    'key' => 'Auth.User'
                ]
            ]);
            $this->Auth->allow(['signup', 'signin']); //['index', 'signup'] 
        }
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }
    
    public function beforeRender(Event $event) {
         header("Access-Control-Allow-Origin: *");
        if (isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
         
            if ($this->request->session()->check('Auth.Admin')) {
                $this->loadModel('Admins');
                $admin_id = $this->request->session()->read('Auth.Admin.id');
                $admin_details = $this->Admins->find()->where(['Admins.id' => $admin_id])->first();
                if(!empty($admin_details))
                {
                    $admin_permissions = explode(',',$admin_details->permissions);   
                    $this->set(compact('admin_permissions'));
                }
            }
           
        }
        
        else
        {
            $this->loadModel("Users");
            $user_id = $this->request->session()->read('Auth.User.id');

            if(!empty($user_id))
            {
               
                $user_details = $this->Users->find()->where(['Users.id' => $user_id])->first();
            }
            else{
                $user_details=array();
            }

     }
        $this->loadModel('Sliders');
        $slider = $this->Sliders->find('all')->where(['is_active' => 1])->toArray();
        $SiteSettings = $this->site_setting();
        //pr($slider);
        $this->set(compact('user_details','slider','appCurController','SiteSettings', 'appCurActiion','appSlider','totReview','appReviews', 'appReviewsDt','revCount','appNews'));
        
        
        
    }

    public function category_list() {
        $this->loadModel('Categories');
        $data = $this->Categories->find('all')->hydrate(false)->where(['is_active' => 1])->order(['id' => 'ASC'])->limit(6);
        return $data->toArray();
        //$this->set(compact('main_site_setting'));
    }

    public function treatment_slider() {
        $this->loadModel('Treatments');
        $this->loadModel('Categories');
        $data = $this->Treatments->find('all') 
                ->hydrate(false)
                ->select(['Treatments.id', 'Treatments.name', 'Treatments.slug', 'Treatments.image'])
                ->where(['Treatments.is_active' => 1])
                ->order(['Treatments.name' => 'ASC'])
                ->limit(20);
        return $data->toArray();
    }    
    
    
    
    public function treatment_list() {
        $this->loadModel('Treatments');
        $this->loadModel('Categories');

        /*
          $data = $this->Treatments->find('all')
          ->hydrate(false)
          ->select(['Treatments.id', 'Treatments.name', 'Treatments.slug'])
          ->where(['Treatments.is_active' => 1])
          ->contain(['Categories', 'Medicines','Medicines.Pils'])
          ->limit(10);
         */

        $data = $this->Treatments->find('all')
                ->hydrate(false)
                ->select(['Treatments.id', 'Treatments.name', 'Treatments.slug'])
                ->where(['Treatments.is_active' => 1])
                ->order(['Treatments.name' => 'ASC'])
                ->contain(['Categories' => function($q) {
                        return $q->select(['Categories.id', 'Categories.name', 'Categories.slug']);
                    }])
                        ->contain(['Medicines' => function($q) {
                                return $q->select(['Medicines.treatment_id', 'Medicines.id', 'Medicines.title', 'Medicines.slug'])->where(['Medicines.is_active' => '1']);
                            }])
                //->contain(['Pils' => function($q) { return $q->select(['Medicines.Pils.mid','Pils.id','Pils.title','Pils.slug']); }])
                ->limit(10000);

        return $data->toArray();
        //$this->set(compact('main_site_setting'));
    }
    
    
    public function medicine_list() {
        $this->loadModel('Medicines');
        $data = $this->Medicines->find('list')
                ->hydrate(false)
                ->where(['Medicines.is_active' => 1]);
        return $data->toArray();
    }    
    
    

    ///     @@@@@@@@@@@@@@@@@@@@@@###########################################   

    public function Send_Cake_Mail($mail_To, $mail_CC, $mail_subject, $mail_Body) {
        $email = new Email('default');
        if($email->emailFormat('html')->from(['info@ascotpharmacy.com' => 'Ascot Pharmacy'])->to($mail_To)->cc($mail_CC)->subject($mail_subject)->send($mail_Body)){
            return true;
        } else {
            return false;
        }    
    }

    public function Send_HTML_Mail($mail_To, $mail_CC, $mail_subject, $mail_Body) {
        $mail_Headers = "MIME-Version: 1.0\r\n";
        $mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        #$mail_Headers .= "To: ${mail_To}\r\n";

        if ($mail_CC != '') {
            $mail_Headers .= "Cc: ${mail_CC}\r\n";
        }

        if (mail($mail_To, $mail_subject, $mail_Body, $mail_Headers)) {
            return true;
        } else {
            return false;
        }
    }

    /* public function Send_HTML_Mail($mail_To, $mail_From, $mail_CC, $mail_subject, $mail_Body){
      $mail_Headers  = "MIME-Version: 1.0\r\n";
      $mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      #$mail_Headers .= "To: ${mail_To}\r\n";
      $mail_Headers .= "From: ${mail_From}\r\n";
      if($mail_CC != '')
      {
      $mail_Headers .= "Cc: ${mail_CC}\r\n";
      }

      if(mail($mail_To, $mail_subject, $mail_Body, $mail_Headers))
      {
      return true;
      }
      else
      {
      return false;
      }
      } */

    public function mail_attachment($mailto, $from_mail, $from_name, $subject, $message, $filename, $path) {
        $file = $path . $filename;
        $file_size = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($file);
        $header = "From: " . $from_name . " <" . $from_mail . ">\r\n";
        //$header .= "Reply-To: ".$replyto."\r\n";   
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--" . $uid . "\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $message . "\r\n\r\n";
        $header .= "--" . $uid . "\r\n";
        $header .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n";
        // use different content types here    
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
        $header .= $content . "\r\n\r\n";
        $header .= "--" . $uid . "--";
        if (mail($mailto, $subject, "", $header)) {
            return true;
        } else {
            return false;
        }
    }

    public function site_setting() {
        $this->loadModel('SiteSettings');
        $id = 1;
        //$sitesettings = $this->SiteSettings->get($id);
        $main_site_setting = $this->SiteSettings->get($id);
        return $main_site_setting->toArray();
        //$this->set(compact('main_site_setting'));
    }

    public function generate_password() {
        $length = 10;
        $chars = 'abcdefghigklmnopqrstuv0123456789!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ,./;'.time();
        return substr(str_shuffle($chars), 0, $length);
    }

    function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.strtotime("now");
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function backup_tables($host, $user, $pass, $name, $tables = '*') {
        $return = '';
        $link = mysql_connect($host, $user, $pass);
        mysql_select_db($name, $link);
        //get all of the tables
        if ($tables == '*') {
            $tables = array();
            $result = mysql_query('SHOW TABLES');
            while ($row = mysql_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        //cycle through
        foreach ($tables as $table) {
            $result = mysql_query('SELECT * FROM ' . $table);
            $num_fields = mysql_num_fields($result);

            //$return.= 'DROP TABLE '.$table.';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
            $return.= "\n\n" . $row2[1] . ";\n\n";

            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysql_fetch_row($result)) {
                    $return.= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n\n";
        }
        $filename = "db-backup-" . date('Y-m-d');
        header("Content-type: application/sql; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . $filename . ".sql");
        echo($return);
        exit();
    }

    public function un_htmlspecialchars($string) {
        static $translation;

        if (!isset($translation)) {
            $translation = array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES)) + array('&#039;' => '\'', '&nbsp;' => ' ');
        }
        return strtr($string, $translation);
    }

    //  ###  Code Taken From Cakephp 2.6 version AppController

    function app_create_slug($string, $ext = '') {
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
        return ($ext) ? $string . $ext : $string;
    }

    public function send_mail($from = null, $to = null, $subject = null, $body = null) {
        App::import('Vendor', 'PHPMailer', array('file' => 'class' . DS . 'class.phpmailer.php'));
        $mail = new PHPMailer();
        //echo $from; echo "<br>";
        //echo $to; echo "<br>";
        //echo $subject; echo "<br>";
        //echo $body; echo "<br>";
        //exit;
        /* =======================Configuration by You======================================= */
        // Emial Configuration  Which you have to configure

        $MailTo = $to;     // email id to whome you want to send
        $MailToName = '';
        $MailFrom = 'contact@officeperx.com';    //  Your email password
        $MailFromName = '';
        $YourEamilPassword = "officeperx@123";   //Your email password from which email you send.
        //$MailSubject='Message are send through smpt';  // Message title
        //$MailHtmlMessage='Name: '.$_POST['fullname']."<br>";  // Message Body
        //$MailHtmlMessage.='Phone: '.$_POST['phone']."<br>";
        //$MailHtmlMessage.='Email: '.$_POST['email']."<br>";
        //$MailHtmlMessage.='Comment: '.$_POST['comment']."<br>";

        $MailSubject = $subject;  // Message title
        $MailHtmlMessage = $body;  // Message Body
        //Message body
        //$MailAttachment[]='images/pic1.jpg';    //You can attach multiple attachement.
        //$MailAttachment[]='images/IMG_0003.JPG';   // //You can attach multiple attachement.
        /* ==========================================================================  */
        /*
          There are 3 tipes of Mails
          1.    SMTP. Please define IsMailType='SMTP' to active the SMTP mail function;
          2.    PHP's Mail().   Please define IsMailType='mail' to active the PHP mail;
          3.    Sendmail.   Please define IsMailType='sendmail' to active the Sendmail;
          4.    Qmail.    Please define IsMailType='qmail' to active the Qmail;
         */

        $IsMailType = 'SMTP';
        // If you use SMTP. Please configure the bellow settings.
        $EmailDomain = explode("@", $MailFrom);
        $SmtpHost = "mail.officeperx.com";
        $SmtpDebug = 0;                     // enables SMTP debug information (for testing)
        $SmtpAuthentication = true;                  // enable SMTP authentication
        $SmtpPort = 25;
        $SmtpUsername = $MailFrom;
        $SmtpPassword = $YourEamilPassword;
        //
        if ($IsMailType == "SMTP") {
            $mail->IsSMTP();  // telling the class to use SMTP
            $mail->SMTPDebug = $SmtpDebug;
            $mail->SMTPAuth = $SmtpAuthentication;     // enable SMTP authentication
            $mail->Port = $SmtpPort;             // set the SMTP port
            $mail->Host = $SmtpHost;           // SMTP server
            $mail->Username = $SmtpUsername; // SMTP account username
            $mail->Password = $SmtpPassword; // SMTP account password
        } elseif ($IsMailType == "mail") {
            $mail->IsMail();      // telling the class to use PHP's Mail()
        } elseif ($IsMailType == "sendmail") {
            $mail->IsSendmail();  // telling the class to use Sendmail
        } elseif ($IsMailType == "qmail") {
            $mail->IsQmail();     // telling the class to use Qmail
        }
        if ($MailFromName != '') {
            $mail->AddReplyTo($MailFrom, $MailFromName);
            $mail->From = $MailFrom;
            $mail->FromName = $MailFromName;
        } else {
            $mail->AddReplyTo($MailFrom);
            $mail->From = $MailFrom;
            $mail->FromName = $MailFrom;
        }
        if ($MailToName != '') {
            $mail->AddAddress($MailTo, $MailToName);
        } else {
            $mail->AddAddress($MailTo);
        }

        $mail->Subject = $MailSubject;
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML($MailHtmlMessage);
        /*

          if(is_array($MailAttachment))
          for($i=0;$i<count($MailAttachment);$i++)
          {
          if(file_exists($MailAttachment[$i]))
          {
          $mail->AddAttachment($MailAttachment[$i]);
          }
          }

         */
        try {
            if (!$mail->Send()) {
                $error = "Unable to send to: " . $to . "<br />";
                //throw new phpmailerAppException($error);
                return 0;
            } else {
                //echo 'Message has been sent <br /><br />';
                return 1;
            }
        } catch (phpmailerAppException $e) {
            $errorMsg[] = $e->errorMessage();
        }

        if (count($errorMsg) > 0) {
            foreach ($errorMsg as $key => $value) {
                $thisError = $key + 1;
                echo $thisError . ': ' . $value;
            }
        }
    }

    
    function PPHttpPost($methodName_, $nvpStr_, $SANDBOX_Env = 'on', $API_UserName, $API_Password, $API_Signature) {

        if ($SANDBOX_Env == 'on') {
            $mode = 'test';
        }
        if ($mode == "test") {
            /*             * *******
             * use sandbox credentials
             */
            $SANDBOX_Env = "on";
        } else {
            /*             * ******
             * use live credentials
             */
            $SANDBOX_Env = "off";
            $API_UserName = urlencode($API_UserName);
            $API_Password = urlencode($API_Password);
            $API_Signature = urlencode($API_Signature);
        }
        // Set up your API credentials, PayPal end point, and API version.



        $API_Endpoint = "https://api-3t.paypal.com/nvp";

        if ($SANDBOX_Env == 'on') {
            $API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
        } else {
            $API_Endpoint = "https://api-3t.paypal.com/nvp";
        }
        $version = urlencode('51.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }   
     
    
    function NVPToArray($NVPString) {
        $proArray = array();
        while (strlen($NVPString)) {
            // name
            $keypos = strpos($NVPString, '=');
            $keyval = substr($NVPString, 0, $keypos);
            // value
            $valuepos = strpos($NVPString, '&') ? strpos($NVPString, '&') : strlen($NVPString);
            $valval = substr($NVPString, $keypos + 1, $valuepos - $keypos - 1);
            // decoding the respose
            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString, $valuepos + 1, strlen($NVPString));
        }
        return $proArray;
    }   
    
     
}
                