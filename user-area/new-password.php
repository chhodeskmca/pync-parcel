<?php
    // initialize session
    session_start();
	include('../config.php'); // database connection

require_once __DIR__ . '/../routes/web.php';
$routes = include __DIR__ . '/../routes/web.php';
$base_url = $routes['base_url'];
	
   if( !isset( $_REQUEST['token_hash'])){ 
      echo "<span style='color:red'> Something went wrong.</span> <a href='../index.php'>Please try later.</a>";
	  die();
   };
    $token_hash = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['token_hash'])) ) ;  
	
   //checking token_hash exists or not in database and validation
   $sql = "SELECT * FROM users where Token_hash = '$token_hash'";
   $result = mysqli_query($conn, $sql); 
   
	
   if(  mysqli_num_rows( $result ) < 1 ){ 
   
       echo "<span style='color:red'>The Password reset link is invalid.</span>  <a href='../sign-in.php'>Please request a new one.</a>";
	   die();
   }; 
   $rows = mysqli_fetch_array( $result);
   
   if( strtotime($rows['token_expired_at']) <= time() ){ 
   
        echo "The Password reset link has expired. <a href='../sign-in.php'> Please request a new one.</a>";
	    die();
   };
   if( isset($_REQUEST['new_password'] ) ){  
   
         $token_hash = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['token_hash'])) ) ;
         $pwd = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['pwd'])) ) ;
	     $hash_password = password_hash($pwd, PASSWORD_DEFAULT);
		 $sql = "UPDATE  users SET password_hash = '$hash_password' where token_hash = '$token_hash'";
		 if( mysqli_query($conn, $sql)){  
		 
		       $sql = "SELECT * FROM users WHERE Token_hash = '$token_hash'";  
               $result = mysqli_query($conn,  $sql);
	          
               if(  mysqli_num_rows( $result ) == 1){ 
			   
			      // user account data storing in cookie
				   $rows  =  mysqli_fetch_assoc($result);

			    $user = array 
						( 
						  'id'=>$rows['id']
						);
						$user = json_encode($user); // user account data array to json
                        setcookie('user_id', $user, time() + (86400 * 150), "/"); // 86400 = 1 day 
				
			     $sql =  "UPDATE  users SET Token_hash = '', token_expired_at = null where Token_hash = '$token_hash'"; 
				 $result = mysqli_query($conn,   $sql  );
				 if( $result){ 
				            
					    $UserName = $rows['first_name'] ;
					    $_SESSION['log-in-message'] = "Welcome $UserName to Dashboard!" ; 
						
						// Users redirecting to Pyncparcel dashboard
						 echo  "<script> 
								    window.onload = function () {
					
								
									   document.getElementById('container').style.display = 'none';
									   document.getElementById('loader').style.display = 'block'; 
									   
									   setTimeout(function() {  
									   
										document.getElementById('loader').style.display = 'none'; 
										window.location.href = '../user-dashboard/index.php'; 
										
										}, 7000); 
                                    }										
						 </script> ";
				   
			    }
					  
			    }else{ 
			   
			       echo "<span style='color:red'> Something went wrong.</span> <a href='../index.php'>Please try later.</a>";
	               die();
			   
			   }			   
			   
		   
		 }else{ 
		    
		    echo "<span style='color:red'> Something went wrong.</span> <a href='../index.php'>Please try later.</a>";
	        die();
		 
		 }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pyncparcel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
<style type="text/css"> 
  button { 
   box-shadow:unset !important;
  } 
  element.style {
    box-shadow: unset;
}
img.pwd-show-hide, .show-hide {
    width: 30px;
    position: absolute;
    top: 4px;
    right: 7px;
    cursor: pointer;
}
#New_Password, #VerifyPassword{ 
    position: relative;
  }
