<?php 
	session_start();
    include_once './conn.php';
    use PHPMailer\PHPMailer\PHPMailer;
    require_once './team/phpmailer/Exception.php';
    require_once './team/phpmailer/PHPMailer.php';
    require_once './team/phpmailer/SMTP.php';
    $mail = new PHPMailer(true);

	if (isset($_POST['forgot_password'])) {
        
        $email = $_POST['email'];

        $query = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        $data = mysqli_fetch_array($query);
        $user_id = $data['user_id'];
        $contact_fname = $data['fname'];
        $contact_email = $data['email'];
        $username = $data['username'];
        // $contact_password = $data['password'];

        // echo $contact_password;
        $rand = rand();
        $password = 'Ipass'.$rand.'';
        $md5pass = md5($password);
        // echo $password;
        $update = mysqli_query($conn, "UPDATE user SET password = '$md5pass' WHERE user_id = '$user_id'");

        // echo mysqli_num_rows($query);
        if (mysqli_num_rows($query) == 1) {

            $message = '
            <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
                <img src="https://ipasspmt.com/assets/media/photos/email_header.png" style="width: 100%;">
                <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                    <tr>
                        <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                            <p style="margin-top: -5px;">Hi '.$contact_fname.',</p>
                            <label>Please keep this email for IPASS Login. Thank you!</label><br>
                            <label>Email Address: '.$contact_email.'</label><br>
                            <label>User Name: '.$username.'</label><br>
                            <label>Password: '.$password.'</label>
                        </td>
                    </tr>
                </table>
                <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #189AA7;">
                    PROCESSING MADE EASY BY IPASS<br>
                    Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                    Ponciano Street, Davao City, Philippines 8000<br><br>
                    <a href="https://ipassprocessing.com/" style="color: white;">https://ipassprocessing.com/</a>
                </div>
            </div>
            ';
            
            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = "dave@infinityhub.com"; // Gmail address which you want to use as SMTP server
                $mail->Password = "david_flores"; // Gmail address Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = '587';

                //$mail->setFrom('test_email@ipasspmt.com'); // Gmail address which you used as SMTP server
                $mail->setFrom("dave@infinityhub.com");
                $mail->addAddress("$contact_email"); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

                $mail->isHTML(true);
                $mail->Subject = "IPASS | Forgot Password";
                $mail->Body = "$message";

                $mail->send();
                echo "success";
              } catch (Exception $e){
                echo "failed";
              }
            }
        mysqli_close($conn);
    }

 ?>