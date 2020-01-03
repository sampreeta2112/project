<?php
include('dynamic.php');

$disp_url = "region_report.php";
$export_url = "project_inv_exp.php";

$region_id="0";
$txtregion="";
$cond="";
$cond="";


if(isset($_GET["v_name"])) $v_name = $_GET["v_name"];
elseif(isset($_POST["v_name"])) $v_name = $_POST["v_name"];
else $v_name = '';

if(isset($_GET["imo_no"])) $imo_no = $_GET["imo_no"];
elseif(isset($_POST["imo_no"])) $imo_no = $_POST["imo_no"];
else $imo_no = '';

if(isset($_GET["f_grp_no"])) $f_grp_no = $_GET["f_grp_no"];
elseif(isset($_POST["f_grp_no"])) $f_grp_no = $_POST["f_grp_no"];
else $f_grp_no = '';




if($v_name!='')
{
	$url_str.="&v_name=$v_name";
    $cond.=" and b.v_name like '%$v_name%' ";
	$flag = true;
}

if($imo_no!='')
{
	$url_str.="&imo_no=$imo_no";
    $cond.=" and b.imo_no like '%$imo_no%' ";
	$flag = true;
}

if($f_grp_no!='')
{
	$url_str.="&f_grp_no=$f_grp_no";
    $cond.=" and b.f_grp_no like '%$f_grp_no%' ";
	$flag = true;
}

if(isset($_GET["Asbestos"]))
{
	$cond .= "asbestos != ''";
}
if(isset($_GET["PCB"]))
{
	$cond .= "pcb != ''";
}
if(isset($_GET["ODS"]))
{
	$cond .= "ods != ''";
}
if(isset($_GET["Hg"]))
{
	$cond .= "Hg != ''";
}
if(isset($_GET["Anti_Fouling"]))
{
	$cond .= "anti_fouling != ''";
}
if(isset($_GET["PFOs"]))
{
	$cond .= "pfos != ''";
}
if(isset($_GET["Cd"]))
{
	$cond .= "cd != ''";
}
if(isset($_GET["PBBS"]))
{
	$cond .= "pbbs != ''";
}
if(isset($_GET["Sccps"]))
{
	$cond .= "sccps != ''";
}
if(isset($_GET["Cr6"]))
{
	$cond .= "cr6 != ''";
}
if(isset($_GET["Pb"]))
{
	$cond .= "pb != ''";
}
if(isset($_GET["PBCEDEs"]))
{
	$cond .= "pbedes != ''";
}
if(isset($_GET["PCNs"]))
{
	$cond .= "pcns != ''";
}
if(isset($_GET["HBCCD"]))
{
	$cond .= "hbccd != ''";
}
if(isset($_GET["Radioactive"]))
{
	$cond .= "radioactive != ''";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	#textbox{
		width: 140px;
	}
	#left {
            margin-left: 50px;
        }
        #textbox1{
		
		margin-left: 20px;
	}
	#top{
	    margin-top:10px;
	}
</style>
<style>
		#para1{
			text-transform: uppercase;
		}
	</style>
<style>
      .rotate_text
      {
         -moz-transform:rotate(-90deg); 
         -moz-transform-origin: top left;
         -webkit-transform: rotate(-90deg);
         -webkit-transform-origin: top left;
         -o-transform: rotate(-90deg);
         -o-transform-origin:  top left;
          position:relative;
         top:20px;
      }
   </style>
<!--<![endif]-->

   <style>  
      table
      {
         border: 1px solid black;
         table-layout:fixed;
        /*Table width must be set or it wont resize the cells*/
      }
     
      #tb{
      	width: 28px;
      }
      #tb1{
      	width: 100px;
      }
      #tb2{
          width: 60px;
      }
   
    
      .rotated_cell
      {
      	width:100px;
         height:150px;
         vertical-align:bottom;
      }
   </style>
</head>
<?php include('_header.php'); ?>
  <script src="../js1.3/script.js"></script>

  <script type="text/javascript">
	
  
  
 
	</script>


		<?php include('_menu.php');?>

	
		 <div id="row_wrap" >
			<div class="col-sm-15" id="outer">
				
				<div class="col-sm-4" style = "height:110px" id="searchbox" >
                <form method="post" name="frm_search" action="<?php echo $disp_url?>">
              	
					<h5>FILTER BY</h5>
			SHOW ALL<input type="checkbox" name="" value="">
			SHIP NAME:<input type="text" name="vname" value="<?php echo $v_name;?>" id="para1" style="width:180px" ><br>
			
               
			IMO No:  <input type="text" name="imono"  value="<?php echo $imo_no;?>" style="width:80px">
			FLEET GROUP NO: <input type="text" name="fgrpno"  value="<?php echo $f_grp_no;?>" style="width:80px">
		</div>
		
	  		
				
			  	
