<?php 
 	$conn=new mysqli("localhost","hifivein_ps15","Y^Oh^Av#qMdaOe&AOh^09..5","hifivein_ps15");
	$msg='';
	if(isset($_POST['submit'])){
		$username=$_POST['username'];
		$password=$_POST['password'];
		$sql="select * from users where username='$username' and password='$password'";
		$result=$conn->query($sql);
		
		if($result->num_rows > 0){
			$row=$result->fetch_assoc();
			$uid=$row['id'];
			header('Location:welcome.php?id='.$uid);
		}else{
			$msg='Invalid Login';
		}
	}
?>
<html><body>

<form method="POST" action="login.php">
<div id="error"></div>
<div id="p_feedback"></div>

<div>
  <label>Username <span style="color:red">*</span></label>
  <input type="text" name="username" id="username"/>
</div>
<div>
  <label>Password <span style="color:red">*</span></label>
  <input type="password" name="password" id="password"/>
</div>


<input type="submit" value="Login" name="submit"/>
</form>


</body></html>