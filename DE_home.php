<?php

include('dynamic.php');

$disp_url = "view_files.php";
$edit_url = "DE_home.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'I')
{
	$fileid=NextID("file_id","file_records");
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
	$fileid=NextID("file_id","file_records");
	$file_no=post_val($_POST['file_no']);
	$file_name=post_val($_POST['file_name']);
	$file_desc=post_val($_POST['file_desc']);
	$file_inwarddate=post_val($_POST['file_inwarddate']);
	$fileclosedate=post_val($_POST['fileclosedate']);

				if($media_up_cnt>0)
				{
					$sql="insert into file_records values($fileid,'$file_no','$file_name','$file_desc','$file_inwarddate','$fileclosedate',now(),'N')";
					RunQry($sql);
					$log_id=NextID("log_id","log_table");
					$sqllog="insert into log_table values($log_id,$fileid,'$sess_user_id',now(),'INSERT')";
					RunQry($sqllog);
					echo "<script type='text/javascript'>
					alert('".$media_up_cnt." File(s) added successfully');
					</script>";
				}
				else
				{
					echo "<script type='text/javascript'>
						alert('Error in adding tracks');
						</script>";
				}
	
		$loc_str = $disp_url;
	
	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
}



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
		output.innerHTML += '<div class="form-group"><label>File Name: ' + input.files.item(i).name + '</label><input type="number" class="form-control" id="tag'+i+'" name="tag[]" value="" placeholder="Page no" required /></div>';
		
		
		
		
	  }
	  output.innerHTML += '<table width="100%"><tr><td width="50%"><input type="submit" class="btn btn-info btn-md" id="task_update" name="submit" value="Save"></td><td width="50%"><a href="view_files.php" class="btn btn-info btn-md">Cancel</a></td></tr></table>';
	}
	
$(document).ready(function(){
	$("form").on('submit', function (e) {
  	 
 		 
   			 if (( $('#para1').val() === '' )&&( $('#para2').val() === '' )&&( $('#para3').val() === '' )&&( $('#para4').val() === '' )&&( $('#para5').val() === '' ))
        		
        		{
        			alert("Please Fill Atleast 1 Parameter");
        				e.preventDefault();
        		}
        		var values = [];
        		var count=$("input[type=number][name='tag[]']").length;
        		
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
				   	alert("Page number exceeds number of pages ");
				   	e.preventDefault();
				   }
					
				});
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
				        // get the file name, possibly with path (depends on browser)
       

				
});
	$(".datepicker").datepicker({
		 dateFormat: 'yy-mm-dd'
	});
});	
</script>
  <?php include('_menu.php');?>

<button onclick="launchscanner()">Launch Scanner</button>
	<form id="" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data" >

				<input type="hidden" name="mode" id="mode" value="I">
				
		 <div id="row_wrap">
			<div class="row"> 
				<div class="col-sm-8"> 	
					<div class="form-group">
						<label>VESSEL NAME:</label>
						<input type="text"  class="form-control" id="para1" name="file_no" value="" placeholder="VESSEL NAME."  />
					</div>
				
				<br>
				
				<div class="form-group">
						<label>IMO No:</label>
						<input type="number" class="form-control" id="para2" name="file_name" value="" placeholder="IMO No"  />
					</div> 
			
				<br>
				<div class="form-group">
				FLAG: <select name="flag">
    	<option value="1">1</option>
	    <option value="2">2</option>
	    <option value="3">3</option>
	    <option value="4">4</option>
	</select><br>
				
				
		
				
				
				</div>
			
			<br>
			<div class="row"> 
				
				<div class="form-group">
						<label> FLAG GROUP no:</label>
						<input type="number" class="form-control" id="para4" name="file_inwarddate" value="" placeholder="FLAG GROUP"  />
					
				</div>
		
					
						
						<table width="100%">
					<tr>
				<td  width="50%"><input type="submit" class="btn btn-info btn-md" name="submit" value="Save"> </td>
					<td width="50%"> 
        <a href="<?php echo $disp_url ?>" class="btn btn-info btn-md">
           Cancel
        </a>
		 </td>
		</tr>
		</table>
						<div class="col-sm-12" id="fileList">
				
				
							
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