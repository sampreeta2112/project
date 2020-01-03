<?php

include('dynamic.php');

$disp_url = "media.php";
$edit_url = "media_edit.php";

if(isset($_GET["mode"])) $mode = $_GET["mode"];
else if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'A';

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

if($mode == 'A')
{
	$txtalbum_name='';
	$txtcStatus='';
	
	
	$form_mode = "I";
	
}

elseif($mode == 'I')
{
	
	$txtmediatype_id=post_val($_POST['txtmediatype_id']);
	$txtmedia_album_id=post_val($_POST['txtmedia_album_id']);
	$txtcallertune_code=$_POST['txtcallertune_code'];
	
	$pfile=$_FILES['uploaded'];
	$pfile_cnt=count($_FILES['uploaded']['name']);
		
	$target_dir = "media/";
	
	$media_up_cnt=0;
	
	for($counter=0;$counter<$pfile_cnt;$counter++)
	{
		//print_r($pfile);
		$pfile_nm = $_FILES['uploaded']['name'][$counter];
		
		if($pfile_nm!='')
		{
			
			$target_file = $target_dir . basename( $_FILES['uploaded']['name'][$counter]);
			$file_ext = strtoupper(pathinfo($target_file,PATHINFO_EXTENSION));
			
			if($file_ext=="MP3")
			{
				$i=1;
				while(file_exists($target_file))
				{
					//get file name without suffix
					
					$rootname = basename( $_FILES['uploaded']['name'][$counter],".".$file_ext);
					$target_file= $target_dir.$rootname."-".$i.".".$file_ext;
					$i++;
				}
				
				$target_file = str_replace(" ","_",$target_file);
				
				
				
				//$track_name = str_replace($target_dir,"",$target_file);
				//echo $txtmedia_artist[$counter].$target_file;
				
			/*
				
				$txtid = NextID("media_id", "media_master");
				$q = "insert into media_master values('$txtid','$txtmedia_title','$txtmediatype_id','$txtmedia_category','$txtmedia_album_id','$txtmedia_artist','$txtmedia_singer','$txtmedia_music','$txtmedia_lyrics','$txtmedia_release_yr','','$txtmedia_copyrights','online_radio/admin/$target_file','$txtmedia_duration','$txtcallertune_code[$counter]','A')";
				$r = mysql_query($q);*/
				//echo "<br>".$target_dir.",".$track_name."=>".$q;
				if(move_uploaded_file($_FILES['uploaded']['tmp_name'][$counter],$target_file))
				{
					$txtid_arr[]=$txtid;
					$media_up_cnt++;
					//uploadding path goes below
					unlink("../../../../Users\Go it way 10\Pictures\MP Navigator EX".$_FILES['uploaded']['name'][$counter]);
				}
			}
		}
	}
	
				if($media_up_cnt>0)
				{
					echo "<script type='text/javascript'>
					alert('".$media_up_cnt." track(s) added successfully');
					</script>";
				}
				else
				{
					echo "<script type='text/javascript'>
						alert('Error in adding tracks');
						</script>";
				}
	//exit();
	if(isset($_POST["upload_news"]))
	{
		$loc_str = "news_edit.php?mid=".implode(",",$txtid_arr);
	}
	elseif(isset($_POST["upload_ad"]))
	{
		$loc_str = "ads_edit.php?mid=".implode(",",$txtid_arr);
	}
	else
	{
		$loc_str = $edit_url;
	}

	
	echo "<script>
			window.location.assign('".$loc_str."');
			</script>";
}

$mediatype_arr=GetArray("Select mediatype_id, mediatype_name from `mediatype_master` where cStatus = 'A' and mediatype_id not in (2,7) ");
$media_album_arr=GetArray("Select album_id, album_name from `album_master` where cStatus = 'A'");

