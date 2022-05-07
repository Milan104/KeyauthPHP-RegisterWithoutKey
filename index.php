<?php
	
require 'keyauth.php'; // Import KeyAuth Class from keyauth.php file

/*
    Requirements: ["KeyAuth Seller Plan"]
    PHP Example Installing Video: https://youtube.com/watch?v=NCZkg_O92sA
    For License Generation Details Please install them on lines: 121-124 in this file
*/

if (isset($_SESSION['user_data'])) 
{
	header("Location: dashboard/");
    exit();
}

$name = ""; // KeyAuth Application Name
$ownerid = ""; // KeyAuth Application Owner ID
$KeyAuthApp = new KeyAuth\api($name, $ownerid);

if (!isset($_SESSION['sessionid'])) 
{
	$KeyAuthApp->init();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://cdn.keyauth.win/assets/img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.win/auth/css/util.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.keyauth.win/auth/css/main.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-51">
						KeyAuth PHP Example
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button name="login" class="login100-form-btn">
							Login
						</button>
					</div>
					
					<div class="container-login100-form-btn m-t-17">
						<button name="register" class="login100-form-btn">
							Register
						</button>
					</div>
					
				</form>
			</div>	
		</div>
	</div>
	
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <?php
        if (isset($_POST['login']))
        {
		// login with username and password
		if($KeyAuthApp->login($_POST['username'],$_POST['password']))
		{
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully logged in!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}
		
		if (isset($_POST['register']))
        {
            $regKey = genKey(); // Generates Key
		if($KeyAuthApp->register($_POST['username'],$_POST['password'],$regKey))
		{
			echo "<meta http-equiv='Refresh' Content='2; url=dashboard/'>";
			                            echo '
                            <script type=\'text/javascript\'>
                            
                            const notyf = new Notyf();
                            notyf
                              .success({
                                message: \'You have successfully registered!\',
                                duration: 3500,
                                dismissible: true
                              });                
                            
                            </script>
                            ';     
		}
		}

        function genKey() {
            $SellerKey = ""; // Your Seller Key [Requires Seller Plan]
            $Expiry = "10"; // In Days
            $KeyMask = "XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX-XXXXXX"; // Key Mask for key that will be generated
            $KeyLevel = "1"; // License key Level from subscription levels page

            $ch = curl_init("https://keyauth.win/api/seller/?sellerkey=" . $SellerKey . "&type=add&expiry=" . $Expiry . "&mask=" . $KeyMask . "&level=" . $KeyLevel . "&amount=1&format=text");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $regKey = curl_exec($ch);
            curl_close($ch);
            return $regKey;
        }
    ?>
</body>
</html>
