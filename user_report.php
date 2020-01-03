<?php
include('dynamic.php');

$disp_url = "user_report.php";
$export_url = "project_inv_exp.php";


$cond="";

$url_str="";

if(isset($_GET["project_id"]))
{
	 $txtproject_id = $_GET["project_id"];
}
elseif(isset($_POST["txtproject_id"])) 
	{
		$txtproject_id = $_POST["txtproject_id"];
		$txtproject_nm= $_POST["txtproject_nm"];
	}
else 
	{
		$txtproject_id='';
$txtproject_nm='';
}
if(isset($_GET["from"])) $txtfrom = $_GET["from"];
elseif(isset($_POST["txtfrom"])) $txtfrom = $_POST["txtfrom"];
else $txtfrom = Changedateformat(LASTMONTH_YMD);

if(isset($_GET["to"])) $txtto = $_GET["to"];
elseif(isset($_POST["txtto"])) $txtto = $_POST["txtto"];
else $txtto = Changedateformat(LASTDATE_YMD);

if($txtproject_id!='')
{
	$url_str.="&project_id=$txtproject_id";
    $cond.=" AND a.user_id='$txtproject_id' ";
   
	//$txtproject_nm=Getsinglevalue("select prj_name from projects where prj_id = $txtproject_id");
	$flag = true;
}



$_SESSION[SES_ADMIN]->project_sts_rep_url_str=$url_str;
$_SESSION[SES_ADMIN]->project_sts_rep_cond=$cond;

$page = 1;
if((isset($_GET['page']))) 
{
	$page =$_GET['page'];
	$start = ($page - 1) * PAGE_LIMIT; 		//first item to display on this page
	
}
else
	$start = 0;	

if($cond!='')
{
	//$count=GetSingleValue("select count(*) from daily_status  where 1 $cond");
	$pagination=""; //GetPagination($page,$count,$disp_url,$url_str);
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
  <script src="../js1.3/autocomplete_operator.js"></script>
  <script language="JavaScript" type="text/javascript">
  $(document).ready(function(){
	  
		$( ".datepicker" ).datepicker({
			dateFormat:"dd-mm-yy",
			onSelect:function(){
				txtfrom=$("#txtfrom").datepicker('getDate');
				txtto=$("#txtto").datepicker('getDate');
				flag=0;
				disp_msg='';
				console.log(txtfrom+"=>"+txtto);
				if(txtfrom>txtto) { flag=1; disp_msg+="date ";}
				 if(flag==1)
				 {
					 //console.log(flag);
					 disp_msg=disp_msg.split(" ");
					 alert("Please enter proper range for "+disp_msg);
					 $("#btn_submit").addClass("disable_elements");
				 }
				 else
				 {
					 $("#btn_submit").removeClass("disable_elements");
				 }
			}
		});
		
		
		
  });
  
  
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
			 	PCB  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="" value=""> 
			 	
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
					<div class="col-sm-11" style="overflow-y:scroll;height:400px;">
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
						  							$q = " create view regionreport as select a.file_id, a.survey_date,a.expert_co,a.removed_date,a.removed_comp,a.location,a.items_detail,a.report_no,a.check_pt,a.anti_fouling, b.v_name,b.imo_no,b.flag,b.f_grp_no FROM region_master b INNER JOIN log_table a ON a.user_id = b.user_id INNER JOIN attachments c ON a.file_id = c.file_id WHERE 1 and log_type='INSERT' $ ";

						  
							//$q = "create view userreport as SELECT a.file_id, a.user_id, b.name,  AS upload_date FROM user_table b INNER JOIN log_table a ON a.user_id = b.user_id INNER JOIN attachments c ON a.file_id = c.file_id WHERE 1 and log_type='INSERT' $cond  GROUP BY a.file_id";
							 //echo$q;
							$r = RunQry($q);
							$reportq="SELECT COALESCE(COUNT(user_id),0) as files,COALESCE(sum(attachments),0) as attachments,upload_date FROM userreport where user_id in (SELECT DISTINCT user_id from userreport) GROUP by upload_date";
							$rp=mysqli_query($link,$reportq);
							
							$numrow = mysqli_num_rows($rp);
							$i1 = 1;
							if($numrow)
							{	
								for($i=1; $o = mysqli_fetch_object($rp); $i++) 
								{	
								//print_r($o);	
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
			<td><CENTER><a href="<?php echo $edit_url; ?>?mode=E&id=<?php echo $x_id; ?>" title="Edit"><?php echo IMG_EDIT;?></a></CENTER></td>
							  <td><CENTER><a href="<?php echo $edit_url; ?>?mode=D&id=<?php echo $x_id; ?>" title="Delete"><?php echo IMG_DELETE;?></a></CENTER></td> 	
						
							      
							</tr>
									 
								
									<?php
								}
							}
							mysqli_query($link,"drop view userreport");
							?>
						  </tbody>
						</table>
					  
					  
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