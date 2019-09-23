<html><body>
<?php 
	if(isset($_GET['id'])){
		unset($_SESSION['userid']);
		session_destroy();
		header('Location:login.php');
	}
?>

</body></html>