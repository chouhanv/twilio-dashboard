<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="top"></div>
                        <div class="hello">
                            <div class="logo">
                                <img src="images/logo.png" /></div>
                            <h1>HELLO AGAIN!</h1>
                            <p>Wherever you go, we’re there with customized client care.</p>
                            <div class="login_main">
                                <div class="pull-left">
									<form id="frmlogin">
										<div class="login_to">
											<p>Login To My Account</p>
											<p id="error"></p>
											<input type="text" id="email" name="email" placeholder="Email" required/>
											<input type="password" id="password" name="password" placeholder="Password" required/>
											<input type="submit" name="submit" value="SIGN IN" />
											<div class="clear"></div>
											<div class="text-left"><span class="ques">?</span><span class="oops">Oops! Forgot My Password</span> </div>
											<div class="clear"></div>
											<i class="fa fa-clock-o"></i><span>12:24 pm</span>
										</div>
									</form>
                                </div>
                                <div class="pull-right">
                                    <div class="mobile">
                                        <img src="images/mobile_screen.png" />
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="bottom"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#frmlogin").submit(function(event){
				$.ajax({
					url:"http://104.131.124.227:3000/api/agents/login",
					type:'POST',
					data: {email: $("#email").val(), password: $("#password").val()},	
					success:function(result){ 				
						if(result.userId){
							$.ajax({
								url:"http://104.131.124.227:3000/api/agents/"+result.userId+"?access_token="+result.id,
								type:'GET',
								data: {},	
								success:function(res){ 				
									console.log('result',res);
									$.ajax({
										url:"session.php",
										type:'POST',
										data: {name: res.name, userid: result.userId, imageurl: result.profile_image},	
										success:function(res){ 
											if(res == 1)
											{
												window.location.href = "dashboard.php";
											}
										}
									});
								},
								error:function(err1){
									console.log('err',err1);
								}
							});
						}				
					},
					error:function(err){
						alert('Invalid Email or Password!');
					}
				});
				event.preventDefault();
			});
		});
	</script>
</body>
</html>