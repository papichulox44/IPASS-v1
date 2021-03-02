<?php
        include("../conn.php");
        if(isset($_POST['fetch']))
        {  
            $space_id = $_POST['space_id'];
            $results = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
            while($rows = mysqli_fetch_array($results))
            {
                echo'<li class="scrumboard-item btn-alt-warning" id="entry_'.$rows['field_id'].'" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-options">
                            <!--<a class="btn btn-sm btn-alt-warning"><i class="si si-pencil"></i></a>
                            <a class="btn btn-sm btn-alt-warning"><i class="fa fa-trash"></i></a>-->
                        </div>
                        <div class="scrumboard-item-content">                                            
                            <a class="scrumboard-item-handler btn btn-sm bg-gd-leaf" href="javascript:void(0)" style="margin-top: -3.5px;"><i class="fa fa-hand-grab-o text-white"></i></a>';
                             if($rows['field_type'] == "Textarea")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-text-width"></i> ';
                            }
                            else if($rows['field_type'] == "Text")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-text-height"></i> ';
                            }
                            else if($rows['field_type'] == "Email")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-envelope-o"></i> ';
                            }
                            else if($rows['field_type'] == "Dropdown")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-angle-double-down"></i> ';
                            }
                            else if($rows['field_type'] == "Phone")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-phone"></i> ';
                            }
                            else if($rows['field_type'] == "Date")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-calendar-o"></i> ';
                            }
                            else if($rows['field_type'] == "Number")
                            {
                                echo'<i class="mr-5 ml-10 fa fa-hashtag"></i> ';
                            }
                            else
                            {
                                echo'<i class="mr-5 ml-10 fa fa-dot-circle-o"></i> ';
                            }
                            echo'<label>'.$rows['field_name'].'</label>
                            <button type="submit" hidden="hidden" class="btn btn-primary btn-noborder mr-1 mb-5" name="btn_modal_status_names"><i class="fa fa-check"></i></button>
                        </div>
                </li>';
            }
        }
?>