<?php

include('dynamic.php');



if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

$disp_url = "view_files.php";
$edit_url = "update_file_details.php?id=$txtid"; 

if($txtid!='0')
{
	$queryfetch="select * from file_records where file_id=$txtid";
	$res=RunQry($queryfetch);
	$obj=mysqli_fetch_object($res);
	$file_no=$obj->file_no;
	$file_name=$obj->file_name;
	$file_desc=$obj->file_description;
	$file_inwarddate=$obj->inward_date;
	$fileclosedate=$obj->closed_date;
	$fileprojectname=$obj->project_name;
	$clientname=$obj->client_name;
}
if($mode == 'U')
{
	$fileid=post_val($_POST['txtid']);
	$file_no=post_val($_POST['file_no']);
	$file_name=post_val($_POST['file_name']);
	$file_desc=post_val($_POST['file_desc']);
	$file_inwarddate=post_val($_POST['file_inwarddate']);
	$fileclosedate=post_val($_POST['fileclosedate']);
	$fileprojectname=post_val($_POST['fileprojectname']);
	$clientname=post_val($_POST['clientname']);
	
	
	$pfile=$_FILES['uploaded'];
	$pfile_cnt=count($_FILES['uploaded']['name']);
		
	$target_dir = "../media/";
	
	$media_up_cnt=0;
	
	for($counter=0;$counter<$pfile_cnt;$counter++)
	{
		//print_r($pfile);
		$pfile_nm = $_FILES['uploaded']['name'][$counter];
		
		if($pfile_nm!='')
		{
			
			$target_file = $target_dir . basename( $_FILES['uploaded']['name'][$counter]);
			$ext=pathinfo($target_file,PATHINFO_EXTENSION);
			$file_ext = strtoupper($ext);
			
				if(($file_ext=="PNG")||($file_ext=="JPG"))
			{
				$tag=$_POST['tag'];
				//get file name without suffix
					$fileuni = str_pad($fileid, 5, '0', STR_PAD_LEFT);
					$myname="FILE".$fileuni."_".$file_name."_".$tag[$counter];
					$rootname = $myname.".".$ext;
					$target_file= $target_dir.$rootname;
					
				
				
				$target_file = str_replace(" ","_",$target_file);
				
				
			
				if(move_uploaded_file($_FILES['uploaded']['tmp_name'][$counter],$target_file))
				{
					
					$att_id=NextID("att_id","attachments");
					$query="insert into attachments values ($att_id,'$fileid','$target_file','$tag[$counter]')";
					RunQry($query);
					$txtid_arr[]=$txtid;
					$media_up_cnt++;
					//uploadding path goes below
					unlink("../../../../Users/Go it way 10/Pictures/MP Navigator EX/".$pfile_nm);
				}
			}
		}
	}

				if($media_up_cnt>0)
				{
					
					echo "<script type='text/javascript'>
					alert('".$media_up_cnt." File(s) added successfully');
					</script>";
					
				}
				else
				{
					echo "<script type='text/javascript'>
						alert('Record updated successfully');
						</script>";
						
				}
			RunQry("delete from pdf where pdf_id='$fileid'");
				$sql="UPDATE file_records SET file_no='$file_no',file_name='$file_name',file_description='$file_desc',inward_date='$file_inwarddate
				',closed_date='$fileclosedate' where file_id=$fileid";
					RunQry($sql);
					$log_id=NextID("log_id","log_table");
					$sqllog="insert into log_table values($log_id,$fileid,'$sess_user_id',now(),'UPDATE')";
					RunQry($sqllog);
	
		$loc_str = $disp_url;
	
	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
}

$filescount=GetSingleValue("select COALESCE(count(*),0) from attachments where file_id=$txtid");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<html lang="en">
<head>
<?php include('_header.php'); ?>
  <script src="../js1.3/script.js"></script>
  
  <script language="JavaScript" type="text/javascript">


		</script>
  
