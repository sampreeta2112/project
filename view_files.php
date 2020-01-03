<?php
include('dynamic.php');

$disp_url = "view_files.php";
$edit_url = "DE_home.php";


$cond="";
$url_str="";

if(isset($_GET["file_no"])) $file_no = $_GET["file_no"];
elseif(isset($_POST["file_no"])) $file_no = $_POST["file_no"];
else $file_no = '';

if(isset($_GET["file_name"])) $file_name = $_GET["file_name"];
elseif(isset($_POST["file_name"])) $file_name = $_POST["file_name"];
else $file_name = '';

if(isset($_GET["file_desc"])) $file_desc = $_GET["file_desc"];
elseif(isset($_POST["file_desc"])) $file_desc = $_POST["file_desc"];
else $file_desc = '';

if(isset($_GET["inward_date"])) $inward_date = $_GET["inward_date"];
elseif(isset($_POST["inward_date"])) $inward_date = $_POST["inward_date"];
else $inward_date = '';

if(isset($_GET["closed_date"])) $closed_date = $_GET["closed_date"];
elseif(isset($_POST["closed_date"])) $closed_date = $_POST["closed_date"];
else $closed_date = '';



if($file_no!='')
{
	$url_str.="&file_no=$file_no";
    $cond.=" and file_no like '%$file_no%' ";
	$flag = true;
}

if($file_name!='')
{
	$url_str.="&file_name=$file_name";
    $cond.=" and file_name like '%$file_name%' ";
	$flag = true;
}

if($file_desc!='')
{
	$url_str.="&file_desc=$file_desc";
    $cond.=" and file_description like '%$file_desc%' ";
	$flag = true;
}

if($inward_date!='')
{
	$url_str.="&inward_date=$inward_date";
    $cond.=" and inward_date like '%$inward_date%' ";
	$flag = true;
}
if($closed_date!='')
{
	$url_str.="&closed_date=$closed_date";
    $cond.=" and closed_date like '%$closed_date%' ";
	$flag = true;
}


$_SESSION[SES_ADMIN]->inv_url_str=$url_str;
$_SESSION[SES_ADMIN]->inv_cond=$cond;

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
	$count=GetSingleValue("select count(*) from file_records  where 1 $cond");
	$pagination=GetPagination($page,$count,$disp_url,$url_str);
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
	
  
  
 
	</script>

		<?php include('_menu.php');?>

	<div id="row_wrap">
			<div class="col-sm-15" id="outer">
				
				<div class="col-sm-4" style = "height:110px" id="searchbox" >
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
              	
					<h5>FILTER BY</h5>
			SHOW ALL<input type="checkbox" name="" value="">
			SHIP NAME:<input type="text" name="vname"style="width:180px" ><br>
			IMO No:  <input type="text" name="imo_no" style="width:80px">
			FLEET GROUP NO: <input type="text" name="" style="width:80px">
		</div>
		
	  		
				
				
				<div class="col-lg-4"   id="searchbox" style = "height:110px" >
					
					Select All &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
		 		Asbestors &nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
			 	PCB  <input type="radio" name="" value=""> 
			 	
				ODS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> <br>
			
			
				Anti Fouling &nbsp;&nbsp;<input type="radio" name="" value=""> 
			  	PFOs &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
			  	Cd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value="">   
				
				Cr6+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> <br>  
			
				Pb&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value="">  
			  	Hg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
			 		PBBS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value="">   
			  	PBCEDEs&nbsp;&nbsp;&nbsp;<input type="radio" name="" value="">  
		
			  PCNs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> <br>  
			  	
			  	HBCCD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
			  	Radioactive <input type="radio" name="" value=""> 
				 Sccps&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value="">
				
