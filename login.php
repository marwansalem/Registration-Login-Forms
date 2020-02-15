
<!DOCTYPE html>

<html>
<style>
</style>

<head>
	<title>LOGIN FORM!</title>
</head>
<body>
	
<script>
function check(){


	var pw = document.forms["logform"]["password"];
	var em = document.forms["logform"]["email"];
	if(pw.value=="" ||pw.value.length<8)
	{	
		window.alert("Invalid Password");
		document.getElementById("pwlbl").style.color="red";
		pw.focus();
		return false;
	}else{
		document.getElementById("pwlbl").style.color="green";
	}
	if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(em.value) ==false){
		window.alert("Invalid Email!")
		document.getElementById("emlbl").style.color="red";
		em.focus();
		return false;
	}else{
		document.getElementById("emlbl").style.color="green";
	}
	
	return true;
}



</script>

<?php if(isset($_GET['error'])): ?>
	<p style="color:red;"><?php echo $_GET['error']; ?> </p>
<?php endif;?> 

<form name ="logform" action="/login/welcome.php" method="POST" onsubmit="return check();">
<label id="emlbl">Email</label>
<br>
<input id="email" name="email" type="email" required placeholder="someone@example.com"required >
<br>
<label id="pwlbl">Password</label><br>
<input id ="pwfield" name="password" type="password"  placeholder="********" minlength="8" required>
<br>
<button  type="submit">Login!</button>
</form>
</body>
</html>
