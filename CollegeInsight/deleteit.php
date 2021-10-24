<section class="container-fluid">
	<div class="row">
		<div class="col-md-8 offset-2" id="teacherClass">
			<div class="card my-2">
				<div class="card-header">
					<div class="row">
						<div class="col-md-11">
							<p class="h3">Notifications</p>
						</div>
					</div>
				</div>
				<div class="card-body" id="studentDetail">
					<div class="row">

						<?php
							global $ConnectingDB;
							$sql="select n.id as id, n.textcontent as textcontent, n.datetime as datetime,c.id as cid, c.cname as cname,t.id as tid, t.firstname as firstname, t.lastname as lastname, t.profilephoto as profilephoto, cr.status as staus ";
							$sql .= " from notification as n, class as c, teacher as t, classroom as cr ";
							$sql .= " where n.cid=c.id and c.tid=t.id and t.id=cr.tid and cr.cid=c.id and cr.status='approved' and cr.sid='$_SESSION[User_Id]' Order BY n.id DESC";
							$Execute=$ConnectingDB->query($sql);
							
							while($DataRows=$Execute->fetch()){

								$aid=$DataRows["id"];
								$tid=$DataRows["tid"];
								$cid=$DataRows["cid"];
								$TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
								$ProfilePic=$DataRows["profilephoto"];
								$ClassName=$DataRows["cname"];
								$TextContent=$DataRows["textcontent"];
								$NotificationDate=$DataRows["datetime"];

								$readmore=false;
								if(strlen($TextContent)>100){
									$TextContent=substr($TextContent,0,100)."...";
									$readmore=true;
								}
						?>
						<div class="row">
							<div class="col-md-1">
								<a href='Images/<?php echo $ProfilePic?>' target="_blank">
									<img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $ProfilePic;?>">
								</a>
							</div>
							<div class="col-md-11">
								<a href='Profile.php?tid=<?php echo $tid;?>' target="_blank"  style="text-decoration:none;color:black;">
									<p class="h3"><?php echo $TeacherName;?></p>
								</a>
								<a href='ClassRoom.php?id=<?php echo $cid;?>&&action=details' style="text-decoration:none;color:black;">
									<p class="h6"><?php echo $ClassName;?></p>
								</a>
								<p class="h6"><?php echo $NotificationDate;?></p>
							</div>
						</div>
					
						<p><?php echo $TextContent;?></p>

						<?php
						
							if($readmore)
							{
								?>
								
								<a href="FullNotification.php?id=<?php echo $aid?>" style="float:right;">
									<span class="btn btn-info">Read More >></span>
								</a>
								
								<?php
							}
						
						
                        ?>

    				</div>
				</div>
			</div>
      	</div>
	</div>
</section>








<section class="container py-2 mb-4">
	
    <div class="row">
        <div class="col-md-8 offset-md-2" >
            <?php
            global $ConnectingDB;
            $sql="select n.id as id, n.textcontent as textcontent, n.datetime as datetime,c.id as cid, c.cname as cname,t.id as tid, t.firstname as firstname, t.lastname as lastname, t.profilephoto as profilephoto, cr.status as staus ";
            $sql .= " from notification as n, class as c, teacher as t, classroom as cr ";
            $sql .= " where n.cid=c.id and c.tid=t.id and t.id=cr.tid and cr.cid=c.id and cr.status='approved' and cr.sid='$_SESSION[User_Id]' Order BY n.id DESC";
            $Execute=$ConnectingDB->query($sql);
            
            while($DataRows=$Execute->fetch()){

                $aid=$DataRows["id"];
                $tid=$DataRows["tid"];
                $cid=$DataRows["cid"];
                $TeacherName=$DataRows["firstname"]." ".$DataRows["lastname"];
                $ProfilePic=$DataRows["profilephoto"];
                $ClassName=$DataRows["cname"];
                $TextContent=$DataRows["textcontent"];
                $NotificationDate=$DataRows["datetime"];

                $readmore=false;
                if(strlen($TextContent)>100){
                    $TextContent=substr($TextContent,0,100)."...";
                    $readmore=true;
                }
            ?>
            <div class="card my-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-1">
                            <a href='Images/<?php echo $ProfilePic?>' target="_blank">
                                <img class='rounded-circle' style="height:50px;width:50px;" src="images/<?php echo $ProfilePic;?>">
                            </a>
                        </div>
                        <div class="col-md-11">
                            <a href='Profile.php?tid=<?php echo $tid;?>' target="_blank"  style="text-decoration:none;color:black;">
                                <p class="h3"><?php echo $TeacherName;?></p>
                            </a>
                            <a href='ClassRoom.php?id=<?php echo $cid;?>&&action=details' style="text-decoration:none;color:black;">
                                <p class="h6"><?php echo $ClassName;?></p>
                            </a>
                            <p class="h6"><?php echo $NotificationDate;?></p>
                        </div>
                    </div>
                
                </div>
                <div class="card-body">
                    <p><?php echo $TextContent;?></p>

                    <?php
                    
                        if($readmore)
                        {
                            ?>
                            
                            <a href="FullNotification.php?id=<?php echo $aid?>" style="float:right;">
                                <span class="btn btn-info">Read More >></span>
                            </a>
                            
                            <?php
                        }
                    
                    ?>
                    
                </div>
                
            </div>
        <?php
        }
        ?>
        </div>
    </div>
</section>
