<?php
    session_start();
    include_once '../conn.php';
    use PHPMailer\PHPMailer\PHPMailer;
    require_once 'phpmailer/Exception.php';
    require_once 'phpmailer/PHPMailer.php';
    require_once 'phpmailer/SMTP.php';
    $mail = new PHPMailer(true);

    if(isset($_POST['update_profile']))
    { 
        $contact_id = $_POST['contact_id'];
        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];

        $exp = explode(".", $attachment_name);
        $ext = end($exp);
        $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
        if(in_array($ext, $allowed_ext)) // check the file extension
        {
            date_default_timezone_set('Asia/Manila');
            //$todays_date = date("y-m-d H:i:sa"); //  original format
            $date = date("His"); // for unique file name

            $words = explode(' ',trim($attachment_name)); // convert name to array
            $get_name = substr($words[0], 0, 6); // get only 6 character of the name

            $image = $date.'-'.$get_name.'.'.$ext;
            $location = "client_profile/".$image; // upload location
            if($attachment_size < 10000000) // Maximum 10 MB;
            {
                $select_user = mysqli_query($conn, "SELECT * FROM contact where contact_id = '$contact_id'"); 
                $fetch_user = mysqli_fetch_array($select_user);
                $existing_frofile = $fetch_user['contact_profile'];
                if($existing_frofile != "")
                {
                    array_map('unlink', glob("client_profile/".$existing_frofile)); // remove image
                }
                move_uploaded_file($attachment_temp, $location);
                $update = mysqli_query($conn, "UPDATE contact SET contact_profile = '$image' WHERE contact_id='$contact_id'") or die(mysqli_error());
                echo "success";
            }
            else
            {
                echo "size";
            }
        }
        else
        {
            echo "format";
        }  
    }

    if(isset($_POST['fetch_finance_field_by_phase']))
    {
        $task_id = $_POST['task_id'];
        $phase_id = $_POST['phase_id'];

        echo'
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-center">Payment_name</th>
                        <th class="text-right" style="width: 20%;">CURRENCY</th>
                        <th class="text-right" style="width: 20%;">AMOUNT(USD)</th>
                    </tr>
                </thead>
                <tbody>';
                    $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order ASC");
                    $total_amount = 0;
                    while($fetch_select_field = mysqli_fetch_array($select_field))
                    {
                        $field_id = $fetch_select_field['finance_id'];

                        $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
                        $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
                        $count1 = mysqli_num_rows($select_custom_amount);

                        $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
                        $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
                        $count = mysqli_num_rows($select_finance_field_hs);
                        if($count == 1) // if field is hide in specific task
                        {
                            echo'
                            <tr style="display: none;">
                                ';
                        }
                        else
                        {
                            echo'
                            <tr>';
                                        if($count1 == 1) // if has custom amount
                                        {
                                            $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                                            $total_amount += $amount;
                                        }
                                        else
                                        {
                                            $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                                            $total_amount += $amount;
                                        }
                        }
                        echo '
                                <td class="text-center">'.$fetch_select_field['finance_name'].'</td>
                                <td class="text-right">'.$fetch_select_field['finance_currency'].'</td>
                                <td class="text-right">';
                                    if($count1 == 1) // if has custom amount
                                    {
                                        echo '
                                        '.number_format($fetch_custom_amount['custom_amount_value'],2).'
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_name'].'" id="name_field_per_task'.$fetch_select_field['finance_id'].'">
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_custom_amount['custom_amount_value'].'" id="amount_field_per_task'.$fetch_select_field['finance_id'].'">
                                        ';
                                    }
                                    else
                                    {
                                        echo '
                                        '.number_format($fetch_select_field['finance_value'],2).'
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_name'].'" id="name_field_per_task'.$fetch_select_field['finance_id'].'">
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_value'].'" id="amount_field_per_task'.$fetch_select_field['finance_id'].'">
                                        ';
                                    }
                                    echo'
                                </td>
                            </tr>';
                    }
                    $total_paid = 0;
                    $total_due = $total_amount - $total_paid;
                    echo'
                    <tr class="table-success">';
                        echo'
                        <td colspan="2" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600"><input type="hidden" value="'.$total_amount.'" id="totaldue'.$phase_id.'"> '.number_format($total_amount,2).'</td>
                    </tr>
                </tbody>
            </table>
            </div>
        ';
        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch_select_discount = mysqli_fetch_array($select_discount);
        $discount_amount = $fetch_select_discount['discount_amount'] == 0 ? '' : number_format((float)$fetch_select_discount['discount_amount'],2,".",'');

        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' AND finance_type = 'text' ORDER BY finance_order ASC");
        $total_amount = 0;
        while($fetch_select_field = mysqli_fetch_array($select_field))
        {
            $field_id = $fetch_select_field['finance_id'];
            //$total_amount += $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
            $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
            $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
            $count1 = mysqli_num_rows($select_custom_amount);

            $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
            $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
            $count = mysqli_num_rows($select_finance_field_hs);
            if($count == 0) // check if this field is visible in this task
            {
                if($count1 == 1) // if has custom amount
                {
                    $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                    $total_amount += $amount;
                }
                else
                {
                    $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                    $total_amount += $amount;
                }
            }
        }

         echo'
         <div class="table-responsive">
            <table class="js-table-sections table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Remittance</th>
                        <th class="text-left">Trans_no</th>
                        <th class="text-center">Currency</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Charge</th>
                        <th class="text-center">Initial</th>
                        <th class="text-center">Rate(UPC)</th>
                        <th class="text-right">Amount(USD)</th>
                        <th class="text-right">Amount(PAID)</th>
                    </tr>
                </thead>
                <tbody>';
                    $USD_tot = 0;
                    $PHP_tot = 0;
                    $PHP_tot_client = 0;
                    $transaction = mysqli_query($conn, "SELECT * FROM finance_transaction WHERE val_phase_id = '$phase_id' AND val_assign_to = '$task_id' ORDER BY val_date DESC");
                    while($rows = mysqli_fetch_array($transaction))
                    {
                        $USD_tot += $rows['val_usd_total'];
                        $PHP_tot += $rows['val_php_total'];
                        $PHP_tot_client += $rows['val_client_total'];

                        $val_php_total = $rows['val_php_total'];
                        $val_client_total = $rows['val_client_total'];
                        echo '
                        <tr>
                            <td>'.$rows['val_date'].'</td>
                            <td>'.$rows['val_method'].'</td>
                            <td>'.$rows['val_transaction_no'].'</td>
                            <td class="text-center">'.$rows['val_currency'].'</td>
                            <td class="text-center">'.number_format($rows['val_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_charge'].'</td>
                            <td class="text-center">'.number_format($rows['val_initial_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_usd_rate'].'|'.$rows['val_php_rate'].'|'.$rows['val_client_rate'].'</td>
                            <td class="text-right">$'.number_format($rows['val_usd_total'],2).'</td>
                            <td class="text-right">‭₱'.number_format($val_client_total,2).'</td>
                        </tr>
                        ';
                    }
                    $USD_paid = $USD_tot;
                    $PHP_paid = $PHP_tot;
                    $PHP_paid_client = $PHP_tot_client;

                    $USD_depo = 0.00;
                    $PHP_depo = 0.00;
                    $PHP_depo_client = 0.00;

                    if($discount_amount == "") // check if no discount
                    {
                        $USD_bal = $total_amount;
                        $USD_bal = $total_amount - $USD_paid;
                        if($USD_bal < 0)
                        {
                            $USD_depo = $USD_bal * (-1);
                            if($USD_tot == 0)
                            {
                                $PHP_depo = 0.00;
                            }
                            else
                            {
                                $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            }
                            $USD_bal = 0.00;
                        }
                    }
                    else // has discount
                    {
                        if($USD_paid == "0") // if USD paid == 0
                        {
                            $USD_bal = $total_amount - $discount_amount;
                        }
                        else // else USD paid != 0
                        {
                            $deduct = $discount_amount + $USD_paid;
                            $USD_bal = $total_amount - $deduct;
                        }

                        if($USD_bal < 0) // if USD Balace is negative
                        {
                            $USD_depo = $USD_bal * (-1);
                            $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            $USD_bal = 0.00;
                        }
                    }

                    // Code in getting client BALANCE & DEPOSIT
                    if($USD_tot == 0) // check if no USD paid or payment
                    {
                        $PHP_bal = 0;
                        $PHP_bal_client = 0;
                    }
                    else // else has payment
                    {
                        $PHP_bal = $USD_bal * $PHP_tot / $USD_tot;// apply ratio and proportion formula
                        $difference = $PHP_paid - $PHP_paid_client;
                        $PHP_bal_client = $difference + $PHP_bal;// apply ratio and proportion formula
                        if($PHP_depo != 0) // if IPASS php deposit is not equal to 0
                        {
                            $PHP_depo_client = $PHP_depo - $PHP_bal_client;
                            if($PHP_depo_client < 0) // if Client deposit is negative
                            {
                                $PHP_bal_client = $PHP_depo_client * (-1);
                                $PHP_depo_client = 0;
                            }
                            else
                            {
                                $PHP_bal_client = 0;
                            }
                        }

                        if($PHP_bal_client < 0)// if Client balance is negative, meaninng client rate is greater than IPASS rate
                        {
                            $PHP_depo_client = $PHP_bal_client * (-1);
                            $PHP_bal_client = 0;
                        }
                    }
                // END IPASS Total amount, Deposit, Balance
                    echo'
                </tbody>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600">$'.number_format($USD_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid_client,2).'</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Deposit:</td>
                        <td class="text-right font-w600">$'.number_format($USD_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo_client,2).'</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="7" class="font-w600 text-uppercase">';
                        if($discount_amount == "")
                        {
                            echo 'No discount';
                        }
                        else
                        {
                            echo 'Less '.$discount_amount.' discount';
                        }
                        echo '
                        </td>
                        <td class="text-right font-w600 text-uppercase">Balance:</td>
                        <td class="text-right font-w600">$'.number_format($USD_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal_client,2).'</td>
                    </tr>
            </table>
        </div>
        ';
    }

    if (isset($_POST['count_latest_noti'])) {
        
        $contact_id = $_POST['contact_id'];
        $query = mysqli_query($conn, "SELECT Count(tbl_information_noti.info_noti) AS count FROM tbl_information_noti WHERE contact_id = $contact_id AND info_noti = 0");
        $count = mysqli_fetch_array($query);
        if ($query) {
            echo $count['count'];
        }
        mysqli_close($conn);
    }

    if (isset($_POST['latest_noti'])) {
        
        $contact_id = $_POST['contact_id'];
        $query = mysqli_query($conn, "UPDATE tbl_information_noti set info_noti = 1 WHERE contact_id = $contact_id AND info_noti = 0");
        if ($query) {
            echo 'success';
            
        }
        mysqli_close($conn);
    }

    if (isset($_POST['forgot_password'])) {
        
        $email = $_POST['email'];

        $query = mysqli_query($conn, "SELECT * FROM contact WHERE contact_email = '$email'");
        $data = mysqli_fetch_array($query);
        $contact_fname = $data['contact_fname'];
        $contact_email = $data['contact_email'];
        $contact_password = $data['contact_password'];
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
                            <label>Password: '.$contact_password.'</label>
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