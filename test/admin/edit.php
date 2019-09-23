<html><body>
<?php 
 	$conn=new mysqli("localhost","hifivein_ps15","Y^Oh^Av#qMdaOe&AOh^09..5","hifivein_ps15");
	session_start();
	$msg='';
	$user_type='';
	$address='';
	$image='';
	$error=isset($_GET['error'])?$_GET['error']:'';
	$hobbies=array();
	$res='';
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$id=$_GET['id'];
		$_SESSION['userid']=$id;
	}
	
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
		$id=$_SESSION['userid'];
		$sql="select * from users where id=$id";
		$res=$conn->query($sql);
		if($res->num_rows > 0){
			$row=$res->fetch_assoc();
			$fname=$row['fname'];
			$lname=$row['lname'];
			$username=$row['username'];
			$password=$row['password'];
			$gender=$row['gender'];
			$dob=$row['dob'];
			$ary=explode("/",$dob);
			$day=$ary[0];
			$month=$ary[1];
			$year=$ary[2];
			$email=$row['email'];
			$usertype=$row['usertype'];
			$picture=$row['picture'];
			$address=$row['address'];
			$hobbies=json_decode($row['hobbies']);
		}
	}
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
		
		if(isset($_FILES['picture']) && !empty($_FILES['picture'])){
			if(isset($_FILES['picture']['name']) && !empty($_FILES['picture']['name'])){
				$image=$_FILES['picture']['name'];
				$extension=pathinfo($_FILES['picture']['name'],PATHINFO_EXTENSION);
				if($extension != 'jpg' && $extension != 'png' & $extension != 'gif'){
					$error='Invalid Image format(only jpg,png ,gif allowed)';
					die;
				}
				$target='images/'.basename($image);
				
			}
			
		}
		$id=$_SESSION['userid'];
		$sql="update users set usertype='$usertype',username='$username',password='$password',email='$email',dob='$dob',fname='$fname',lname='$lname',gender='$gender',address='$address',hobbies='$hobbies' where id=$id";
		$res=$conn->query($sql); 
		
		if(move_uploaded_file($_FILES['picture']['tmp_name'],$target)){
			$msg="Image Uploaded successfully";
		}
		else{
			$msg="Image upload failed";
		}
		if($res){
			header("Location:welcome.php?id=".$_SESSION['userid']);
			exit;
		}
		/* if($res && $msg == 'Image Uploaded successfully'){
			echo '<script type="text/javascript">alert("User has been registered successfully!")</script>';
		} */
		 
	}  
