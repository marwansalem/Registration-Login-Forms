
<!DOCTYPE html>

<html>
<style>

</style>

<head>
	<title>Sign Up!</title>
</head>
<body>
<script>
function validate_registration(){
	
	var pw = document.forms["regform"]["password"];
	var pwc = document.forms["regform"]["confirmation"];
	var em = document.forms["regform"]["email"];
	var un= document.forms["regform"]["username"];
	if(pw.value.length<8 ){

		window.alert("Password too short");
		document.getElementById("pwlbl").style.color="red";
		pw.focus();
		return false;
		
	}
	if(pw.value!=pwc.value){

		window.alert("Passwords do not match");
		pwc.focus();
		document.getElementById("pwclbl").style.color="red";
		return false;
	}else{
		document.getElementById("pwlbl").style.color="green";
		
		document.getElementById("pwclbl").style.color="green";
	}
	if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(em.value) ==false){
		window.alert("Invalid Email!")
		document.getElementById("emlbl").style.color="red";
		em.focus();
		return false;
	}else{
		document.getElementById("emlbl").style.color="green";
	}
	if(un.value==""  || un.value.length<3){
		window.alert("Password too short");
		document.getElementById("unlbl").style.color="red";
		un.focus();
		return false;

	}


	return true;
}
</script>
<?php if(isset($_GET['error'])): ?>
	<p style="color:red;"><?php echo $_GET['error']; ?> </p>
<?php endif;?> 

<H1> Register Now!</H1>
<form action="/login/welcome.php" name="regform" method="POST" onsubmit="return validate_registration()" >
<label id="unlbl">Username</label>
<input id ="uname" style="margin-left:68px;" name="username" type="text" required   >
<br>

<label id="emlbl">Enter Email</label>
<input id="email" name="email"  style="margin-left:41px;" type="email"  placeholder="someone@example.com" autocomplete="on" required >
<br>


<label id="pwlbl">Password</label>
<input id ="pw" name="password" type="password"  style="margin-left:68px;"  minlength="8" required >
<br>
<label id="pwclbl">Confirm Password</label>
<input id="pwconfirm" name="confirmation"style="margin-left:-2px;" type="password"  minlength="8" required >
<br>
<button style="bottom: 300em; color:red;" type="submit">Register!</button>
</form>
</body>
</html>
