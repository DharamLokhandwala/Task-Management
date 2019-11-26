<?php

session_start();
if(empty($_SESSION["username"]) || $_SESSION["loggedin"]==false)
    {
     header("location:login.php");
    }

// Include config file
require_once "dbconnect.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $name = $dept_name = $service = "";
$username_err = $password_err = $confirm_password_err = $name_err = $service_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") { 
 
    // Validate username
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter a username.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT username FROM userinfo WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 3){
        $password_err = "Password must have atleast 3 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	//validate name 
	if(empty(trim($_POST["name"])))
	{
		$name_err= "Please enter name";
	}
	else{
		$name=trim($_POST["name"]);
	}

    if(empty(trim($_POST["service"])))
    {
        $name_err= "Please choose the service";
    }
    else{
        $name=trim($_POST["service"]);
    }

	//validate department name
    /*            	if(empty(trim($_POST["dept_name"])))
                	{
                		$dept_name_err = "Enter department name";
                	}
                	else
                	{	
                		$dept_nm=$_POST["dept_name"];
                		$sql2="SELECT * FROM department WHERE dept_name='$dept_nm'";
                		$result=mysqli_query($conn,$sql2);
                		$row=mysqli_num_rows($result);
                		if($row==0)
                		{
                			$dept_name_err="department name not found";
                		}
                		else{
                			$dept_name=trim($_POST["dept_name"]);
                		}
                	}  
	//find dept_id for the given name
	$dept_id_fetch = "SELECT dept_id FROM department WHERE dept_name='$dept_name'";
	$result_id = mysqli_query($conn,$dept_id_fetch);
	$pre_dept_id=mysqli_fetch_assoc($result_id);
	$dept_id=$pre_dept_id["dept_id"];          */
	
    $email=$_POST['email'];
    $service=$_POST['service'];
	//$contact=(int)$_POST['contact'];
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($service_err))
	{
        
        // Prepare an insert statement
        //$sql1 = "INSERT INTO client (username, password) VALUES (?, ?)";
		//mysqli_query($conn,$sql1);
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        $client_insert = "INSERT INTO client (name, username,email,password) VALUES ('$name','$username','$email','$param_password')" ;
        $client_insert2 = "INSERT INTO services VALUES ('$username','$service')" ;
		//$conn->query($employee_insert);
		//mysqli_query($conn,$employee_insert);
		
        if(mysqli_query($conn, $client_insert) && mysqli_query($conn, $client_insert2)){
            // Bind variables to the prepared statement as parameters
            //$stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            //$param_username = $username;
            //$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
			//echo("Error description: " . mysqli_error($conn));
			
            // Attempt to execute the prepared statement
            //if($stmt->execute()){
                // Redirect to login page
                header("location: admin.php");
            } 
                else{
                    echo("Error description: " . mysqli_error($conn));
                echo "Something went wrong. Please try again later.";

            }
        
         
        // Close statement
        //$stmt->close();
    }
    
    // Close connection
    $conn->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Kanit:500|Patua+One|Bowlby+One+SC&display=swap" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ 
        }

    </style>



</head>
<body>
<header>
        <nav class="navbar-wrapper teal lighten-2">
            <div class="container">
                <a href="" class="sidenav-trigger" data-target="mobile-menu">
                        <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down nav-items">
                    <li ><a href="registeremp.php">Register Employee</a> </li>
                    <li><a href="registerclient.php">Register Client</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>

                <ul class="sidenav grey lighten-2" id="mobile-menu">
                    <li><a href="#">Register Employee</a> </li>
                    <li><a href="#aboutcz">Register Client</a></li>
                    <li><a href="#events">Logout</a></li>
                   
                </ul>
            </div>
        </nav>
    </header>





    <section class="wrapper container">
        <div class="row">

            <div class="col s12 l3">
            <h1 class="center" style="font-family: 'Bowlby One SC', cursive; padding-top:120px;">Add Client Details</h1>
            </div>

            <div class="col s12 l7 push-l2">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="padding-top: 75px;"> 
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" id="username">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>

		    	<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
		    	<div class="form-group ">
                    <label>E-mail id</label>
                    <input type="email" name="email" class="form-control" >
                    <span class="help-block"></span>
                </div>
		    	<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>NAME</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    <span class="help-block"><?php echo $name_err; ?></span>
                </div>
        
		    	<div class="form-group <?php echo (!empty($service_err)) ? 'has-error' : ''; ?>">
                    <label>Service</label>
                    <input type="text" name="service" class="form-control" value="<?php echo $service; ?>">
                    <span class="help-block"><?php echo $service_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
              <!--  <p>Already have an account? <a href="login.php">Login here</a>.</p> -->
            </form>
            
            </div>
        </div>
        
    </section>    
</body>
</html>