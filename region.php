<?php
include('dynamic.php');

$disp_url = "region.php";
$edit_url = "region_edit.php";


$cond=" ";
$url_str="";

if(isset($_GET["name"])) $txtname = $_GET["name"];
elseif(isset($_POST["vname"])) $txtname = $_POST["vname"];
else $vname = '';

if(isset($_POST["vname"]))
{
	
	$v_name = $_POST["vname"];
	 $cond.="and v_name='$v_name '";
} 

if(isset($_GET["region_id"]))
{
	$region_id = $_GET["region_id"];
	$regionname=GetSingleValue("select v_name from region_master where r_id=$region_id");
} 
elseif(isset($_POST["txtregion"]))
{
	$region_id = $_POST["txtregion"];
	$regionname=GetSingleValue("select v_name from region_master where r_id=$region_id");
} 
else 
{
	$region_id ='0';
	$regionname="ALL";
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
  <script type="text/javascript">
	$(function() {
    var availableatype = [
      <?php echo $region_str; ?>
    ]; 
    $( "#txtname" ).autocomplete({
      source: availableatype
    });
  });
  
 
	</script>
	<style>
		#vname{
			text-transform: uppercase;
		}
	</style>

		<?php include('_menu.php');?>

	
		 <div id="row_wrap">
			<div class="col-sm-12" id="outer">
				<div class="row">
				<div class="col-sm-11" id="searchbox">
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
                <label for="txtname">Search SHIP :</label>
                <input type="text" name="vname" id="vname"  value="<?php echo $v_name;?>">
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
						 <label for="txtname">FLEET GROUP NO:</label>
                <input type="text" name="txtname" id="txtname" value="<?php echo $txtname;?>">
		   
		   
		   
                &nbsp;
				<div id="div-right" style = "padding-right:3%">
                <input type="submit" name="btn_submit" id="btn_submit" value="Search">
				<input type="button" id="textbox" name="" value="Reset" onClick="window.location.assign('<?php echo $disp_url ?>')">
				</div>
                </form>
                </div>
				</div>
				
				<div class="row">
					<div class="col-sm-11" style="overflow-y:scroll;height:400px;">
					  <h3>ADD SHIP'  <a  href="<?php echo $edit_url;?>"><?php echo IMG_ADD ?></a></h3>
					  
						<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							 <th width="5%">Sr.no</th>
							  <th width="10%">SHIP NAME</th>
							  <th width="12%">IMO NO:</th>
							  <th width="12%">FLAG:</th>
							  <th width="17%">FLEET GROUP NO:</th>
								<th width="5%">Edit</th>
							<th width="5%">delete</th>
							  </th>
							</tr>
						  </thead>
						  <tbody>
							<?php
				  $q = "select * from region_master  where 1 $cond";
					
					//echo $q;
					$r = RunQry($q);
					$numrow = mysqli_num_rows($r);
					$i = 1;
					if($numrow)
					{	
						for($i=1; $o = mysqli_fetch_object($r); $i++) 
						{		
							$x_id = $o->r_id;
							$x_name = $o->v_name;
							$x_imo = $o->imo_no;
							$x_flag = $o->flag;
							$x_grp_no = $o->f_grp_no;
						
							
							
							
				?>
							<tr>
							  <td><?php echo $i; ?></td>
							  <td><?php echo $x_name; ?></td>
							  
							<td><?php echo$x_imo; ?></td>
							<td><?php echo $x_flag; ?></td>
							<td><?php echo $x_grp_no; ?></td>
						<td><a href="<?php echo $edit_url; ?>?mode=E&id=<?php echo $x_id; ?>" title="Edit"><?php echo IMG_EDIT;?></a></td>
							  <td><a href="<?php echo $edit_url; ?>?mode=D&id=<?php echo $x_id; ?>" title="Delete"><?php echo IMG_DELETE;?></a></td>
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