


<style type="text/css">

div.login-form{


	width: 320px;
	min-height: 150px;
	border-radius: 10px;
	margin-top: 50px;
	
	  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 1);
     -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 1);
          box-shadow: 0 1px 4px rgba(0, 0, 0, 1);


}


.log-head{
	position: absolute;
	top: -42px;
	right: 20px;
}

div.login-alert{

	width: 250px;
	height: 40px;
	padding-bottom: 20px;
	border-radius: 10px;
	float: none;
}

#btn_log{

	
	height: 50px;
	width: 245px;
}
</style>



<body>
<center><h3>Enriquez Medical Clinic</h3></center>
<div class="wrap">
<form>
<center>
<div class="login-form">
<div class="login-header"></div><br><br>
<div class="form-group">
<table>
<tr><td>
<div class="input-prepend">
<span class="add-on"><i class="icon-user"></i></span>
<input  type='text' name='username' id='username' placeholder='Username'/>
</div></td></tr>

<tr><td>
<div class="input-prepend">
<span class="add-on"><i class="icon-lock"></i></span>
<input  type='password' name='password' id='password' placeholder='Password'/>
</div></td></tr>

<tr><td>
<input type='submit' id='btn_log' class='btn btn-info' value='LOGIN' />
</table></td></tr></form>
</div><br>
	<div id="error_message" class="login-alert">
		
	</div>
</center>
</div>
</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
</body>



<script type="text/javascript">


$('#btn_log').click(function(){

	var json = JSON.stringify({ 
		username:$("#username").val(),
		password:$("#password").val()

	});
$("#error_message").html('<div class="alert alert-info"><img src="<?php echo PUBLIC_URL;?>img/loader.gif"/></div>');
	$.ajax({
		url: 'index.php/ajax/login_function',
		datatype: 'json',
		type: 'post',
		 data: "data=" + json,
		 success: function(data){

		 	if(data == 1)
		 	{
		 		$("#error_message").html('<div class="alert alert-success">Information Verified</div>');
		 		 window.location.href = '<?php echo SITE_URL;?>registration/index';

		 	}else if(data == 0)
		 	{
				$("#error_message").html('<div class="alert alert-error">Incorrect Details</div>');
		 	}
		 	else if(data == 2)
		 	{
				$("#error_message").html('<div class="alert alert-error">User is currently Logged-in</div>');
		 	}


		 }
	});

return false;
});

</script>




<!-- <script type="text/javascript">


$('#btn_log').click(function(){

	var json = JSON.stringify({ 
		username:$("#username").val(),
		password:$("#password").val()

	});

	$.ajax({
		url: 'index.php/ajax/login_function',
		datatype: 'json',
		type: 'post',
		 data: "data=" + json,
		 success: function(data){

		 	var data = JSON.parse(data);



		 	$('#name').val(data.username);
		 	$('#name1').val(data.password);

		 }
	});

return false;
});

</script> -->