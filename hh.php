<?php
include('dynamic.php');

 function convert_day_to_YMD($convert)
     {
     			
   // $convert = '5000'; // days you want to convert

		$years = ($convert / 365) ; // days / 365 days
		$years = floor($years); // Remove all decimals

		$month = ($convert % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
		$month = floor($month); // Remove all decimals

		$days = ($convert % 365) % 30.5; // the rest of days

		// Echo all information set
		//echo 'DAYS RECEIVE : '.$convert.' days<br>';
		$str="";
		if($years>0)
		{
			$str.= "$years years - ";
		}
		if($month>0)
		{
			$str.= "$month months - ";
		}
		$str.=$days.' days';
echo $str;
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  
  <script language="JavaScript" type="text/javascript">


		</script>
  
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	 $('#tb_id,#tb_id1,#tb_id2').DataTable({
		 "pageLength": 5,
		"lengthChange": false,
		"pagingType": 'simple'
	 });
	//runEffect("#effect","bounce")
});	
</script>
  <?php include('_menu.php');?>


	
		 <div id="row_wrap">
		 
		<!--  <div class="col-sm-12 no_border" style="padding-bottom:0%;margin-bottom:0%;">
		 <H2><CENTER>COMING SOON</CENTER></H2>
		 </div> -->
		 
		 <div class="col-sm-12 no_border" style="padding-bottom:0%;margin-bottom:0%;">
		
		
		
			
		 	</div>
		 	<div class="col-sm-5">
		 			<h4>UpComing Removable Date for Next Sevan Days</h4>
					<table border="0"  id="tb_id"  cellpadding="3" cellspacing="3" style="background:#!important;border-radius:5px;" width="100%" >
						<thead>
							
						
		<tr >
			<th align="center"><b>SHIP NAME </b></th>
			<th align="center"><b>removable date </b></th>
			<th align="center"><b></b></th>
		</tr>
	</thead>
	<tbody>
		<?php
			
				;
				while ($row=mysqli_fetch_row($res)) {
					if(($row[2]>=-7)&&($row[2]<=0))
					{
						echo"<tr>
						
						<td align='center'>$row[1]</td>
						<td align='center'>".-$row[2]."</td>
					</tr>";
					}
					
				}
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