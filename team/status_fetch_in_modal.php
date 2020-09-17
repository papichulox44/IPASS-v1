                                <ul class="scrumboard-items block-content list-unstyled statusss" id="sortables" class="connectedSortable">
                                    <?php
                                    include("../conn.php");
                                    $status_list_id = $_GET['list_id'];
                                    $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
                                    while($result_findstatus = mysqli_fetch_array($findstatus))
                                    {
                                        echo'<li class="scrumboard-item" id="entry_' . $result_findstatus['status_id'] . '" style="background-color: #fff;box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                                            <div class="scrumboard-item-options">
                                                <a class="scrumboard-item-handler btn btn-sm btn-alt-warning" href="javascript:void(0)">
                                                    <i class="fa fa-hand-grab-o"></i>
                                                </a>
                                            </div>
                                            <div class="scrumboard-item-content" style="margin: -3px 0px 0px 0px;">
                                                <a class="btn btn-sm btn-circle mr-5" href="javascript:void(0)" style="background-color: '.$result_findstatus['status_color'].';" style="height:10px;"></a>
                                                <label>'.$result_findstatus['status_name'].'</label>
                                            </div>
                                        </li>';                                
                                    }?> 
                                </ul>