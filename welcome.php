<!DOCTYPE html>
<html>
<style>
</style>
<body>
<?php
	$conn = mysqli_connect("localhost","root","","registration");
	 
	
	if(mysqli_connect_errno()){
		echo "Connection Error :".mysqli_connect_error();
	}

	//echo $_SERVER['HTTP_REFERER'];
	$_PASSWORD_MINLEN=8;

	$error="";

	$_sucess=false;

	function append_error($err,$new_err){
		if($err==""){
			$err="error=".$new_err;
		}else{
			if($new_err!="")
				$err=$err."&".$new_err;
		}
		
		return $err;
	}
	function validate_password($_errors,$_PASSWORD_MINLEN=8){ // if password is sent empty ,, even though it's required in html,, but let's say someone edited the html?
		$pw=$_POST['password'];
		if(strlen($pw)<$_PASSWORD_MINLEN){
			$_errors=append_error($_errrors,"password%20too%20short%20minimum%20is%20".$_PASSWORD_MINLEN);
		}

		return $_errors;
	}

	function validate_names($_errors){
		$fn=$_POST["username"];

		if(($fn)==""){
			$_errors=append_error($_errors,"username%20cannot%20be%20empty");
		}
		
		

		return $_errors;
	}
	function validate_email($_errors){
		if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			$_errors=append_error($_errors,"Invalid%20Email");

		return $_errors;
	}

	/*echo $_SERVER['SERVER_NAME']."LOL"."<br>";
	foreach ($_SERVER as $THING ) {
		echo $THING."<br>";*/
		# code...
	//}
	
	$email = $_POST["email"];
	
	$pw = $_POST["password"];
	

	$error = validate_email($error);
		
	$error = validate_password($error);

	$email =strtolower($email);

	//$pw_md5 = md5($_POST["password"]);	
	if( strpos($_SERVER['HTTP_REFERER'],"http://".$_SERVER['SERVER_NAME']."/login/register.php")!==false) //if you are redirected from signup form with error or no
	{//$_SERVER['HTTP_REFERER']=="http://".$_SERVER['SERVER_NAME']."/login/signup.php" doesnt work if you came from an already errored input


		$error = validate_names($error);


		if($pw !=$_POST["confirmation"])
			$error=append_error($error,"Passwords%20do%20not%20match!");

		/*if(md5($pw)!=md5($_POST['confirmation'])){	// if passwords do not match then redirect 
			
		}*/

		if($error!=""){ // if errors detected then redirect
			header("Location:/login/register.php?".$error);
		}else{
			// insert to table then welcome then  raise flag to mark the user.
			$query= "SELECT * FROM user WHERE email='".$email."'  ";
			$un = $_POST["username"];
			$userreg= mysqli_query($conn,$query);
			$em_unique=false;
			$uname_unique= false;
			
			if(mysqli_fetch_row($userreg)!=NULL){ //if not null then the query result is not empty
					//$re=$mysqli_fetch_row($userreg);
					 
					$error=append_error($error,"EmailAlreadyRegistered");

			}else{
				$em_unique=true;
			}


			$query= "SELECT * FROM user WHERE username='".$un."'  ";
			$userreg=mysqli_query($conn,$query);
			if(mysqli_fetch_row($userreg)!=NULL){
					$error=append_error($error,"usernametaken");
			}else{
				$uname_unique=true;
			}

			if($uname_unique && $em_unique){
				$query= "INSERT into  user(email,username,password) VALUES ('".$email."','".($un)."','".md5($pw)."')";
				$userreg=mysqli_query($conn,$query);
				

				$_sucess=true; //raise flag so you can show the username!
			}else{
					header("Location:/login/register.php?".$error);	
			}








		}
	}else if( strpos($_SERVER['HTTP_REFERER'],"http://".$_SERVER['SERVER_NAME']."/login/login.php")!==false){ //redirected here from login form
		if($error!=""){
			header("Location:/login/login.php?".$error);
		}else{
			// check if this is a valid user  then raise the flag
			//flag of showing the user name = True
			
			$q="select * from user where email='".$email."'  and password='".md5($pw)."'";
			$userlog= mysqli_query($conn,$q);
			if(mysqli_fetch_row($userlog)==NULL){
				$error=append_error($error,"Wrong credentials");
				header("Location:/login/login.php?".$error);	
			}else{
				$_sucess=true;

			}
			
		}

	}
	if($_sucess){ //success means successful login or registration 
		$q="select username from user where email='".$email."'";
		$_curr_user=mysqli_query($conn,$q);
		$curr_uname=mysqli_fetch_row($_curr_user)[0];
		echo "<H1  >Welcome  " .$curr_uname . "</H1>";
		
	}

?>
</body>
</html>