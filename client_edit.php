<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->cat_url_str;

$disp_url = "client.php"."?page=1".$url_str;
$edit_url = "client_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	$cat_name='';
	$txtcStatus='A';	
	$form_mode = "I";	
}

elseif($mode == 'I')
{
	$txtid = NextID("client_id", "client_master");
	$cat_name=post_val($_POST['cat_name']);
	$txtcStatus=post_val($_POST['txtcStatus']);
	
			$q = "insert into client_master values( '$txtid','$cat_name','$txtcStatus')"; //,'$curr_date','$txtentry_by'
			//echo $q; exit();
			$r = RunQry($q);
			
			if($r)
			{
				echo "<script type='text/javascript'>
					alert('Client details added successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in adding client details ');
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
	$cat_name='';
	$txtcStatus='A';
	
	$q = "select * from client_master where client_id=$txtid";
	
	$r = RunQry($q);
	if(!mysqli_num_rows($r))
	{
		header("location: $edit_url");
		exit;
	}
	$o = mysqli_fetch_object($r);
	
	$cat_name=$o->client_name;
	$txtcStatus=$o->cStatus;
	
	$form_mode = "U";
	
}

elseif($mode == 'U')
{
	$cat_name=post_val($_POST['cat_name']);
	$txtcStatus=post_val($_POST['txtcStatus']);
	
	
     $q = "Update client_master set client_name = '$cat_name', cStatus = '$txtcStatus' where client_id = '$txtid'";
		//echo $q; exit();
		$r = RunQry($q);
		
		if($r)
			{
				echo "<script type='text/javascript'>
					alert('Client details updated successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in updating client details');
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
					<h3>FLAG</h3>
					<div class="form-group">
						<label>FLAG Name:</label>
						<input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $cat_name ?>" placeholder="Enter Client name..." required/>
					</div>
					
					<div class="form-group">
						<label>Visibility:&nbsp;&nbsp;</label>
						<input type="radio" id="txtcStatus" name="txtcStatus" value="A" checked required/> Active
						<input type="radio" id="txtcStatus" name="txtcStatus" value="I"  <?php if($txtcStatus=='I') echo "checked";?> required/> Inactive
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
	
