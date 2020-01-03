<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->client_url_str;

$disp_url = "DE_operater.php"."?page=1".$url_str;
$edit_url = "DE_operater_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	$txtclient_name='';
	$txtusertype='';
	$txtemail_id='';
	$txtphno='';
	$txtaddr='';
	$txtdob='';
	$txtanv='';
	$txtregion='';
	$txtgst_no='';
	$txtcmp_name='';
	$txtcust_notes='';
	$txtcStatus='A';
	$txtusername = '';
	$txtpassword = '';
	$form_mode = "I";
	
}

elseif($mode == 'I')
{
	$txtid = NextID("user_id", "user_table");
	$txtclient_name=post_val($_POST['txtclient_name']);
	
	$txtemail_id=post_val($_POST['txtemail_id']);
	$txtphno=post_val($_POST['txtphno']);
	$txtaddr=post_val($_POST['txtaddr']);
	$txtdob=post_val($_POST['txtdob']);
	
	$txtregion=post_val($_POST['txtregion']);
	
	$txtcStatus=post_val($_POST['txtcStatus']);
	$txtusername = $_POST["username"];
	$txtpassword = md5($_POST["pass_word"]);
	
	if($txtphno=='') $txtphno=0;
	if(trim($txtusername)!="" || trim($txtpassword)!="" )   
{
	$txtusername = trim($txtusername); 
	$txtpassword = myhash($txtpassword);

			$q = "insert into user_table values( '$txtid','$txtregion','$txtclient_name','$txtemail_id','$txtphno','$txtaddr','$txtdob','$txtusername','$txtpassword','$txtcStatus','DE')"; 
			//echo $q; exit();
			$r = RunQry($q);
}
	
	
			
			if($r)//$r)
			{
				echo "<script type='text/javascript'>
					alert('New Operater added successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in adding Operater');
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
	
	$q = "select * from user_table where user_id=$txtid";
	
	$r = RunQry($q);
	if(!mysqli_num_rows($r))
	{
		header("location: $edit_url");
		exit;
	}
	$o = mysqli_fetch_object($r);
	
	$txtclient_name=$o->name;
	
	$txtemail_id=$o->email_id;
	$txtphno=$o->phno;
	$txtaddr=$o->addr;
	$txtdob=$o->dob;
	
	$txtregion=$o->r_id;
	
	$txtcStatus=$o->cStatus;
	$txtusername = $o->username; 
	$txtpassword ='';
	$form_mode = "U";
	
}

elseif($mode == 'U')
{
	$txtid = post_val($_POST['txtid']);
	$txtclient_name=post_val($_POST['txtclient_name']);
	
	$txtemail_id=post_val($_POST['txtemail_id']);
	$txtphno=post_val($_POST['txtphno']);
	$txtaddr=post_val($_POST['txtaddr']);
	$txtdob=post_val($_POST['txtdob']);
	
	$txtregion=post_val($_POST['txtregion']);
	
	$txtcStatus=post_val($_POST['txtcStatus']);
	$txtusername = $_POST["username"];
	$txtpassword = md5($_POST["pass_word"]);
	
	if($txtphno=='') $txtphno=0;
	$userpass='';
	if(trim($txtusername)!="" || trim($txtpassword)!="" )   
{
	$txtusername = trim($txtusername); 
	
	$userpass.=",username='$txtusername'";
		
}
	if( trim($_POST["pass_word"])!="" )   
{
	
	$txtpassword = myhash($txtpassword);
	$userpass.=",pass_word='$txtpassword'";
		
}
		$q = "Update user_table set name = '$txtclient_name', email_id = '$txtemail_id', phno = '$txtphno',addr='$txtaddr', dob='$txtdob',r_id='$txtregion',cStatus='$txtcStatus' $userpass where user_id = '$txtid'";
		//echo $q; exit();
		$r = RunQry($q);
		
		if($r)
			{
				echo "<script type='text/javascript'>
					alert('Operater details updated successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in updating Operater details');
					</script>";
			}
	
}
/*
elseif($mode=="D")
{
 	$q = "Update client_tb set `cStatus`='I' where client_id = '$txtid'";
	$r = RunQry($q);
	
	if($r)
	{
		echo "<script type='text/javascript'> 
		alert('Customer details Successfully Deleted')
		</script>";
	}
	else
	{
		echo "<script type='text/javascript'> 
		alert('Error in deleting customer details')
		</script>";
	}	
   
	$loc_str =  $disp_url;	
	echo "<script type='text/javascript'> 
	window.location.assign('".$loc_str."');
	</script>";
	exit;
}*/
	
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
  
	$(function() {
		$( ".datepicker" ).datepicker(
		{
			dateFormat:"yy-mm-dd",
			changeMonth: true,
            changeYear: true
		});
  });
	</script>
  
<?php include('_menu.php');?>
	
		 <div id="row_wrap">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
				<div class="col-sm-5">
					<h3>Flag Details</h3>
					<div class="form-group">
						<label>FLAG:</label>
						<input type="text" class="form-control" id="txtclient_name" name="txtclient_name" value="<?php echo $txtclient_name ?>" placeholder= "Flag Name..." required/>
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