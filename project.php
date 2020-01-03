<?php
include('dynamic.php');

$disp_url = "project.php";
$edit_url = "project_edit.php";

$cond=" ";
$url_str="";

if(isset($_GET["name"])) $txtname = $_GET["name"];
elseif(isset($_POST["txtname"])) $txtname = $_POST["txtname"];
else $txtname = '';

if($txtname!='')
{
	$url_str.="&name=$txtname";
	$txtname1 = addslashes($txtname);
    $cond.=" and pro_name like '%$txtname1%' ";
	$flag = true;
}

$_SESSION[SES_ADMIN]->item_master_url_str=$url_str;
$_SESSION[SES_ADMIN]->item_master_cond=$cond;

$page = 1;
if((isset($_GET['page']))) 
{
	$page =$_GET['page'];
	$start = ($page - 1) * PAGE_LIMIT; 		//first item to display on this page
	
}
else
	$start = 0;	

$count=GetSingleValue("select count(*) from project_master where 1 $cond");
$pagination=GetPagination($page,$count,$disp_url,$url_str);

$opr='"';
$subcat_arr=GetArray("Select concat('$opr',pro_name,'$opr') as name from project_master where 1 ",2);
$subcat_str=implode(",",$subcat_arr);

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
      <?php echo $subcat_str; ?>
    ]; 
    $( "#txtname" ).autocomplete({
      source: availableatype
    });
  });
  
 
	</script>

		<?php include('_menu.php');?>

	
		 <div id="row_wrap">
			<div class="col-sm-12" id="outer">
				<div class="row">
				<div class="col-sm-11" id="searchbox">
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
                <label for="txtname">Project name :</label>
                <input type="text" name="txtname" id="txtname" value="<?php echo $txtname;?>">
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           
                &nbsp;
				<div id="div-right" style = "padding-right:3%">
                <input type="submit" name="btn_submit" id="btn_submit" value="Search">
				</div>
                </form>
                </div>
				</div>
				
				<div class="row">
					<div class="col-sm-11" style="overflow-y:scroll;height:400px;">
					  <h3>Projects <a  href="<?php echo $edit_url;?>"><?php echo IMG_ADD ?></a></h3>
					  
						<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							  <th width="5%">Sr.no</th>
							  <th >Name</th>
							  <th width="15%">Client </th>
							 
							  <th width="5%">Edit</th>
							</tr>
						  </thead>
						  <tbody>
							<?php
					 $q = "select * from project_master where 1 $cond order by pro_name LIMIT $start, ".PAGE_LIMIT;
					//echo $q;
					$r = RunQry($q);
					$numrow = mysqli_num_rows($r);
					$i = 1;
					if($numrow)
					{	
						for($i=1; $o = mysqli_fetch_object($r); $i++) 
						{		
							$x_id = $o->pro_id;
							$x_name = $o->pro_name;
						
							$x_cat_id = $o->client_id;
							$x_catname = GetSingleValue("SELECT client_name FROM `client_master` where client_id=$x_cat_id");
				?>
							<tr>
							  <td><?php echo $i; ?></td>
							  <td><?php echo $x_name; ?></td>
							  <td><?php echo $x_catname; ?></td>
							
							  <td><a href="<?php echo $edit_url; ?>?mode=E&id=<?php echo $x_id; ?>" title="Edit"><?php echo IMG_EDIT;?></a></td>
							</tr>
							<?php
								
						}
						
						echo '<input type="hidden" id="count" value="'.$i.'"/>';
					}
					else
						echo "<tr><td colspan='11'> No record found...</td></tr>";
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