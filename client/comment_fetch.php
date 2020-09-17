<!--<div class="row items-push js-gallery img-fluid-100">
	<div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
		<span data-toggle="modal" data-dismiss="modal">
		    <a class="img-link img-thumb img-lightbox" href="../assets/media/photos/photo17@2x.jpg">
		        <img class="img-fluid" src="../assets/media/photos/photo17.jpg" alt="">
		    </a>
		</span>
	</div>
</div>-->
<?php
        include("../conn.php");
        if(isset($_POST['fetch']))
        {  
        	$task_id = $_POST['task_id'];
        	$contact_id = $_POST['id'];
        	$results = mysqli_query($conn, "SELECT * FROM comment left join user on user.user_id = comment.comment_user_id WHERE comment_task_id = '$task_id' ORDER BY comment_date DESC");
	        while($rows = mysqli_fetch_array($results))
	        {?>
	        	<tr class="block parent">
		            <td class="d-none d-sm-table-cell font-w600" style="width: 50px;">
		                <div>
		                	<?php
		                		$user_id = $rows['user_id'];
		                		$comment_user_id = $rows['comment_user_id'];
		                		if ($comment_user_id == $contact_id)
		                		{
			                		$res = mysqli_query($conn, "SELECT * FROM contact WHERE contact_id = $comment_user_id");
			                		$row12 = mysqli_fetch_assoc($res);

	                                if($row12['contact_profile'] != "")
	                                {
	                                	echo '<img style="width: 38px;border-radius: 50px;" src="client_profile/'.$row12['contact_profile'].'">';
	                                }
	                                else
	                                {
	                                	echo '<img style="width: 38px;border-radius: 50px;" src="../assets/media/photos/avatar.jpg">';	                                	
	                                }
								} 
								else 
								{
			                		$res = mysqli_query($conn, "SELECT * FROM user WHERE user_id = $user_id");
			                		$row12 = mysqli_fetch_assoc($res);
	                                $get_first_letter_in_fname = $row12['fname'];                        
	                                $get_first_letter_in_lname = $row12['lname'];

	                                if($row12['profile_pic'] != "")
	                                {
	                                	echo '<img style="width: 38px;border-radius: 50px;" src="../assets/media/upload/'.$row12['profile_pic'].'">';
	                                }
	                                else
	                                {
	                                	echo '<span style="padding: 10px 10px; border-radius: 50px; color: #fff; background-color: '.$row12['user_color'].'"><?php echo $get_first_letter_in_fname[0]; echo $get_first_letter_in_lname[0]?></span>';
	                                }
								}

		                	?>	                    
		                </div>                                                
		            </td>
		            <td>
		            	<div>
	                        <!---->
	                        <strong>
	                        	<?php 
	                        	if ($comment_user_id == $contact_id)
		                		{
		                			echo '
		                			<div class="child float-right">
		                                <button type="button" class="btn-block-option delete_comment" style="margin-top: -3px;" value="'.$rows['comment_id'].'" style="display: none;">
		                                    <i class="si si-close text-danger"></i>
		                                </button>
			                        </div>
		                			<span class="text-primary">Me:</span>';
		                		}
		                		else
		                		{
		                			echo $row12['fname']; echo $row12['lname'];
		                		}
		                		?>
		                	</strong>
	                        <div class="float-right">
	                            <span style="text-align: right; font-size: 11px; font-style: italic;">
			            			<?php echo date('M d Y',strtotime($rows['comment_date'])); echo ' at '; echo date('h:i A',strtotime($rows['comment_date'])); ?>
			            		</span>
	                        </div>
	                    </div>	                
		                <div class="text-muted mt-5">
		                	<span style="font-size: 13px;"><?php echo $rows['comment_message']?></span>
		                </div>    
		                <div class="text-muted mt-5">
		                	<?php 
		                		if($rows['comment_attactment'] != "")
		                		{
		                			$path_info = pathinfo('../assets/media/comment/'.$rows['comment_attactment'].'');
									$extension = $path_info['extension']; // get the file extension

									if($extension == "docx")
									{
										echo'<img src="../assets/media/icon/WORD.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['comment_attactment'].'</span>
											<input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'"> 
			                				<a href="download_image.php?comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
									}
									else if($extension == "xlsx")
									{
										echo'<img src="../assets/media/icon/EXCEL.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['comment_attactment'].'</span>
											<input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'"> 
			                				<a href="download_image.php?comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
									}
									else if($extension == "csv")
									{
										echo'<img src="../assets/media/icon/CSV.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['comment_attactment'].'</span>
											<input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'"> 
			                				<a href="download_image.php?comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
									}
									else if($extension == "pdf")
									{
										echo'<img src="../assets/media/icon/PDF.png" style="float:left; margin: 0px 0px 0px 0px; width: 50px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['comment_attactment'].'</span>
											<input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'"> 
			                				<a href="download_image.php?comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
									}
									else
									{
										echo'<img src="../assets/media/comment/'.$rows['comment_attactment'].'" style="float:left; margin: 0px 0px 0px 0px; width: 200px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
		                				<input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'"> 
		                				<a href="download_image.php?comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
									}		                			
		                		}
		                		else
		                		{}
		                	?>
		                </div>
		            </td>                                                
		        </tr>
	        <?php
    		}
        }
?>