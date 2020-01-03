<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->hcm_url_str;

$disp_url = "company.php"."?page=1".$url_str;
$edit_url = "company_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	$comp_name='';
	$comp_addr='';	
	$form_mode = "I";
	$comp_gst='';
	$comp_account='';	
}

elseif($mode == 'I')
{
	$txtid = NextID("comp_id", "company_master");
	$comp_name=post_val($_POST['comp_name']);
	$comp_addr=post_val($_POST['comp_addr']);
	$comp_gst=post_val($_POST['comp_gst']);
	$comp_account=post_val($_POST['comp_account']);
	
			$q = "insert into company_master values('$txtid','$comp_name','$comp_addr','$comp_gst','$comp_account','A')"; //,'$curr_date','$txtentry_by'
			//echo $q; exit();
			$r = RunQry($q);
			
			if($r)
			{
				echo "<script type='text/javascript'>
					alert('Company Details added successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in adding company details');
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
	
	$comp_name='';
	$comp_addr='';	
	$comp_gst='';
	$comp_account='';
	
	$q = "select * from company_master where comp_id=$txtid";
	
	$r = RunQry($q);
	if(!mysqli_num_rows($r))
	{
		header("location: $edit_url");
		exit;
	}
	$o = mysqli_fetch_object($r);
	$comp_name=$o->comp_name;
	$comp_addr=$o->comp_addr;	
	$comp_gst=$o->comp_gstno;
	$comp_account=$o->comp_account;
	
	
	$form_mode = "U";
	
}

elseif($mode == 'U')
{
	$comp_name=post_val($_POST['comp_name']);
	$comp_addr=post_val($_POST['comp_addr']);
	$comp_gst=post_val($_POST['comp_gst']);
	$comp_account=post_val($_POST['comp_account']);
	
	
     $q = "Update company_master set comp_name = '$comp_name', comp_addr = '$comp_addr',comp_gstno = '$comp_gst', comp_account = '$comp_account' where comp_id = '$txtid'";
		//echo $q; exit();
		$r = RunQry($q);
		
		if($r)
			{
				echo "<script type='text/javascript'>
					alert('Company Details  updated successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in updating Company Details');
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
					<h3>Company Details</h3>
					<div class="form-group">
						<label>Company Name:</label>
						<input type="text" class="form-control" id="comp_name" name="comp_name" value="<?php echo $comp_name ?>" placeholder="Enter company Name..." required/>
					</div>
					<div class="form-group">
						<label>Company address:</label>
						<textarea placeholder="Enter company address..." class="form-control" id="comp_addr" name="comp_addr" required><?php echo $comp_addr ?></textarea>
					</div>
					<div class="form-group">
						<label>GST number:</label>
						<input type="text" class="form-control" id="comp_gst" name="comp_gst" value="<?php echo $comp_gst ?>" placeholder="Enter GST number..." required/>
					</div>
						<div class="form-group">
						<label>Company Account Details:</label>
						<textarea placeholder="Enter company Account details..." class="form-control" id="comp_account" name="comp_account" required><?php echo $comp_account ?></textarea>
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

</body>
</html>
	
