<?php
        include("../conn.php");
        if(isset($_POST['fetch']))
        {  
        	$user_id = $_POST['user_id'];
        	$reciever_id = $_POST['reciever_id'];

        	$code1_sender_to_reciever = $reciever_id .','. $user_id;
        	$code2_reciever_to_sender = $user_id .','. $reciever_id;
        	
        	mysqli_query($conn, "UPDATE message SET status = '0' WHERE code = '$code1_sender_to_reciever'") or die(mysqli_error());

        	$results = mysqli_query($conn, "SELECT * FROM message left join user on user.user_id = message.sender_id  ORDER BY chat_date DESC");
	        while($rows = mysqli_fetch_array($results))
	        {
	        	if($rows['code'] == $code1_sender_to_reciever)
	        	{?>
	        		<div class="sender row">   
	                	<div style="width: 15%;" class="d-none d-md-block">
	                		<?php if($rows['profile_pic'] != ""): ?>
			        			<img class="smallim" src="../assets/media/upload/<?php echo $rows['profile_pic']; ?>">
			        		<?php else: ?>
			        			<img class="smallim" src="../assets/media/photos/avatarpic.jpg" alt="">
			        		<?php endif; ?>
	                	</div>
	                	<div style="width: 80%;">
	                		<span style="font-size: 12px; font-style: italic;"><?php echo $rows['chat_date']; ?></span>
	                		<?php 
		                		if($rows['attachment'] != "")
		                		{?>
            						<a href="message_download_file.php?id=<?php echo $rows['id']?>" class="btn-block-option btn"><i class="fa fa-download"></i></a>
		                	<?php
		                		}
		                		else{}
		                	?>
	                		<br>          
	                    	<span style="font-size: 14px;"><?php echo $rows['message']; ?></span><br>
	                    	<?php 
		                		if($rows['attachment'] != "")
		                		{		                			
		                			$path_info = pathinfo('../assets/media/message/'.$rows['attachment'].'');
									$extension = $path_info['extension']; // get the file extension

									if($extension == "docx")
									{
										echo'<img src="../assets/media/icon/WORD.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "xlsx" || $extension == "xls")
									{
										echo'<img src="../assets/media/icon/EXCEL.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "csv")
									{
										echo'<img src="../assets/media/icon/CSV.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "pdf")
									{
										echo'<img src="../assets/media/icon/PDF.png" style="float:left; margin: 0px 0px 0px 0px; width: 50px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else
									{
										echo'<img src="../assets/media/message/'.$rows['attachment'].'" style="float:left; margin: 0px 0px 0px 0px; width: 200px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">';
									}		
		                		}
		                	?>
	                    </div>
	                    <br>    
	                </div>
	        	<?php
	        	}
	        	else if($rows['code'] == $code2_reciever_to_sender)
	        	{?>
					<div class="reciever row" style="text-align: right;">   
						<div style="width: 20%;"> 
						</div>
						<div style="width: 80%;">  
	                		<?php 
		                		if($rows['attachment'] != "")
		                		{?>
            						<a href="message_download_file.php?id=<?php echo $rows['id']?>" class="btn-block-option btn"><i class="fa fa-download"></i></a>
		                	<?php
		                		}
		                		else{}
		                	?>
		                    <span style="font-size: 12px; font-style: italic;"><?php echo $rows['chat_date']; ?></span>
		                    <div class="child float-right">
                                <button type="button" class="btn-block-option delete_comment" style="margin-top: -3px;" value="<?php echo $rows['id']; ?>" style="display: none;">
                                    <i class="si si-close text-danger"></i>
                                </button>
	                        </div>
		                    <br>                   
		                    <span style="font-size: 14px;"><?php echo $rows['message']; ?></span><br>  
		                    <?php 
		                		if($rows['attachment'] != "")
		                		{
		                			
		                			$path_info = pathinfo('../assets/media/message/'.$rows['attachment'].'');
									$extension = $path_info['extension']; // get the file extension

									if($extension == "docx")
									{
										echo'<img src="../assets/media/icon/WORD.png" style="float:right; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "xlsx" || $extension == "xls")
									{
										echo'<img src="../assets/media/icon/EXCEL.png" style="float:right; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "csv")
									{
										echo'<img src="../assets/media/icon/CSV.png" style="float:right; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else if($extension == "pdf")
									{
										echo'<img src="../assets/media/icon/PDF.png" style="float:right; margin: 0px 0px 0px 0px; width: 50px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
											<span class="ml-10">'.$rows['attachment'].'</span>';
									}
									else
									{
										echo'<img src="../assets/media/message/'.$rows['attachment'].'" style="float:right; margin: 0px 0px 0px 0px; width: 200px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">';
									}		
		                		}
		                	?> 
	                    </div>	
	                </div> 
	        	<?php
	        	}
	        	else
	        	{}
	       }
        }
?>