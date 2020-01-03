<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->item_master_url_str;

$disp_url = "project.php"."?page=1".$url_str;
$edit_url = "project_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	
	$txticat_id='';
	$txtitem_name='';
	$txtuom_id='';
	$txthcm_id='0';
	$txtitem_uprice='0';
	$txtcStatus='A';
	
	$form_mode = "I";
	
}

elseif($mode == 'I')
{
	$txtid = NextID("pro_id", "project_master");
	$txticat_id=post_val($_POST['txticat_id']);
	$txtitem_name=post_val($_POST['txtitem_name']);
	
	$txtcStatus=post_val($_POST['txtcStatus']);
	
			$q = "insert into project_master values( '$txtid','$txticat_id','$txtitem_name','$txtcStatus')"; 
			//echo $q; exit();
			$r = RunQry($q);
			
			if($r)
			{
				echo "<script type='text/javascript'>
					alert('Project added successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in adding project');
					</script>";
			}
	
	$loc_str = $disp_url;

	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
	exit;
	//$_SESSION[SES_ADMIN]->success_msg = "Client".$txt_msg." Details Successfully Inserted";
	
}

elseif($mode == 'E')
{
	$q = "select * from project_master where pro_id=$txtid";
	
	$r = RunQry($q);
	if(!mysqli_num_rows($r))
	{
		header("location: $edit_url");
		exit;
	}
	$o = mysqli_fetch_object($r);
	
	$txticat_id=$o->client_id;
	$txtitem_name=$o->pro_name;
	
	$txtcStatus=$o->cStatus;
	
	$form_mode = "U";
	
}

elseif($mode == 'U')
{
	$txticat_id=post_val($_POST['txticat_id']);
	$txtitem_name=post_val($_POST['txtitem_name']);
	
	$txtcStatus=post_val($_POST['txtcStatus']);
	
	$q = "UPDATE `project_master` SET `client_id`='$txticat_id', `pro_name`='$txtitem_name',`cStatus`='$txtcStatus' where pro_id = '$txtid'";
		//echo $q; exit();
		$r = RunQry($q);
		
		if($r)
			{
				echo "<script type='text/javascript'>
					alert('Project updated successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in updating Project');
					</script>";
			}
	
}

	
if($mode == "I" || $mode == "U")
{
	
	$loc_str = $edit_url."?mode=E&id=$txtid";

	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
	exit;
}	

$subcat_arr=GetArray("Select client_id,client_name  from client_master where 1 ");


?>
<html lang="en">
<head>
<?php include('_header.php'); ?>
  <script src="../js1.3/script.js"></script>
  <script language="JavaScript" type="text/javascript">
  
	
	</script>
  
<?php include('_menu.php');?>
	
		 <div id="row_wrap">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
				<div class="col-sm-5">
					<h3>REMOVAL COMPANY</h3>
					
					<div class="form-group">
						<label>Removal Company</label>
						<input type="text" class="form-control" id="txtitem_name" name="txtitem_name" value="<?php echo $txtitem_name ?>" placeholder="Removal Company..." required/>
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
				</div>
				
			</form>
		</div>
		</div>
		</div>

		<?php include('_footer.php'); ?>
		
	</div>
<?php

?>
</body>
</html>
	
<?php	
	

?>