.card {
    width: 400px;
    padding: 25px;
    margin: auto;
    margin-top: 30px;
}
body{ 
     background: #fcfcfd;
}
button{
    background: linear-gradient(45deg, #357d69, #0b020f) !important;
    border: 0px;
    width: 248px;
    display: block;
    margin-top: 10px; 
	border: 0px !important;
}
button:hover {
	background: linear-gradient(45deg,#0b020f, #357d69) !important;
}
.form-control:focus {
    color: unset;
    background-color: unset
    border-color: unset
    outline: 0;
    box-shadow: unset;
} 
.shake-button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: transform 0.3s ease-in-out; /* Smooth transition for non-shake changes */
}
.shake-button:hover {
  animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
  transform: translate3d(0, 0, 0); /* Ensures hardware acceleration */
  backface-visibility: hidden; /* Prevents flickering */
  perspective: 1000px; /* For 3D transformations */
}

@keyframes shake {
  10%, 90% {
    transform: translate3d(-1px, 0, 0);
  }
  20%, 80% {
    transform: translate3d(2px, 0, 0);
  }
  30%, 50%, 70% {
    transform: translate3d(-4px, 0, 0);
  }
  40%, 60% {
    transform: translate3d(4px, 0, 0);
  }
} 
 
 <!-- loader -->
:root {
	--hue: 223;
	--bg: hsl(var(--hue),90%,90%);
	--fg: hsl(var(--hue),90%,10%);
	--primary: hsl(var(--hue),90%,50%);
	--trans-dur: 0.3s;
	font-size: calc(16px + (32 - 16) * (100vw - 320px) / (2560 - 320));
}
.bike {
	display: block;
	margin: auto;
	width: 16em;
	height: auto;
}
.bike__body,
.bike__front,
.bike__handlebars,
.bike__pedals,
.bike__pedals-spin,
.bike__seat,
.bike__spokes,
.bike__spokes-spin,
.bike__tire {
	animation: bikeBody 3s ease-in-out infinite;
	stroke: var(--primary);
	transition: stroke var(--trans-dur);
}
.bike__front {
	animation-name: bikeFront;
}
.bike__handlebars {
	animation-name: bikeHandlebars;
}
.bike__pedals {
	animation-name: bikePedals;
}
.bike__pedals-spin {
	animation-name: bikePedalsSpin;
}
.bike__seat {
	animation-name: bikeSeat;
}
.bike__spokes,
.bike__tire {
	stroke: currentColor;
}
.bike__spokes {
	animation-name: bikeSpokes;
}
.bike__spokes-spin {
	animation-name: bikeSpokesSpin;
}
.bike__tire {
	animation-name: bikeTire;
}

/* Dark theme */
@media (prefers-color-scheme: dark) {
	:root {
		--bg: hsl(var(--hue),90%,10%);
		--fg: hsl(var(--hue),90%,90%);
	}
}

/* Animations */
@keyframes bikeBody {
	from { stroke-dashoffset: 79; }
	33%,
	67% { stroke-dashoffset: 0; }
	to { stroke-dashoffset: -79; }
}
@keyframes bikeFront {
	from { stroke-dashoffset: 19; }
	33%,
	67% { stroke-dashoffset: 0; }
	to { stroke-dashoffset: -19; }
}
@keyframes bikeHandlebars {
	from { stroke-dashoffset: 10; }
	33%,
	67% { stroke-dashoffset: 0; }
	to { stroke-dashoffset: -10; }
}
@keyframes bikePedals {
	from {
		animation-timing-function: ease-in;
		stroke-dashoffset: -25.133;
	}
	33%,
	67% {
		animation-timing-function: ease-out;
		stroke-dashoffset: -21.991;
	}
	to {
		stroke-dashoffset: -25.133;
	}
}
@keyframes bikePedalsSpin {
	from { transform: rotate(0.1875turn); }
	to { transform: rotate(3.1875turn); }
}
@keyframes bikeSeat {
	from { stroke-dashoffset: 5; }
	33%,
	67% { stroke-dashoffset: 0; }
	to { stroke-dashoffset: -5; }
}
@keyframes bikeSpokes {
	from {
		animation-timing-function: ease-in;
		stroke-dashoffset: -31.416;
	}
	33%,
	67% {
		animation-timing-function: ease-out;
		stroke-dashoffset: -23.562;
	}
	to {
		stroke-dashoffset: -31.416;
	}
}
@keyframes bikeSpokesSpin {
	from { transform: rotate(0); }
	to { transform: rotate(3turn); }
}
@keyframes bikeTire {
	from {
		animation-timing-function: ease-in;
		stroke-dashoffset: 56.549;
		transform: rotate(0);
	}
	33% {
		stroke-dashoffset: 0;
		transform: rotate(0.33turn);
	}
	67% {
		animation-timing-function: ease-out;
		stroke-dashoffset: 0;
		transform: rotate(0.67turn);
	}
	to {
		stroke-dashoffset: -56.549;
		transform: rotate(1turn);
	}
}
#bike {
    position: absolute;
    top: 0px;
    left: 0px;
    bottom: 0px;
    right: 0px;
    margin: auto;
    height: 300px;
    width: 300px;
} 
@media only screen and (min-width: 200px) and (max-width: 767px) { 
    
.card {

 width: 280px !important;
} 
.card-body {
	 padding: 0px;
}
}
  </style>
