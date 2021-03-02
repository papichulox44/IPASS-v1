<style type="text/css">
    .menu-badge {
    font-size: 9px;
    margin-left: 4px;
    position: relative;
    color: #ffffff;
    background-color: #ef5350;
    padding: 3px 7px;
    border-radius: 50px;
    }
    .badge-bounce {
    animation: bouncing .5s cubic-bezier(0.1,0.05,0.05,1) 0s infinite alternate both;
    }

    @keyframes bouncing{
        0%{top:1px}
        100%{top:-3px}
    }
</style>


<?php
    include_once '../conn.php';

    if(isset($_POST['menu_new_message']))
    {  
        $user_id = $_POST['user_id'];
        $select_new_message = mysqli_query($conn, "SELECT * FROM message WHERE reciever_id = '$user_id' AND status = '1'");
        $count_new_message = mysqli_num_rows($select_new_message);
        if($count_new_message == 0){}   
        else
        {
            echo '<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$count_new_message.'</span>';
        }
    }

    if(isset($_POST['fetch']))
    {  
        $user_id = $_POST['user_id'];

        $array_user = array(); 
        $select_user = mysqli_query($conn, "SELECT * FROM user");
        while($row_select_user = mysqli_fetch_array($select_user))
        {                                             
            array_push($array_user,$row_select_user['user_id']);
        }        
        $count_user = mysqli_num_rows($select_user);
        
        $array_new_message = array();
        $select_new_message = mysqli_query($conn, "SELECT * FROM message WHERE reciever_id = '$user_id' AND status = '1' ORDER BY chat_date DESC");
        while($row_select_new_message = mysqli_fetch_array($select_new_message))
        {
            if (in_array($row_select_new_message['sender_id'], $array_new_message))
            {}
            else
            {
                array_push($array_new_message,$row_select_new_message['sender_id']);
            }
        }

        $result = array_diff($array_user,$array_new_message);
        $final = array_merge($array_new_message, $result);
        for($c = 0; $c < $count_user; $c++)
        {
            $ID = array_unique($final)[$c];
            $res = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$ID'");
            $result_finduser = mysqli_fetch_array($res);
            
            /*if($row['user_type'] == "Admin")
            {}  
            else
            {}*/

            if($result_finduser['user_id'] == $user_id)
            {}
            else
            {
                echo '<li>
                    <a class="contacts" id="'.$result_finduser['user_id'].'" onclick="contact_click(this.id)">';
                    if($result_finduser['profile_pic'] != "")
                    {
                        echo'<img class="img-avatar" src="../assets/media/upload/'.$result_finduser['profile_pic'].'">';
                    }
                    else
                    {
                        echo'<img class="img-avatar" src="../assets/media/photos/avatarpic.jpg" alt="">';
                    }   

                    if($result_finduser['log'] == "1"){echo '<i class="fa fa-circle text-success"></i>';}
                    else{echo '<i class="fa fa-circle text-muted"></i>';}
                        echo'<strong><span style="color: #3f9ce8;">'.$result_finduser['fname'].' '.$result_finduser['mname'].' '.$result_finduser['lname'].'</span></strong>
                        <div class="font-w400 font-size-xs text-muted"><i class="fa fa-location-arrow"></i> '.$result_finduser['team'].' ';
                    $code = $result_finduser['user_id'] .','. $user_id;
                    $select_new_message = mysqli_query($conn,"SELECT * FROM message WHERE code = '$code' AND status = '1'");
                    $count_new_message = mysqli_num_rows($select_new_message);     
                    if($count_new_message == '0')
                    {}
                    else
                    {
                        echo '<span class="menu-badge badge-bounce" id="notify">'.$count_new_message.'</span>';
                    }
                    echo'
                        </div>
                    </a>
                </li>';
            }
        }
    }
?>
<li>


<!--
$user_id = $_POST['user_id'];
        $finduser = mysqli_query($conn, "SELECT * FROM user left join message on message.id = user.user_id");
        while($result_finduser = mysqli_fetch_array($finduser))
        {
            if($result_finduser['user_id'] == $user_id)
            {}
            else
            {
                echo '<li>
                    <a class="contacts" id="'.$result_finduser['user_id'].'" onclick="contact_click(this.id)">';
                    if($result_finduser['profile_pic'] != "")
                    {
                        echo'<img class="img-avatar" src="../assets/media/upload/'.$result_finduser['profile_pic'].'">';
                    }
                    else
                    {
                        echo'<img class="img-avatar" src="../assets/media/photos/avatarpic.jpg" alt="">';
                    }   

                    if($result_finduser['log'] == "1"){echo '<i class="fa fa-circle text-success"></i>';}
                    else{echo '<i class="fa fa-circle text-muted"></i>';}
                        echo'<strong><span style="color: #3f9ce8;">'.$result_finduser['fname'].' '.$result_finduser['mname'].' '.$result_finduser['lname'].'</span></strong>
                        <div class="font-w400 font-size-xs text-muted"><i class="fa fa-location-arrow"></i> '.$result_finduser['team'].' ';
                    $code = $result_finduser['user_id'] .','. $user_id;
                    $select_new_message = mysqli_query($conn,"SELECT * FROM message WHERE code = '$code' AND status = '1'");
                    $count_new_message = mysqli_num_rows($select_new_message);     
                    if($count_new_message == '0')
                    {}
                    else
                    {
                        echo '<span class="menu-badge badge-bounce" id="notify">'.$count_new_message.'</span>';
                    }
                    echo'
                        </div>
                    </a>
                </li>';
            }                                                
        }
-->
