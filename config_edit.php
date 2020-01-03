<?php
include('dynamic.php');

$info_arr=array();

if(isset($_POST["mode"])) $mode = $_POST["mode"];
else $mode = 'E';

if($mode == 'U')
{
 	if((isset($_POST["pass1"])) && (trim($_POST["pass1"])))
	{
		$txtpassword = md5(post_val($_POST["pass1"]));
		$txtpassword = myhash($txtpassword);
		$q1 = "UPDATE `user_table` SET pass_word= '$txtpassword'  WHERE user_id = ".$sess_user_id;
		$r1 = RunQry($q1);
		
		if($r1)
		{
			$info_arr[]='Password';
		}
		else{
			
		}
	}
 	
 	
   
 	
    if(($r1))
	{
		echo "<script>
		alert('".implode(",",$info_arr)." value updated successfully');
		</script>";
	}
	elseif($r)
	{
		
	}
	else{
		echo "<script>
		alert('Error while updating settings.');
		</script>";
	}
	
		echo "<script>
				window.location.assign(document.referrer);
				</script>";
	exit;
}
 
?>