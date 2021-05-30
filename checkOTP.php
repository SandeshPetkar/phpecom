<?php
session_start();

	if($_SESSION['OTP']==$_POST['OTP']){
		echo "Verified";
	}else{
		echo "Wrong";
	}
?>