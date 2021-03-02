<?php
    //$to = "nicodamejaucila@gmail.com"; // for trial
    $to = $email; // real
    $subject = "IPASS Processing";

    if($emailfor == "New contact")
    {
        $message = '
        <div style="padding: 20px 0px 0px 0px; background-color: #5bc5cf;">
            <img src="http://ipasspmt.site/assets/media/photos/IPASS_HEAD.png" style="height: 100px; padding: 0px 0px 30px 0px; display: block; margin-left: auto;
          margin-right: auto;">
            <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                <tr>
                    <td style="background-color: #fff; border-top: 20px solid #006786; border-bottom: 20px solid #006786;">
                        <p><strong style="font-size: 24px;">Hi <span style="color: #ff7d02;">'.$fname.'</span>,</strong><br><br>
                        Welcome!!!<br><br>
                        Thank you for choosing us to be your trusted partner in processing your '.$space_name.' application!<br>
                        You are now one step ahead in achieving your dreams!<br>
                        We want to make the process visible to you. So we are giving your login details to our exclusive members portal.<br><br>
                        Portal: <strong><a href="http://ipasspmt.site/client/sign_in.php">ipasspmt.site</a></strong><br>
                        Username: <strong>'.$email.'</strong><br>
                        Password: <strong>'.$random.'</strong><br><br>
                        Feel free to explore the portal as we process these exams for you.<br><br>
                        <a href="https://ipassprocessing.com/accessing-the-ipass-portal/">Here'.'s a walkthrough</a> which will serve as your guide in knowing more about the portal.<br>
                        If you have any questions, please don'.'t hesitate to contact the following:<br><br>
                        Mobile: +63 917 200 8440<br>
                        Phone: (082) 2254-272<br>
                        Email: ask@ipassprocessing.com<br><br>
                        Assisting you in your success,<br>
                        IPASS Processing Team<br>
                    </td>
                </tr>
            </table>
            <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #00465a;">
                PROCESSING MADE EASY BY IPASS<br>
                Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                Ponciano Street, Davao City, Philippines 8000<br><br>
                <a href="https://ipassprocessing.com/" style="color: #2196f3;">https://ipassprocessing.com/</a>
            </div>
        </div>
        ';
    }
    if($emailfor == "New contact assign")
    {
    }

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <ipasspmt.site>' . "\r\n";
    $headers .= 'Cc: ipasspmt.site' . "\r\n";

    mail($to,$subject,$message,$headers);
?>