</div>
					
			
	  		 </div>
	  		
				  <div class="col-lg-2" style = "height:110px" id="searchbox" > 
                <input type="submit" id="textbox" name=""  value="Search">
				<input type="button" id="textbox" name="" value="Reset" onClick="window.location.assign('<?php echo $disp_url ?>')">
				</div>
				
                </form>
                </div>
				</div>
				
		 
              
					
					
				
				<div class="row">
					<div class="col-sm-11 list_div">
					 
					  
					  <div class="col-sm-19" style="overflow-y:scroll;height:400px;">
					  <button type="button" class="btn btn-default btn-sm" style="margin-left: 1290px;">
          <span class="glyphicon glyphicon-print"></span> 
        </button>
						<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							<th>sr no</th>
   			<th>SHIP NAME</th>
    		<th>IMO No</th> 
    		<th>FLAG</th>
			<th>FLEET GROUP NO</th>
    		<th>Hazmat Survey Date</th>  
    		<th>Next Survey</th> 
    		<th>Next Removal</th> 
    		<th>Port of Removal </th> 
    		<th>Yard Entry Date</th> 
    		<th>Yard Location</th> 
    		<th>Cummilative Hazmat Found</th> 
    		<th>cummilative Remove</th> 
    		<th>Outstanding</th> 
    		<th>Asbestors</th> 
    		<th>PCB</th> 
    		<th>ODS</th> 
    		<th>Anti Fouling</th> 
    		<th>Cd</th> 
    		<th>PFOs</th> 
			<th>Cr6+</th> 
			<th>Pb</th> 
			<th>Hg</th> 
			<th>PBBS</th> 
			<th>PBCEDEs</th> 
			<th>PCNs</th> 
			<th>Radioactive Sccps</th> 
			<th>HBCCD</th>
		
			<th width="5%">Edit</th>
							<th width="5%">delete</th>
							 
							  </th>
							
							</tr>
						  </thead>
						  <tbody>
							<?php
					$q = "";
				
							//if($cond!='')
							{
								$q = "create view filesreport select a.file_id, a.survey_date,a.expert_co,a.removed_date,a.removed_comp,a.location,a.items_detail,a.report_no,a.check_pt,a.anti_fouling, b.v_name,b.imo_no,b.flag,b.f_grp_no FROM region_master b INNER JOIN file_records a ON a.file_id = b.file_id where 1";
							
							}
							//echo $q;
							$r = RunQry($q);
					//if($cond!='')
					
					//echo $q;
				
					$numrow = mysqli_num_rows($r);
					$i = 1;
					if($numrow)
					{	
						for($i=1; $o = mysqli_fetch_object($r); $i++) 
						{		
							$file_id=$o->file_id;
							$x_name = $o->v_name;
							$x_imo = $o->imo_no;
							$x_flag = $o->flag;
							$x_grp_no = $o->f_grp_no;
							$survey_date=$o->survey_date;
								$expert_co=$o->expert_co;
	$removed_date=$o->removed_date;
	$removed_comp=$o->removed_comp;
	$location=$o->location;
	$s_location=$o->s_location;
	$items_detail=$o->items_detail;
	$remark=$o->remark;
	$report_no=$o->report_no;
	$check_pt=$o->check_pt;
	$n_removed=$o->n_removed;
	$n_ship=$o->n_ship;
	$asbestos=$o->asbestos;
	$pcb=$o->pcb;
	$anti_fouling=$o->anti_fouling;
	$pfos=$o->pfos;
	$cd=$o->cd;
	$cr6=$o->cr6;
	$pb=$o->pb;
	$hg=$o->hg;
	$pbbs=$o->pbbs;
	$pbedes=$o->pbedes;
	$pcns=$o->pcns;
	$radioactive=$o->radioactive;
	$sccps=$o->sccps;
	$hbccd=$o->hbccd;	
						 
					
							
				?>
							
								<tr>
									
								<td><?php echo $i; ?></td>
								 <td><?php echo $x_name; ?></td>
							  
							<td><?php echo$x_imo; ?></td>
							<td><?php echo $x_flag; ?></td>
							<td><?php echo $x_grp_no; ?></td>
								<td><?php echo $survey_date;?></td>
								<td><?php echo $expert_co;?></td></td>
								<td><?php echo $removed_date;?></td></td>
								<td><?php echo $removed_comp;?></td></td>
								<td><?php echo $location;?></td></td>
								<td><?php echo $s_location;?></td></td>
								<td><?php echo $items_detail;?></td></td>
								<td><?php echo $remark;?></td></td>
								<td><?php echo $report;?></td></td>
								<td><?php echo $check_pt;?></td></td>
								<td><?php echo $n_removed;?></td></td>
								<td><?php echo $n_ship;?></td></td>
								<td><?php echo $asbestos;?></td></td>
								<td><?php echo $pcb;?></td></td>
								<td><?php echo $anti_fouling;?></td></td>
								<td><?php echo $pfos;?></td></td>
								<td><?php echo $cd;?></td></td>
								<td><?php echo $cr6;?></td></td>
								<td><?php echo $pb;?></td></td>
								<td><?php echo $hg;?></td></td>
								<td><?php echo $pbbs;?></td></td>
								<td><?php echo $pbedes;?></td></td>
								<td><?php echo $pcns;?></td></td>
								<td><?php echo $radioactive;?></td></td>
								<td><?php echo $sccps;?></td></td>
								<td><?php echo $hbccd;?></td></td>
							<td><?php echo"<a href='update_file_details.php?id=$file_id&file_name=$file_no'>". IMG_EDIT."</a>";?></td>
							     <td><a href="<?php echo $edit_url; ?>?mode=D&id=<?php echo $x_id; ?>" title="Delete"><?php echo IMG_DELETE;?></a></td> 
							     </tr>
							<?php
								
						}
						echo '<input type="hidden" id="count" value="'.$i.'"/>';
					}
					else
						echo "<tr><> </td></tr>";
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