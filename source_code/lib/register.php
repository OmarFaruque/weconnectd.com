<?php

    function register($username, $email, $hashedpassword, $account_type, $signup_type='', $conn) {
		$otp = sprintf("%06d", mt_rand(1, 999999));
        $otp_token = $otp.$email;
        $hash_otp = password_hash("$otp_token", PASSWORD_DEFAULT); 
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, account_type, activation_key, signup_type) VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssss", $username, $email, $hashedpassword, $account_type, $hash_otp, $signup_type);
        $result = $stmt->execute();
		
		// email sent
		if($result){
	        $to = $email;
			$subject = 'Account Verification - WeConnectd';
            $from = 'contact@weconnectd.com';
	
            $body = '
            <div class="body">
                <div class="header" style="width: 100%;
                                        height: 80px;
                                        display: table;
                                        position: relative;
                                        font-size: 14px;
                                        background:#000000;
                                        display:flex;">
                    <a href="http://alfrik.com/" style="width: 40%;">
                        <img style="height:50px; margin-top:15px; margin-left: 20px;" src="https://weconnectd.com/static/spacemy.png" class="logo" alt="WeConnectd">
                    </a>
                </div>
                <div style="width:100%; 
                                            text-align: center; 
                                            min-height: 200px;
                                            background: #f6f6f6;
                                            padding-top: 30px;
                                            font-size: 20px;">
                    Please Verify Your Account:<br>
                    <a href="https://weconnectd.com/account_verify.php?username='.$username.'&key='.$hash_otp.'">Click Here</a><br>
                    to verify your account.<br>
                </div>
            </div>

            ';

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <contact@weconnectd.com>' . "\r\n";
            $headers .= 'Cc: contact@weconnectd.com' . "\r\n";

            $mailsent = mail($to,$subject,$body,$headers);
            $stmt->close();
            return true;
        }
		
		return false;
    }

?>