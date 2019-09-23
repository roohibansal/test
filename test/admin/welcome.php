<html><body>
<?php 
 	$conn=new mysqli("localhost","hifivein_ps15","Y^Oh^Av#qMdaOe&AOh^09..5","hifivein_ps15");
	session_start();
	$fname='';
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
			$email=$row['email'];
			$usertype=$row['usertype'];
			$picture=$row['picture'];
			$address=$row['address'];
			$hobbies=json_decode($row['hobbies']);
		}
	}
	
?>
<?php if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){?>
<a href="logout.php?id=<?php echo $_SESSION['userid'];?>">Logout</a>
<div><h2>Welcome  <?php echo $fname; ?>  <img src="../images/<?php echo $picture;?>" style="width:200px;"/></h2></div>
<table>
	<tr>
		<td>First Name</td>
		<td><?php echo $fname; ?></td>
		
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo $lname; ?></td>
		
	</tr>
	<tr>
		<td>Email</td>
		<td><?php echo $email; ?></td>
		
	</tr>
	<tr>
		<td>Username</td>
		<td><?php echo $username; ?></td>
		
	</tr>
	<tr>
		<td>Usertype</td>
		<td><?php echo $usertype; ?></td>
		
	</tr>
	<tr>
		<td>Password</td>
		<td><?php echo $password; ?></td>
		
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td><?php echo $dob; ?></td>
		
	</tr>
	<tr>
		<td>Gender</td>
		<td><?php if($gender == 'm') { echo  'Male';}else{ echo 'female';} ?></td>
		
	</tr>
	<tr>
		<td>Address</td>
		<td><?php echo $address; ?></td>
		
	</tr>
	<tr>
		<td>Hobbies</td>
		<td><?php echo $hobbies; ?></td>
		
	</tr>
	<tr>
	<td colspan="2"><a href="edit.php?id=<?php echo $_SESSION['userid'];?>">Edit</a></td>
	</tr>
</table>
<?php } ?>
</body></html>