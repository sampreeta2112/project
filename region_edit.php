<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->region_url_str;

$disp_url = "region.php"."?page=1".$url_str;
$edit_url = "region_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	$region_name='';
	$x_imo ='';
							$x_flag ='';
							$x_grp_no ='';
						
	$form_mode = "I";
	
}

elseif($mode == 'I')
{
	$txtid = NextID("r_id", "region_master");
	$file_id=post_val($_POST['file_id']);
	$region_name=post_val($_POST['v_name']);
	$x_imo=post_val($_POST['imo_no']);
	$x_flag=post_val($_POST['flag']);
	$x_grp_no=post_val($_POST['f_grp_no']);
	
			$q = "insert into region_master values( '$txtid','$file_id','$region_name','$x_imo','$x_flag','$x_grp_no')"; 
			//echo $q; exit();
			$r = RunQry($q);
			
		
	
	$loc_str = $disp_url;

	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
	exit;
	//$_SESSION[SES_ADMIN]->success_msg = "Client".$txt_msg." Details Successfully Inserted";
	
}

elseif($mode == 'E')
{
	$region_name='';
	$x_imo ='';
							$x_flag ='';
							$x_grp_no ='';
						
	$form_mode = "I";
	
	$q = "select * from region_master where r_id=$txtid";
	
	$r = RunQry($q);
	if(!mysqli_num_rows($r))
	{
		header("location: $edit_url");
		exit;
	}
	$o = mysqli_fetch_object($r);
	

	$region_name = $o->v_name;
							$x_imo = $o->imo_no;
							$x_flag = $o->flag;
							$x_grp_no = $o->f_grp_no;
						
	$form_mode = "U";
	
}

elseif($mode == 'U')
{
	$region_name=post_val($_POST['region_name']);
	$x_imo = $o->imo_no;
							$x_flag = $o->flag;
							$x_grp_no = $o->f_grp_no;
	
     $q = "Update region_master set v_name = '$region_name',imo_no = '$x_imo',flag = '$x_flag',f_grp_no = '$x_grp_no' where r_id = '$txtid'";
		//echo $q; exit();
		$r = RunQry($q);
		
		if($r)
			{
				echo "<script type='text/javascript'>
					alert('SHIP UPDATE successfully');
					</script>";
			}
			else
			{
				echo "<script type='text/javascript'>
					alert('Error in updating Region type');
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
	<style>
		#para1{
			text-transform: uppercase;
		}
	</style>
  
<?php include('_menu.php');?>
	
		 <div id="row_wrap">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
				<div class="col-sm-5">
				
				
				
				<input type="hidden" name="mode" id="mode" value="I">
				
		 <div id="row_wrap">
			<div class="row"> 
				<div class="col-sm-8"> 	
					<div class="form-group">
						<label>SHIP NAME:</label>
						<input type="text"  class="form-control" id="para1" name="v_name" value="" placeholder="SHIP NAME."  required />
					</div>
				
				<br>
				
				<div class="form-group">
						<label>IMO No:</label>
						<input type="text" class="form-control" id="para2" name="imo_no" value="" placeholder="IMO No" required />
					</div> 
			
				<br>
				<div class="form-group">
				FLAG: <select name="flag" required>
					<option></option>
    	<option value="GERMANY">GERMANY</option>
	    <option value="FRANCE">FRANCE</option>
	    <option value="SINGAPORE">SINGAPORE</option>
	    <option value="LIBERIA">LIBERIA</option>
	</select><br>
				
				
		
				
				
				</div>
			
			<br>
			
				
				<div class="form-group">
						<label> FLAG GROUP NO:</label>
						<input type="text" class="form-control" id="para4" name="f_grp_no" value="" placeholder=" " required />
					<input type="submit"  name="submit" value="Save" >  
				
        <button><a href="<?php echo $disp_url ?>" > Cancel </a></button>
				</div>
				
          
       
	
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