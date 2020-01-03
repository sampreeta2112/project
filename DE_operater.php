<?php
include('dynamic.php');

$disp_url = "DE_operater.php";
$edit_url = "DE_operater_edit.php";

$sms_template = "";
$subject='';

$cond=" and cStatus='A'";
$url_str="";

if(isset($_GET["name"])) $txtname = $_GET["name"];
elseif(isset($_POST["txtname"])) $txtname = $_POST["txtname"];
else $txtname = '';


if(isset($_GET["region"])) $txtregion = $_GET["region"];
elseif(isset($_POST["txtregion"])) $txtregion = $_POST["txtregion"];
else $txtregion = '';

if($txtname!='')
{
	$url_str.="&name=$txtname";
	$txtname1 = addslashes($txtname);
    $cond.=" and name like '%$txtname1%' ";
	$flag = true;
}



if($txtregion!='')
{
	$url_str.="&region=$txtregion";
    $cond.=" and r_id = '$txtregion' ";
	$flag = true;
}

$_SESSION[SES_ADMIN]->client_url_str=$url_str;
$_SESSION[SES_ADMIN]->client_cond=$cond;

$page = 1;
if((isset($_GET['page']))) 
{
	$page =$_GET['page'];
	$start = ($page - 1) * PAGE_LIMIT; 		//first item to display on this page
	
}
else
	$start = 0;	

//if($cond!='')
{
	$count=GetSingleValue("select count(*) from user_table  where 1 $cond and user_type='DE'");
	$pagination=GetPagination($page,$count,$disp_url,$url_str);
}


$opr='"';
$client_arr=GetArray("Select concat('$opr',name,'$opr') as name from user_table where 1 ",2);
$client_str=implode(",",$client_arr);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<html lang="en">
<head>
<?php include('_header.php'); ?>
  <script src="../js1.3/script.js"></script>
  <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="../ckeditor/sample.js"></script>
  <script type="text/javascript">
	$(function() {
    var availableatype = [
      <?php echo $client_str; ?>
    ]; 
    $( "#txtname" ).autocomplete({
      source: availableatype
    });
  });
	
	$(document).ready(function(){
		 initSample();
		$('.fancybox').fancybox({
			 afterClose: function() {
				 location.reload();
			 }
		});
	});
  
 
	</script>

		<?php include('_menu.php');?>

	
		 <div id="row_wrap">
			<div class="col-sm-12" id="outer">
				<div class="row">
				<div class="col-sm-11" id="searchbox">
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
                <label for="txtname"> USER Name :</label>
                <input type="text" name="txtname" id="txtname" value="<?php echo $txtname;?>">
              
				&nbsp;&nbsp;&nbsp;
				 
				&nbsp;&nbsp;&nbsp;
				<label>FLAG:</label>
						<Select class="form-control" name="txtregion" id="txtregion" />
						<option value="">Select</option>
					
						<option value="">GERMANY</option>
						<option value="">FRANCES</option>
						<option value="">SINGOPORE</option>
							<option value="">LIBERIA</option>
						<?php
						foreach($region_arr as $region_id => $region_val)
						{
							?>
							<option value="<?php echo $region_id ?>" <?php if($region_id==$txtregion) echo "selected" ?> ><?php echo $region_val ?></option>
							<?php
						}
						?>
						</select>
						 <label for="txtname">FLEET:</label>
                <input type="text" name="txtname" id="txtname" value="<?php echo $txtname;?>">
						
				<div id="div-right" style = "padding-right:3%">
                <input type="submit" name="btn_submit" id="btn_submit" value="Search">
				<input type="button" name="btn_reset" value="Reset" onClick="window.location.assign('<?php echo $disp_url ?>')">
				</div>
                </form>
                </div>
				</div>
				
				<div class="row">
					<div class="col-sm-11 list_div">
					  <h3>USER manager <a  href="<?php echo $edit_url;?>"><?php echo IMG_ADD ?></a></h3>
					  
						<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							
							  <th width="5%">Sr.no</th>
							  <th >flag Name</th>
							 
							  <th >ships Details</th>
							
							  <th width="5%">Edit</th>
							
						
							  </th>
							</tr>
						  </thead>
						  <tbody>
							<?php
							$q = "";
					//if($cond!='')
					{
						$q = "select * from user_table  where 1 $cond and user_type='DE' order by name LIMIT $start, ".PAGE_LIMIT;
					}
					//echo $q;
					$r = RunQry($q);
					$numrow = mysqli_num_rows($r);
					$i = 1;
					if($numrow)
					{	
						for($i=1; $o = mysqli_fetch_object($r); $i++) 
						{		
							$x_id = $o->user_id;
							$x_name = $o->name;
							$x_email_id = $o->email_id;
							$x_phno = $o->phno."<br>";
				?>
							<tr>
							
							  <td><?php echo $i; ?></td>
							  <td><?php echo $x_name; ?></td>
							 <td></td>
							 
							  <td><a href="<?php echo $edit_url; ?>?mode=E&id=<?php echo $x_id; ?>" title="Edit"><?php echo IMG_EDIT;?></a></td>
							
							</tr>
							<?php
								
						}
						echo '<input type="hidden" id="count" value="'.$i.'"/>';
					}
					else
						echo "<tr><td colspan='5'> No record found...</td></tr>";
				?>
						  </tbody>
						</table>
					  <div align="right"><?php echo $pagination;?></div>
					  
					</div>
				</div>

  
	</div>
  </div>
  </div>
  </div>
  
  
 <?php include('_footer.php'); ?>
  

  
</div>


</body>
</html>