<script language="JavaScript" type="text/javascript">
function launchscanner()
{
	$.ajax({
					url: "fileopendemo.php",
					type: "POST",
					data: "",
					success: function(res) {
						//$("#dp_display").attr('src',res);
						//$("#dp_display").click(function(){
						//	$("#dp_upload").trigger("click");
					//	});
						//alert(res);
						return false;
					}
					});
}
	updateList = function() {
	  var input = document.getElementById('uploaded');
	  var output = document.getElementById('fileList');

	  output.innerHTML = '';
	  for (var i = 0; i < input.files.length; ++i) {
		output.innerHTML += '<div class="form-group"><label>File Name: ' + input.files.item(i).name + '</label><input type="number" class="form-control" id="tag'+i+'" name="tag[]" value="" placeholder="Page No" required /></div>';
		
		
		
		
	  }
	 
	}
$(document).ready(function(){
	 var filescount=<?php echo$filescount;?>;
 		 if(filescount==0)
 		 {
 		 	$("#uploaded").prop('required',true);
 		 }

	$("form").on('submit', function (e) {
  	

   			 if (( $('#para1').val() === '' )&&( $('#para2').val() === '' )&&( $('#para3').val() === '' )&&( $('#para4').val() === '' )&&( $('#para5').val() === '' ))
        		
        		{
        			alert("Please Fill Atleast 1 Parameter");
        				e.preventDefault();
        		}
        		var values = [];
        		<?php
        		$fetchattach="select * from attachments where file_id=$txtid";
								$resattach=RunQry($fetchattach);
								for($i=1; $objattach = mysqli_fetch_object($resattach); $i++) 
									{
										$page_no=$objattach->page_no;
										?>
										values.push("<?php echo$page_no; ?>");
										<?php
									}
        		?>
        		//alert($("input[type=number][name='tag[]']").length);
        		var count=parseInt($("input[type=number][name='tag[]']").length)+parseInt(filescount);
        		
				$("input[type=number][name='tag[]']").each(function () {
				    if ($.inArray(this.value, values) >= 0) {

				        alert('Page numbers must be unique.');
				        e.preventDefault();

				        return false; // <-- stops the loop
				    }
					values.push(this.value);
					
				});
				$(values).each(function () {
				   if(this==0)
				   {
				   	alert("Page number cannot be zero");
				   	e.preventDefault();
				   }
				  if(this>count)
				   {
				   	alert("Page number exceeds number of pages");
				   	e.preventDefault();
				   }
					
				});
				console.log(values);
				 var input = document.getElementById('uploaded');
				var flag=0;
 for (var i = 0; i < input.files.length; ++i) 
 {
 	 var filename = input.files.item(i).name;

        // Use a regular expression to trim everything before final dot
        var extension = filename.replace(/^.*\./, '');

        // Iff there is no dot anywhere in filename, we would have extension == filename,
        // so we account for this possibility now
        if (extension == filename) {
            extension = '';
        } else {
            // if there is an extension, we convert to lower case
            // (N.B. this conversion will not effect the value of the extension
            // on the file upload.)
            extension = extension.toLowerCase();
        }

        switch (extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                

            // uncomment the next line to allow the form to submitted in this case:
         break;

            default:
                // Cancel the form submission
               flag=1;
        }
 }
 if(flag==1)
 {
 	alert("choose proper file types");
 	e.preventDefault();
 }
				
});
	<?php
		//if($filescount!="0")
		{


	?>
	//$(".uploadbox").hide();
	<?php
	}
	?>
	$(".datepicker").datepicker({
		 dateFormat: 'yy-mm-dd'
	});
});	
function del_curr_row(id,filename)
{
	var txtid=document.getElementById("txtid").value;
	//console.log("update_file_details.php?id="+txtid);
	if(confirm("are you sure you want to delete the file??"))
	{
		//window.location.assign('update_file_details.php?id='+txtid);
		$.ajax({
					url: "deleteattachment.php",
					type: "GET",
					data: "id="+id+"&filename="+filename,
					success: function(res) {
						//$("#dp_display").attr('src',res);
						//$("#dp_display").click(function(){
						//	$("#dp_upload").trigger("click");
					//	});

						window.location.assign('update_file_details.php?id='+txtid);

						
						return false;

					}
					});
	}
}
</script>
  <?php include('_menu.php');?>

