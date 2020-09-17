<textarea class="form-control mb-15" id="email_content" rows="12" placeholder="Paste source here.."></textarea>

<script type="text/javascript">
    function edit_email(id) // click email
    {
         // get email name, subject, and content
        <?php            
            $select_email = mysqli_query($conn, "SELECT * FROM email_format ORDER BY email_name ASC");
            while($fetch_email = mysqli_fetch_array($select_email))
            { ?>
                email_id_exist = "<?php echo $fetch_email['email_id'];?>";
                if(id == email_id_exist)
                {
                    //document.getElementById("email_content").value = "<?php echo $fetch_email['email_id'];?>";
                    document.getElementById("email_name").value = "<?php echo $fetch_email['email_name'];?>";
                    document.getElementById("email_subject").value = "<?php echo $fetch_email['email_subject'];?>";
                    //document.getElementById("span_id").innerHTML = "Email ID:";
                    //document.getElementById("email_id").innerHTML = "<?php echo $fetch_email['email_id'];?>";
                    //document.getElementById("email_subject").focus();

                    email_name = document.getElementById("email_name").value;
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: false,
                        data:{
                            email_name:email_name,
                            get_email_content: 1,
                        },
                            success: function(data){                    
                                document.getElementById("email_content").value = data;

                                //test_email = document.getElementById("test_email").value;
                                email_subject = document.getElementById("email_subject").value;
                                email_content = document.getElementById("email_content").value;

                                if(test_email == "" || email_subject == "" || email_content== "")
                                {
                                    alert('Please input subject, message & email.');
                                }
                                else
                                {   
                                    $.ajax({
                                        url: 'ajax.php',
                                        type: 'POST', 
                                        async: false,
                                        data:{
                                            test_email:test_email,
                                            email_subject:email_subject,
                                            email_content:email_content,
                                            test_send_email: 1,
                                        },
                                            success: function(data){    
                                                alert(data);
                                            }
                                    }); 
                                }
                            }
                    });
                }
            <?php
            }
        ?> 
    }


</script>

<?php
    // ----------------------- GET EMAIL CONTENT -----------------------
    if(isset($_POST['get_email_content']))
    { 
        $email_name = $_POST['email_name'];
        $file_loc = "email_content/".$email_name.".txt";

        $myfile = fopen($file_loc, "r") or die("Unable to open file!");
        echo fread($myfile,filesize($file_loc));
        fclose($myfile);
    }
    // ----------------------- END GET EMAIL CONTENT -----------------------
    // ----------------------- SEND EMAIL -----------------------
    if(isset($_POST['test_send_email']))
    { 
        $to = $_POST['test_email'];
        $subject = $_POST['email_subject'];
        $email_content = $_POST['email_content'];   

        // Message can be change base on template selected
        $message = '
            <div style="padding: 20px 0px 0px 0px; background-color: #00465a;" class="shadow">
                <img src="http://ipasspmt.site/assets/media/photos/IPASS-Logo-05.png" style="height: 120px; padding: 0px 0px 30px 0px; display: block; margin-left: auto;
              margin-right: auto;">
                <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                    <tr>
                        <td style="background-color: #fff; border-top: 20px solid #006786; border-bottom: 20px solid #006786;">
                            '.$email_content.'
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

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <ipasspmt.site>' . "\r\n";
        $headers .= 'Cc: ipasspmt.site' . "\r\n";

        $send = mail($to,$subject,$message,$headers);
        if($send)
        {
            echo "Email sent successfully.";
        }
        else
        {
            echo "Email not sent.";
        }
    }
    // ----------------------- END SEND EMAIL -----------------------
?>


EOD

IPASS System        
    1. Fixed table history - Done
    2. Fixed auto refresh table history when sending email - Done
    3. Create a function in getting email content - Done
    4. Show the content in the table with a template - Done


    <?php 

    $message = '
            <div style="padding: 20px 0px 0px 0px; background-color: #00465a;" class="shadow">
                <img src="http://ipasspmt.site/assets/media/photos/IPASS-Logo-05.png" style="height: 120px; padding: 0px 0px 30px 0px; display: block; margin-left: auto;
              margin-right: auto;">
                <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                    <tr>
                        <td style="background-color: #fff; border-top: 20px solid #006786; border-bottom: 20px solid #006786;">
                            '.$email_content.'
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

        echo '
                    tr>
                        <td class="d-none d-sm-table-cell">'.$count++.'</td>
                        <td>'.$rows["email_send_date"].'</td>
                        <td class="d-none d-sm-table-cell">'.$rows["fname"].' '.$rows["mname"].' '.$rows["lname"].'</td>
                        <td>'.$rows["email_name"].'</td>
                        <td class="d-none d-sm-table-cell">'.$rows["email_subject"].'</td>
                        <td class="d-none d-sm-table-cell">'.$rows["email_send_to"].'</td>
                        <td class="d-none d-sm-table-cell">
                        <div style="padding: 20px 0px 0px 0px; background-color: #00465a;" class="shadow">
                            <img src="http://ipasspmt.site/assets/media/photos/IPASS-Logo-05.png" style="height: 120px; padding: 0px 0px 30px 0px; display: block; margin-left: auto;
                          margin-right: auto;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                                <tr>
                                    <td style="background-color: #fff; border-top: 20px solid #006786; border-bottom: 20px solid #006786;">
                                        '.$content.'
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
                        </td>
                    </tr>
        ';

            //filter by week
            else if($filterby == "This Week")
                {
                    $dt = new DateTime();
                    $dates = []; 
                    for ($d = 1; $d <= 7; $d++) {
                        $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                        $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                    }
                    $from = current($dates); // monday
                    $to = end($dates); // sunday
                    $results = mysqli_query($conn, "SELECT * FROM task INNER JOIN contact ON task.task_contact = contact.contact_id INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id INNER JOIN finance_phase ON finance_transaction.val_phase_id = finance_phase.phase_id WHERE finance_transaction.val_date BETWEEN '$from' AND '$to' ORDER BY finance_transaction.val_date DESC");
                }




     ?>