?>
<?php if($_SESSION['userid']){?>
<form method="POST" action="edit.php" name="editform" enctype="multipart/form-data" onsubmit="return validate();">
<div id="error"></div>
<div id="p_feedback"></div>
<?php  if(isset($error)){echo $error;}?>
<div>
  <label>User Type <span style="color:red">*</span></label>
  <select name="usertype" id="usertype">
    <option value="">Select</option>
    <option value="1" <?php  if($usertype == 1){ echo "selected='selected'";}?>>Superadmin</option>
    <option value="2" <?php  if($usertype == 2){ echo "selected='selected'";}?>>Admin</option>
  </select>
</div>
<div>
  <label>Profile Picture <span style="color:red">*</span></label>
  <input type="file" name="picture" id="picture" value="<?php echo $picture;?>"/>
  <?php  if($picture){
	 ?>
	 <img src="../images/<?php echo $picture;?>"/>
	<?php
  }?>
</div>
<div>
  <label>First Name <span style="color:red">*</span></label>
  <input type="text" name="fname" id="fname" value="<?php echo $fname;?>"/>
</div>
<div>
  <label>Last Name</label>
  <input type="text" name="lname" id="lname" value="<?php echo $lname;?>"/>
</div>
<div>
  <label>Email <span style="color:red">*</span></label>
  <input type="text" name="email" id="email" value="<?php echo $email;?>"/>
</div>
<div>
  <label>Username <span style="color:red">*</span></label>
  <input type="text" name="username" id="username" value="<?php echo $username;?>"/>
</div>
<div>
  <label>Password <span style="color:red">*</span></label>
  <input type="text" name="password" id="password" value="<?php echo $password;?>"/>
</div>
<div>
  <label>Address</label>
  <textarea name="address" rows="3" cols="15"><?php echo $address;?></textarea>
</div>
<div>
  <label>Gender</label>
  <input type="radio" name="gender" value="m" <?php if($gender=='m'){echo 'checked';}?>/>Male
  <input type="radio" name="gender" value="f" <?php if($gender=='f'){echo 'checked';}?>/>Female
</div>
<div>
  <label>Date of Birth <span style="color:red">*</span></label>
  <div>
  Day
  <select name="day" id="day">
    <option value=""></option>
   <?php  for($i=1;$i<=31;$i++){ ?>
    <option value="<?php echo $i;?> " <?php if($day==$i){ echo 'selected="selected"';}?>><?php echo $i; ?></option>
   <?php } ?>
  
  </select>
  Month
  <select name="month" id="month">
    <option value=""></option>
    <option value="1" <?php if($month==1){ echo 'selected="selected"';}?>>Jan</option>
    <option value="2" <?php if($month==2){ echo 'selected="selected"';}?>>Feb</option>
    <option value="3" <?php if($month==3){ echo 'selected="selected"';}?>>Mar</option>
    <option value="4" <?php if($month==4){ echo 'selected="selected"';}?>>Apr</option>
    <option value="5" <?php if($month==5){ echo 'selected="selected"';}?>>May</option>
    <option value="6" <?php if($month==6){ echo 'selected="selected"';}?>>Jun</option>
    <option value="7" <?php if($month==7){ echo 'selected="selected"';}?>>Jul</option>
    <option value="8" <?php if($month==8){ echo 'selected="selected"';}?>>Aug</option>
    <option value="9" <?php if($month==9){ echo 'selected="selected"';}?>>Sep</option>
    <option value="10" <?php if($month==10){ echo 'selected="selected"';}?>>Oct</option>
    <option value="11" <?php if($month==11){ echo 'selected="selected"';}?>>Nov</option>
    <option value="12" <?php if($month==12){ echo 'selected="selected"';}?>>Dec</option>
  
  </select>
  Year
  <select name="year" id="year">
    <option value=""></option>
   <?php  for($y=1980;$y<=2012;$y++){ ?>
    <option value="<?php echo $y;?> " <?php if($year==$y){ echo 'selected="selected"';}?>><?php echo $y; ?></option>
   <?php } ?>
  
  </select>
  
  </div>
</div>
<div>
	<label>Hobbies</label>
	<input type="checkbox" name="hobbies[]" value="dancing" <?php if(in_array('dancing',$hobbies)){ echo "checked";}?>>Dancing
	<input type="checkbox" name="hobbies[]" value="reading" <?php if(in_array('reading',$hobbies)){ echo "checked";}?>>Reading
	<input type="checkbox" name="hobbies[]" value="cooking" <?php if(in_array('cooking',$hobbies)){ echo "checked";}?>>cooking
	<input type="checkbox" name="hobbies[]" value="singing" <?php if(in_array('singing',$hobbies)){ echo "checked";}?>>singing
</div>

<input type="submit" value="Edit" name="submit"/>
</form>
<script type="text/javascript">
function validate(){
	var flag= true
	var msg="Follwing validations failed";
	
	if(document.forms["editform"]["usertype"].value == ""){
		
		flag = false;
		msg += "<br/>Select User type please";
	}
	
	if(document.forms["editform"]["fname"].value == ""){
		flag = false;
		msg += "<br/>Select First Name please";
	}
	
	if(document.forms["editform"]["email"].value == ""){
		flag = false;
		msg += "<br/>Select Email please";
	}
	//Validate Email
	if(document.forms["editform"]["email"].value != ""){
		var x = document.forms["editform"]["email"].value;
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
	if(document.forms["editform"]["username"].value == ""){
		flag = false;
		msg += "<br/>Select username please";
	}
	if(document.forms["editform"]["password"].value == ""){
		flag = false;
		msg += "<br/>Select password please";
	}
	if(document.forms["editform"]["password"].value != ""){
		var p=document.forms["editform"]["password"].value;
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
	
	if(document.forms["editform"]["day"].value == ""){
		if(document.forms["editform"]["month"].value == ""){
			if( document.forms["editform"]["year"].value == ""){
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

<?php } ?>
</body></html>