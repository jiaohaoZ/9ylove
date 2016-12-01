<?php 
/**   
 * * This file is part of CiBase.
 */
class Mailer { 
    public $From;      
    public $FromName;     
    public $Address;      
    public $AddresName;    
    public $Subject;     
    public $Body;      
    public $AltBody;      
    public $isHtml=FALSE;  

    public function send(){          
	    require("PHPMailer/class.phpmailer.php");        
	    require("PHPMailer/class.smtp.php");          
	    date_default_timezone_set('Asia/Shanghai');//设定时区东八区       
	    $mail = new PHPMailer(); //建立邮件发送类          
	    $mail->IsSMTP(); // 使用SMTP方式发送         
	    $mail->CharSet ="UTF-8";//设置编码，否则发送中文乱码
	    $mail->Mailer  = "smtp";          
	    $mail->Host = "smtp.qq.com"; // 您的企业邮箱域名          
	    $mail->SMTPAuth = true; // 启用SMTP验证功能          
	    $mail->Username = "690805319@qq.com"; // 邮箱用户名(请填写完整的email地址)          
	    $mail->Password = 'gbjoikpyuricbfej'; // 邮箱密码          
	    $mail->From = $this->From; //邮件发送者email地址          
	    $mail->FromName = $this->FromName;         
	    $mail->AddAddress($this->Address,  $this->AddresName);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人 email","收件人姓名")          
	    //$mail->AddReplyTo("***@qq.com.", "name");//抄送给谁          
	    //$mail->AddAttachment("/path/to/file.tar.gz"); // 添加附件          
	    // $mail->IsHTML(true); // set email format to HTML //是否使用HTML格式          
	    $mail->IsHTML($this->isHtml);          
	    $mail->Subject = $this->Subject; //邮件标题 
	    $mail->Body =$this->Body; //邮件内容         
	    $mail->AltBody = $this->AltBody; //附加信息，可以省略          
	    if(!$mail->Send()){              
	    	return  array('statu'=>false,'msg'=>$mail->ErrorInfo);         
	    }else{              
	    	return array('statu'=>true);         
	    }     
	} 
}