<div class="col-sm-4" id="" style="width: 500px; height: 120px; margin-left: 20px; ">

	  	   <div class="col-sm-9" id="" style="width: 550px; height: 80px; margin-top: 10px; ">
  <input type="checkbox" name="items" id="selectitem" value="" onclick="checkAll();"> Select All <br>
    <input type="checkbox" name="items" value="Asbestos" class="first">Asbestos
    <input type="checkbox" name="items"  id="left"  value="PCB" class="first">PCB
    <input type="checkbox" name="items"  id="left"  value="ODS" class="first">ODS 
  <input type="checkbox" name="items"   id="left"  value="Hg" class="first"> PCNs 
   <input type="checkbox" name="items" value="Cd" class="first" style="margin-left: 30px;">HBCCD<br>  

  <input type="checkbox" name="items" value="Anti_Fouling" class="first" > Anti Fouling
   <input type="checkbox" name="items" value="PFOs" class="first" style="margin-left: 16px;"> PFOs
  <input type="checkbox" name="items" value="Pb" class="first" style="margin-left: 30px;" >  Pb
  <input type="checkbox" name="items" value="Cr6+" class="first" style="margin-left: 47px;" > Cr6+
   <input type="checkbox" name="items" value="PBBS" class="first" style="margin-left: 33px;">PBBS <br> 
  <input type="checkbox" name="items" value="Sccps" class="first" > Radioactive
  
 
  <input type="checkbox" name="items" value="PBCEDEs" class="first" style="margin-left: 18px;"> PBCEDEs
  <input type="checkbox" name="items" value="PCNs" class="first" style="margin-left: 3px;"> Hg
  <input type="checkbox" name="items" value="HBCCD" class="first" style="margin-left: 46px;"> Cd
   <input type="checkbox" name="items" value="Radioactive" class="first"style="margin-left: 48px;"> Sccps<br> 
   </div>

				

				</div>
				

				</div>
					
			
	  		 </div>
	  		
				  <div class="col-lg-2" id="searchbox" style = "height:110px; margin-left: 40px;" > 
                <input type="submit" id="textbox" name=""  value="Search">
				<input type="button" id="textbox" name="" value="Reset" onClick="window.location.assign('<?php echo $disp_url ?>')">
				</div>
				
                </form>
         	
               
				</div>
			
					 <button type="button" class="btn btn-default btn-sm" style="margin-left: 1080px; margin-top: 20px;">
          		<span class="glyphicon glyphicon-print"></span> Print
        	</button>
		
				<div class="row">
					<div class="col-sm-11 list_div" style=" overflow: scroll;">
					
					

         
					  <div>
						<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="tbl-cont" >
						  <thead>
							<tr>
							    
							
							<th id="tb">No</th>
   			<th id="tb1" >SHIP NAME</th>
    		<th id="tb1">IMO No</th> 
    		<th id="tb1">FLAG</th>
			<th id="tb1" >FLEET GROUP NO</th>
    		<th class='rotated_cell'  id="tb2"><div class='rotate_text'>Hazmat Survey Date</div></th>  
    		<th id="tb1">Next Survey</th> 
    		<th id="tb1">Next Removal</th> 
    		<th id="tb1">Port of Removal </th> 
    		<th id="tb1">Yard Entry Date</th> 
    		<th id="tb1">Yard Location</th> 
    		<th class='rotated_cell' id="tb2"><div class='rotate_text'>Cummilative Hazmat Found</div></th> 
    		<th class='rotated_cell' id="tb2"><div class='rotate_text'>cummilative Removed</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>Outstanding</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>Asbestos</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>PCB</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>ODS</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>Anti Fouling</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>Cd</div></th> 
    		<th class='rotated_cell' id="tb"><div class='rotate_text'>PFOs</div></div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>Cr6+</div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>Pb</div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>Hg</div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>PBBS</div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>PBCEDEs</div></th> 
			<th class='rotated_cell' id="tb"><div class='rotate_text'>PCNs</div></th> 
			<th class='rotated_cell' id="tb"> <div class='rotate_text'>Radioactive</div></th>
				<th class='rotated_cell' id="tb"> <div class='rotate_text'> Sccps</div></th> 
			<th class='rotated_cell' id="tb">
			    <div class='rotate_text'>HBCCD</div></th>
		
			
							  
							</tr>
								
	
	
							
						  </thead>
						  <tbody>
							  
						  <?php
						  
						 
						  
						$q = "  select * from region_master b inner join file_records a on a.file_id=b.file_id  where  a.file_id";
							
							$r = RunQry($q);
							$rp=mysqli_query($link,$q);
							
							$numrow = mysqli_num_rows($rp);
							$i1 = 1;
							if($numrow)
							{	
								for($i=1; $o = mysqli_fetch_object($rp); $i++) 
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
							<td></td>
							<td></td>
								<td><?php echo $removed_date;?></td>
								<td><?php echo $removed_comp;?></td>
								 <td><?php  ?></td>
								 <td><?php  ?></td>
								 <td><?php ?></td>
								 <td><?php ?></td>
								 <td><?php ?></td>
								 <td><?php ?></td>
								<td><?php echo $asbestos;?></td></td>
								<td><?php echo $pcb;?></td></td>
								<td><?php echo $ods;?></td></td>
								<td><?php echo $anti_fouling;?></td></td>
								<td><?php echo $cd;?></td></td>
								<td><?php echo $pfos;?></td></td>
								
								<td><?php echo $cr6;?></td></td>
								<td><?php echo $pb;?></td></td>
								<td><?php echo $hg;?></td></td>
								<td><?php echo $pbbs;?></td></td>
								<td><?php echo $pbedes;?></td></td>
								<td><?php echo $pcns;?></td></td>
								<td><?php echo $radioactive;?></td></td>
								<td><?php echo $sccps;?></td></td>
								<td><?php echo $hbccd;?></td></td>
							
								
							      
							</tr>
							
							
					



	
							
							
							
									<?php
								}
							}
							mysqli_query($link,"drop view regionreport");
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