</head>
<body>
<div class="container" id='container'>
  <div class="card" style="width:400px;">
    <img class="card-img-top" src="<?php echo $base_url; ?>assets/img/logo.png" alt="Card image" style="width: 220px; margin:auto">
    <div class="card-body">
      	     <form action="<?php echo $base_url; ?>user-area/new-password.php?token_hash=<?php echo $token_hash ?>" method="GET">
			    <div class="col-md-12 mb-3">
				    <label for="pwd">New Password</label>
					<div id="New_Password"> 
					 <input  name='pwd'  class="form-control new_pwd" id="pwd" type="password" placeholder="New Password">
					 <img class="pwd-show-hide"  src="../assets/img/show-pwd.png" alt="show password" />
					 	 <p style='color:red'></p>
					</div>
				</div>
			    <div class="col-md-12 mb-3">
				    <label for="Verifypwd">Verify password</label>
					<div id="VerifyPassword"> 
					 <input autocomplete name='pwd'  class="form-control Verifypwd" id="Verifypwd" type="password" placeholder="Verify password">
					 <img class="show-hide"  src="../assets/img/show-pwd.png" alt="show password" />
					 <p style='color:red'> </p>
					</div>
				</div>
				<!-- Submit Button-->
				<div class="d-grid text-center"> 
				  <input hidden type="text" name="new_password"  />
				  <input hidden type="text" name="token_hash" value="<?php echo  $token_hash ?>"  />
				  <button  name="sing-in" class="btn btn-primary" type="submit"> 
				      <img class="spinner" style="display: none;" width="20px" src="../admin dashboard/assets/img/spinner.gif" alt=""> 
					  Sign in 
				 </button> 
				</div>
		    </form>
    </div>
  </div>
