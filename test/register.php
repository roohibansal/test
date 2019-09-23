<?php 
 	$conn=new mysqli("localhost","hifivein_ps15","Y^Oh^Av#qMdaOe&AOh^09..5","hifivein_ps15");
	
	$user_type='';
	$address='';
	$image='';
	$error=isset($_GET['error'])?$_GET['error']:'';
	$hobbies=array();
	$res='';
	
	
	if(isset($_POST['submit'])){
		$user_type=$_POST['usertype'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$address=$_POST['address'];
		$gender=$_POST['gender'];
		$dob=$_POST['day'].'/'.$_POST['month'].'/'.$_POST['year'];
		$hobbies=json_encode($_POST['hobbies']);
		//echo $hobbies;die;
		//username existnce
		if(isset($username) && !empty($username)){
			$sql="select * from users where username='$username'";
			$result=$conn->query($sql);
			//print_r($result->num_rows);die;
			if($result->num_rows > 0){
				$error="Username already exists.Choose something else.";
				header('Location:register.php?error='.$error);
			}
			
		}
		if(isset($email) && !empty($email)){
			$sql="select * from users where email='$email'";
			$result=$conn->query($sql);
			//print_r($result->num_rows);die;
			if($result->num_rows > 0){
				$error="Email already exists.Use something else.";
				header('Location:register.php?error='.$error);
			}
			
		}
		
		if(isset($_FILES['picture']['name']) && !empty($_FILES['picture']['name'])){
			$image=$_FILES['picture']['name'];
			$extension=pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
			if($extension != 'jpg' && $extension != 'png' & $extension != 'gif'){
				$error='Invalid Image format(only jpg,png ,gif allowed)';
				die;
			}
			$target='images/'.basename($image);
			
		}
		
		$sql="insert into users (usertype,fname,lname,email,username,password,address,gender,dob,hobbies,picture) Values($user_type,'$fname','$lname','$email','$username','$password','$address','$gender','$dob','$hobbies','$image')";
		$res=$conn->query($sql); 
		
		if(move_uploaded_file($_FILES['picture']['tmp_name'],$target)){
			$msg="Image Uploaded successfully";
		}
		else{
			$msg="Image upload failed";
		}
		/* if($res && $msg == 'Image Uploaded successfully'){
			echo '<script type="text/javascript">alert("User has been registered successfully!")</script>';
		} */
		 
	}  
?>
<html><body>
<?php
if(isset($_POST['submit'])){
	if($res){
		echo '<script type="text/javascript">alert("User has been registered successfully!")</script>';
	}
}	
?>

<form method="POST" action="register.php" name="regform" enctype="multipart/form-data" onsubmit="return validate();">
<div id="error"></div>
<div id="p_feedback"></div>
<?php  if(isset($error)){echo $error;}?>
<div>
  <label>User Type <span style="color:red">*</span></label>
  <select name="usertype" id="usertype">
    <option value="">Select</option>
    <option value="1">Superadmin</option>
    <option value="2">Admin</option>
  </select>
</div>
<div>
  <label>Profile Picture <span style="color:red">*</span></label>
  <input type="file" name="picture" id="picture"/>
</div>
<div>
  <label>First Name <span style="color:red">*</span></label>
  <input type="text" name="fname" id="fname"/>
</div>
<div>
  <label>Last Name</label>
  <input type="text" name="lname" id="lname"/>
</div>
<div>
  <label>Email <span style="color:red">*</span></label>
  <input type="text" name="email" id="email"/>
</div>
<div>
  <label>Username <span style="color:red">*</span></label>
  <input type="text" name="username" id="username"/>
</div>
<div>
  <label>Password <span style="color:red">*</span></label>
  <input type="text" name="password" id="password"/>
</div>
<div>
  <label>Address</label>
  <textarea name="address" rows="3" cols="15"></textarea>
</div>
<div>
  <label>Gender</label>
  <input type="radio" name="gender" value="m" checked/>Male
  <input type="radio" name="gender" value="f"/>Female
</div>
<div>
  <label>Date of Birth <span style="color:red">*</span></label>
  <div>
  Day
  <select name="day" id="day">
    <option value=""></option>
   <?php  for($i=1;$i<=31;$i++){ ?>
    <option value="<?php echo $i;?> "><?php echo $i; ?></option>
   <?php } ?>
  
  </select>
  Month
  <select name="month" id="month">
    <option value=""></option>
    <option value="1">Jan</option>
    <option value="2">Feb</option>
    <option value="3">Mar</option>
    <option value="4">Apr</option>
    <option value="5">May</option>
    <option value="6">Jun</option>
    <option value="7">Jul</option>
    <option value="8">Aug</option>
    <option value="9">Sep</option>
    <option value="10">Oct</option>
    <option value="11">Nov</option>
    <option value="12">Dec</option>
  
  </select>
  Year
  <select name="year" id="year">
    <option value=""></option>
   <?php  for($y=1980;$y<=2012;$y++){ ?>
    <option value="<?php echo $y;?> "><?php echo $y; ?></option>
   <?php } ?>
  
  </select>
  
  </div>
</div>
<div>
	<label>Hobbies</label>
	<input type="checkbox" name="hobbies[]" value="dancing">Dancing
	<input type="checkbox" name="hobbies[]" value="reading">Reading
	<input type="checkbox" name="hobbies[]" value="cooking">cooking
	<input type="checkbox" name="hobbies[]" value="singing">singing
</div>

<input type="submit" value="Register" name="submit"/>
</form>

<script type="text/javascript">
function validate(){
	var flag= true
	var msg="Follwing validations failed";
	
	if(document.forms["regform"]["usertype"].value == ""){
		
		flag = false;
		msg += "<br/>Select User type please";
	}
	if(document.forms["regform"]["picture"].value == ""){
		flag = false;
		msg += "<br/>Select Picture please";
	}
	if(document.forms["regform"]["fname"].value == ""){
		flag = false;
		msg += "<br/>Select First Name please";
	}
	
	if(document.forms["regform"]["email"].value == ""){
		flag = false;
		msg += "<br/>Select Email please";
	}
	//Validate Email
	if(document.forms["regform"]["email"].value != ""){
		var x = document.forms["regform"]["email"].value;
		var is_valid=0;
		if(x.indexOf("@")>=1){
			var dot_part=x.substr(x.indexOf("@")+1);
			if(dot_part.indexOf("@")== -1){
				dot_part_after=dot_part.substr(dot_part.indexOf(".")+1);
				if(dot_part_after.length >= 1){
					is_valid = 1;
				}
			}
		}
		if(!is_valid){
			flag= false;
			msg +="<br/>Please input correct email format";
		}
	}
	if(document.forms["regform"]["username"].value == ""){
		flag = false;
		msg += "<br/>Select username please";
	}
	if(document.forms["regform"]["password"].value == ""){
		flag = false;
		msg += "<br/>Select password please";
	}
	if(document.forms["regform"]["password"].value != ""){
		var p=document.forms["regform"]["password"].value;
		var pass_level=0;
		if(p.match(/[a-z]/g)){
			pass_level++;
		}
		if(p.match(/[A-Z]/g)){
			pass_level++;
		}
		if(p.match(/[0-9]/g)){
			pass_level++;
		}
		if(p.length < 5){
			if(pass_level >= 1){
				pass_level--;
			}
		}else if(p.length >=20){
			pass_level++;
		}
		var err='';
		switch(pass_level){
			case 1:err='Password is weak';break;
			case 2:err='Password is normal';break;
			case 3:err='Password is strong';break;
			case 4:err='Password is very strong';break;
			default:err='Password is very weak';break;
		}
		
		if(document.getElementById("p_feedback").innerHTML!=err){
			document.getElementById("p_feedback").innerHTML=err;
			
		}
		
	}
	
	if(document.forms["regform"]["day"].value == ""){
		if(document.forms["regform"]["month"].value == ""){
			if( document.forms["regform"]["year"].value == ""){
				flag = false;
				msg += "<br/>Select Date of Birth please";
			}
		}
	}
	
	if(!flag){
		document.getElementById("error").innerHTML=msg;
		return false;
	}
	return true;
	
	
}
</script>
</body></html>