<button onclick="launchscanner()">Launch Scanner</button>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data" >

				<input type="hidden" name="mode" id="mode" value="U">
				<input type="hidden" name="txtid" id="txtid" value="<?php echo$txtid;?>">
		 <div id="row_wrap">
			<div class="row"> 
				<div class="col-sm-4"> 
					<div class="form-group">
						<label>Parameter 1</label>
						<input type="text" class="form-control" id="para1" name="file_no" value="<?php echo$file_no; ?>" placeholder="parameter 1"  />
					</div>
				</div>
				<div class="col-sm-4">
				<div class="form-group">
						<label>Parameter 2:</label>
						<input type="text" class="form-control" id="para2" name="file_name" value="<?php echo$file_name; ?>" placeholder="parameter 2"  />
					</div> 
				</div>
				<div class="col-sm-4"> 
					<div class="form-group">
						<label>Parameter 3.:</label>
						<textarea placeholder="Parameter 3" id="para3" class="form-control" name="file_desc"  ><?php echo$file_desc; ?></textarea>
						
					</div>
				</div>
			</div>  
			<div class="row"> 
				<div class="col-sm-4">
				<div class="form-group">
						<label> Parameter 4.:</label>
						<input type="text" class="form-control " id="para4" name="file_inwarddate" 
						value="<?php echo$file_inwarddate; ?>" placeholder="parameter 4"  />
					</div> 
					<div class="form-group">
						<label>Parameter 5.:</label>
						<input type="text" class="form-control " id="para5" name="fileclosedate" value="<?php echo$fileclosedate; ?>" placeholder="Parameter 5"  />
					</div>
				</div>
			
				<div class="col-sm-4">
					<div class="form-group">
						
						<br><br>
						<input type="submit" class="btn btn-info btn-md pull-right" id="task_update" name="submit" value="Save">

					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						
						<br><br>
						<a href="view_files.php" class="btn btn-info btn-md pull-right">Cancel</a>

					</div>
					
					
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<legend>Uploaded Files</legend>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Sr No.</th>
								
								
								<th>Page No</th>
								<th>File</th>
								<th>Delete</th>

							</tr>
						</thead>
						<tbody>
							<?php
								$fetchattach="select * from attachments where file_id=$txtid";
								$resattach=RunQry($fetchattach);
								for($i=1; $objattach = mysqli_fetch_object($resattach); $i++) 
									{
								
										$att_id=$objattach->att_id;
										$page_no=$objattach->page_no;
										$att_filename=$objattach->att_filename;
										echo"<tr>";
										echo"<td>$i</td>";
										echo"<td>$page_no</td>";
										echo"<td><a href='$att_filename' target='_blank'>".IMG_PRINT."</a></td>";
										echo'<td><button type="button" class="close del_row" id="" style="opacity:1;font-size: 28px;text-shadow: 0 1px 0 #818181;" onclick="del_curr_row(this.value,this.name)" value="'.$att_id.'" name="'.$att_filename.'">&times;</button></td>';
										echo"<tr>";

									}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row uploadbox" >
					<div class="col-sm-5"> 
					<div class="form-group">
						<div class="Uploadbtn" style="border:1px solid #ccc;min-height:78px;height:14%;width:90%;padding:2%;">
						  <input name="uploaded[]" id="uploaded" accept="image/*"  type="file"  class="input-upload" multiple onchange="javascript:updateList()" />
						  <span>Drop files here <br>or <br>click to browse your computer.</span>
						</div>
						<div class="col-sm-12" id="fileList">
				
				
							
				</div>
					</div>
					
					
				</div>
				
			</div>
			
		</div>  
				
					
					
					
					
					
					

  		</div>
  		
  	</form>
  </div>
  </div>
  
  
 <?php include('_footer.php'); ?>
  

  
</div>


</body>
</html>