</div> 
<!-- Redirecting to dashboard --> 
<div style='display:none;' id="loader"> 
   <div id="bike"> 
	   <svg class="bike" viewBox="0 0 48 30" width="48px" height="30px">
		<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
			<g transform="translate(9.5,19)">
				<circle class="bike__tire" r="9" stroke-dasharray="56.549 56.549" />
				<g class="bike__spokes-spin" stroke-dasharray="31.416 31.416" stroke-dashoffset="-23.562">
					<circle class="bike__spokes" r="5" />
					<circle class="bike__spokes" r="5" transform="rotate(180,0,0)" />
				</g>
			</g>
			<g transform="translate(24,19)">
				<g class="bike__pedals-spin" stroke-dasharray="25.133 25.133" stroke-dashoffset="-21.991" transform="rotate(67.5,0,0)">
					<circle class="bike__pedals" r="4" />
					<circle class="bike__pedals" r="4" transform="rotate(180,0,0)" />
				</g>
			</g>
			<g transform="translate(38.5,19)">
				<circle class="bike__tire" r="9" stroke-dasharray="56.549 56.549" />
				<g class="bike__spokes-spin" stroke-dasharray="31.416 31.416" stroke-dashoffset="-23.562">
					<circle class="bike__spokes" r="5" />
					<circle class="bike__spokes" r="5" transform="rotate(180,0,0)" />
				</g>
			</g>
			<polyline class="bike__seat" points="14 3,18 3" stroke-dasharray="5 5" />
			<polyline class="bike__body" points="16 3,24 19,9.5 19,18 8,34 7,24 19" stroke-dasharray="79 79" />
			<path class="bike__handlebars" d="m30,2h6s1,0,1,1-1,1-1,1" stroke-dasharray="10 10" />
			<polyline class="bike__front" points="32.5 2,38.5 19" stroke-dasharray="19 19" />
		</g>
	  </svg> 
	 <p style='text-align:center;'>You are Redirecting to Pyncparcel dashboard</p>
   </div>
   
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> 
<script type="text/javascript"> 
		
		$(document).ready(function(){
	 
	    //=============password show and hide===================
	    $('.pwd-show-hide').click(function(){ 
		
		   if( $(".new_pwd[name='pwd']").attr('type') == 'password'){
			   
			  $(".new_pwd[name='pwd']").attr('type', 'text');
			  
		   }else{
			   
			 $(".new_pwd[name='pwd']").attr('type', 'password');
		   } 
		   
	    }); 
	    $('.show-hide').click(function(){ 
		
		   if( $("#Verifypwd[name='pwd']").attr('type') == 'password'){
			   
			  $("#Verifypwd[name='pwd']").attr('type', 'text');
			  
		   }else{
			   
			 $("#Verifypwd[name='pwd']").attr('type', 'password');
		   } 
		   
	    }); 
	 
			$new_pwd   =  $(".new_pwd").val();
		    $(".new_pwd").on('input', function() {
		        $Verify_pwd = $(".Verifypwd").val();
		        $(".Verifypwd").css('border', '1px solid red');
		        $('#VerifyPassword p').text("");

		        $EleNewPwd = $(this);
		        $new_pwd = $(this).val();
		        if ($new_pwd.length < 8) {
		            $('#New_Password p').css('color', 'red');
		            $EleNewPwd.css('border', '1px solid red');
		            $('#New_Password p').text('Password must contain at least 8 characters with a capital letter ');
		        } else if ($new_pwd.length >= 8 && /[A-Z]/.test($new_pwd)) {
		            $(".new_pwd").css('border', '2px solid #ddd');
		            $('#New_Password p').css('color', '#205e22');
		            $('#New_Password p').text('Good Password!');

		            if ($new_pwd == $Verify_pwd) {
		                $('#VerifyPassword p').text("Password matched!");
		                $('#VerifyPassword p').css('color', '#205e22');
		                $(".Verifypwd").css('border', '1px solid #ddd');
		            } else {
		                $('#VerifyPassword p').css('color', 'red');
		                $(".Verifypwd").css('border', '1px solid red');
		                $('#VerifyPassword p').text("Password didn't match");
		            }
		        }
		    });

		    $("#Verifypwd").on('input', function() {
		        $VerifyPwd = $(this).val();
		        $input = $(this);

		        if ($new_pwd.length >= 8 && /[A-Z]/.test($new_pwd)) {
		            $('#VerifyPassword p').css('color', 'red');
		            $input.css('border', '1px solid red');
		            $('#VerifyPassword p').text("Password didn't match");

		            if ($new_pwd == $VerifyPwd) {
		                $('#VerifyPassword p').text("Password matched!");
		                $('#VerifyPassword p').css('color', '#205e22');
		                $input.css('border', '1px solid #ddd');
		            }
		        }
		    });

        // form submission 
       		
        		$('form').submit(function(event) {
					event.preventDefault();
			    if( $new_pwd.length >= 8  && /[A-Z]/.test( $new_pwd) ){ 
			          
			    if( $new_pwd == $(".Verifypwd").val() ){ 
				     // alert('yes'); 
					 let form = this;
					 form.submit(); 
				}else{ 
				
			          $(".Verifypwd").css('border', '1px solid red');
				} 
				
			 }else{ 
			        $('button').addClass('shake-button');
			        $(".new_pwd").css('border', '1px solid red');
			        $(".Verifypwd").css('border', '1px solid red');
			 
			 }
        }); 
	   
	   
    }); // document end 
	 
	 
	 
</script>
</body>
</html>