?>
<html lang="en">
<head>
<?php include('_header.php'); ?>
  <script src="../js/script.js"></script>  
  <script>
  
  function check_exist(code_val_e)
  {
	  var ret_msg="";
	  var code_val=code_val_e.value;
	  $.post("check_caller_code.php","caller_code="+code_val, function(data) {
		  //alert(""+code_val);
		  ret_msg=data.trim();
		  if(ret_msg=="CODE_EXISTS")
		  {
			  code_val_e.value='';
			  alert("This Caller Tune Code is alredy in use");
		  }
	  });
  }
  
	updateList = function() {
	  var input = document.getElementById('uploaded');
	  var output = document.getElementById('fileList');

	  output.innerHTML = '';
	  for (var i = 0; i < input.files.length; ++i) {
		output.innerHTML += '<div class="form-group"><label>File Name: ' + input.files.item(i).name + '</label><input type="text" class="form-control" id="txtcallertune_code'+i+'" name="txtcallertune_code[]" value="" placeholder="Caller Tune Code" onchange="check_exist(this)" /></div>';
		
		
		
		output.innerHTML += '<hr style="border-top: 2px solid rgb(234, 233, 233);">';
	  }
	  output.innerHTML += '<table width="100%"><tr><td width="50%"><input type="submit" class="btn btn-info btn-md" id="task_update" name="submit" value="Save"></td><td width="50%"><a href="media.php" class="btn btn-info btn-md">Cancel</a></td></tr></table>';
	}
  
	$(document).ready(function(){
		var curr_mtype_id=0;
		$("#txtmediatype_id").change(function(){
			curr_mtype_id=$(this).val();
			if(curr_mtype_id==1)
			{
				/*
				$("#txtmedia_album_id").removeAttr("disabled");
				$("#txtmedia_album_id").attr("required","");
				*/
			}
			else
			{
				/*
				$("#txtmedia_album_id").attr("disabled","");
				$("#txtmedia_album_id").removeAttr("required");
				*/
			}
		});
	});
  
  </script>
<?php include('_menu.php');?>
	<div class="container">
		 <div class="row">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
				<input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
				
				<div class="col-sm-5">
				<h3>Media</h3>
					<div class="form-group">
						<label>Media Type:</label>
						<select name="txtmediatype_id" id="txtmediatype_id" class="form-control" required>
							<option value="1">SELECT</option>
							<?php
							foreach($mediatype_arr as $mediatype_id => $mediatype_val)
							{
								if($txtmediatype_id==$mediatype_id)
								{
									$x ="selected";
								}
								else{
									$x="";
								}
								echo '<option value="'.$mediatype_id.'"'.$x.'>'.$mediatype_val.'</option>';
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Album:</label>
						<table class="inline_fields" style="width:100%">
						<tr>
						<td style="width:75%">
						<select name="txtmedia_album_id" id="txtmedia_album_id" class="form-control" >
							<option value="">SELECT</option>
							<?php
							foreach($media_album_arr as $media_album_id => $media_album_val)
							{
								if($txtmedia_album_id==$media_album_id)
								{
									$x ="selected";
								}
								else{
									$x="";
								}
								echo '<option value="'.$media_album_id.'"'.$x.'>'.$media_album_val.'</option>';
							}
							?>
						</select>
						</td>
						<td style="width:20%" align="center">
						 <a href="#" title="Add New Album" data-toggle="modal" data-target="#albumModal" ><span class="glyphicon glyphicon-plus"></span> </a>
						</td>
						</tr>
						</table>
					</div>		
					<div class="form-group">
						<label></label>
						<div class="Uploadbtn" style="border:1px solid #ccc;min-height:78px;height:14%;width:90%;padding:2%;">
						  <input name="uploaded[]" id="uploaded" multiple type="file" accept="audio/mpeg" class="input-upload" onchange="javascript:updateList()" />
						  <span>Drop files here <br>or <br>click to browse your computer.</span>
						</div>
						<br/>
					</div>	
				</div>
				
				<div class="col-sm-3" id="fileList">
				Selected files:
				
							
				</div>
				
			</form>
		</div>

		<?php include('_footer.php'); ?>
		
	</div>
<?php

?>
</body>
</html>
	
<?php	
	

?>