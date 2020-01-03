<?php
include('dynamic.php');

$disp_url = "region.php";
$edit_url = "region_edit.php";


$cond=" ";
$url_str="";

if(isset($_GET["name"])) $txtname = $_GET["name"];
elseif(isset($_POST["txtname"])) $txtname = $_POST["txtname"];
else $txtname = '';

if($txtname!='')
{
	$url_str.="&name=$txtname";
	$txtname1 = addslashes($txtname);
    $cond.=" and r_name like '%$txtname1%' ";
	$flag = true;
}

$_SESSION[SES_ADMIN]->region_url_str=$url_str;
$_SESSION[SES_ADMIN]->region_cond=$cond;

$page = 1;
if((isset($_GET['page']))) 
{
	$page =$_GET['page'];
	$start = ($page - 1) * PAGE_LIMIT; 		//first item to display on this page
	
}
else
	$start = 0;	

$count=GetSingleValue("select count(*) from region_master  where 1 $cond");
$pagination=GetPagination($page,$count,$disp_url,$url_str);

$opr='"';
$region_arr=GetArray("Select concat('$opr',r_name,'$opr') as name from region_master where 1 ",2);
$region_str=implode(",",$region_arr);



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

		<?php include('_menu.php');?>
<body style="overflow-y:scroll;height:400px;">
	
		 <div id="row_wrap">
			<div class="col-sm-12" id="outer">
				<div class="row">
				<div class="col-sm-11" id="searchbox">
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
                <label for="txtname">EXPERT COMPANY:</label>
                <input type="text" name="txtname" id="txtname" value="<?php echo $txtname;?>">
                 &nbsp;&nbsp;&nbsp;&nbsp;
                
				
                <input type="submit" name="btn_submit" id="btn_submit" value="Search">
				
                </form>
                </div>
				</div>
				
				<div class="row">
					<div class="col-sm-11">
					  <h3>EXPERT COMPANY   <a  href="<?php echo $edit_url;?>"><?php echo IMG_ADD ?></a></h3>
					  
						<table width="70%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							 <th width="2%">Sr.No</th>
							  <th width="5%">EXPERT COMPANY</th>
							  
							 
								<th width="2%">Edit</th>
							<th width="2%">Delete</th>
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
							$x_name = $o->r_name;
				?>
							<tr>
							  <td><CENTER><?php echo $i; ?></CENTER></td>
							  <td><CENTER><?php echo $x_name; ?></CENTER></td>
							  
							
							<td><CENTER><a href="<?php echo $edit_url; ?>?mode=E&id=<?php echo $x_id; ?>" title="Edit"><?php echo IMG_EDIT;?></a></CENTER></td>	
							<td><CENTER><a href="<?php echo $edit_url; ?>?mode=D&id=<?php echo $x_id; ?>" title="Delete"><?php echo IMG_DELETE;?></a></CENTER></td> 
							     
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