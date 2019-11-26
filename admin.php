<?php
session_start();
if(empty($_SESSION["username"]) || $_SESSION["loggedin"]==false)
	{
	 header("location:login.php");
	}

require_once "dbconnect.php";

if (isset($_POST['submit'])) 
	{
		if (empty($_POST['task'])) 
		{
			echo "<script type='text/javascript'> alert('You must fill in the task');</script>";
		}
		elseif(empty($_POST['start_date']))
		{
			echo "<script type='text/javascript'> alert('You must fill in the start date');</script>";
		}
		elseif(empty($_POST['end_date']))
		{
			echo "<script type='text/javascript'> alert('you must fill the end date');</script>";
		}
		elseif(empty($_POST['username']))
		{
			echo "<script type='text/javascript'> alert('you must fill the username');</script>";
		}
		elseif(empty($_POST['client']))
		{
			echo "<script type='text/javascript'> alert('you must fill the client name');</script>";
		}
		
		else
		{
			$username = $_POST['username'];
			$usercheck = mysqli_query($conn, "SELECT username from userinfo where username='$username' ");
			$count = mysqli_num_rows($usercheck);
			if($count==0)
			{
				echo "<script type='text/javascript'> alert('username does not exist');</script>";
			}
			else
			{
				$client = $_POST['client'];
				$usercheck = mysqli_query($conn, "SELECT name from client where name='$client' ");
				$count = mysqli_num_rows($usercheck);
				if($count==0)
				{
					echo "<script type='text/javascript'> alert('client does not exist');</script>";
				}
				else
				{
					$task = $_POST['task'];
					$start_date = $_POST['start_date'];
					$end_date = $_POST['end_date'];
					
					$sql = "INSERT INTO task (description,start_date,end_date,username,client) VALUES ('$task','$start_date','$end_date','$username','$client')";
					mysqli_query($conn, $sql);
				}
			}
			
		}
	}



if (isset($_GET['del_task'])) {
	$desc = $_GET['del_task'];

	mysqli_query($conn, "DELETE FROM task WHERE description= '$desc' ");
	
}	




?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Kanit:500|Patua+One|Bowlby+One+SC&display=swap" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- <script>
	$(document).ready(function(){
		$("#option").hide();
		$("#register").click(function(){
  $("#option").toggle();
});
	});
</script> -->
	<title></title>
	<style>
        header{
            /* background: url(admin background.jpg);
            background-size: cover;
            background-position: center;
            min-height: 800px; */
        }
		
	</style>
</head>
<body>
<!-- <div style="display: inline;">
	<div id="register">Register</div>
	<div id="option">
		<a href="registeremp.php">Employee</a><br>
		<a href="registerclient.php">client</a>
	</div>
	<div><a href="logout.php">Logout</a></div>
	
</div> -->
 <!-- Dharam code for css -->
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


<!-- <form method="post" action="" class="input_form">
	
		<input type="text" name="task" placeholder="task" class="task_input">
		<input type="date" name="start_date" class="task_input">
		<input type="date" name="end_date" class="task_input">
		<input type="text" name="username" placeholder="username" class="task_input">
		<input type="text" name="client" placeholder="client name" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form> -->
	


	<section class="container section" id="register">
    <div class="row">
        <div class="col s12 l3">
            <h1 class="center" style="font-family: 'Bowlby One SC', cursive;">Add Task Details</h1>
            <!-- <p>Breathe in breathe out and have patience</p> -->
        </div>
        <div class="col s12 l7 push-l2">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="input_form"> 
                <div class="input-field">
                    <!-- <i class="material-icons prefix">person</i> -->
                    <input type="text" id="task">
                    <label for="task">Task</label>
                </div>

                <div class="input-field">
                    <!-- <i class="material-icons prefix">email</i> -->
                    <input type="text" id="startDate" class="datepicker">
                    <label for="startDate">Start Date</label>
                </div>
                <div class="input-field">
                    <!-- <i class="material-icons prefix">email</i> -->
                    <input type="text" id="endDate" class="datepicker">
                    <label for="endDate">End Date</label>
                </div>

                <div class="input-field col s12 l6">
                    <input type="text" id="username">
                    <label for="username">Username</label>
                </div>
                <div class="input-field col s12 l6">
                    <input type="text" id="cliet">
                    <label for="client">Client</label>
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
  				  <i class="material-icons right">send</i>
  				</button>

            </form>
        </div>
    </div>
</section>

<section class="center teal lighten-2">
<h3 style=" font-family: 'Patua One', cursive; color:#263238; padding:8px;">Task details</h3>
</section>

	<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th>START</th>
			<th>END</th>
			<th>USER</th>
			<th>CLIENT</th>
			<th>STATUS</th>
			<th style="width: 40px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($conn, "SELECT * FROM task");

		$i = 1; while ($row = mysqli_fetch_array($tasks))  { ?>	
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['description']; ?> </td>
				<td class="task"> <?php echo $row['start_date']; ?> </td>
				<td class="task"> <?php echo $row['end_date']; ?> </td>
				<td class="task"> <?php echo $row['username']; ?> </td>
				<td class="task"> <?php echo $row['client']; ?> </td>
				<td class="task"> <?php if($row['completed']==1)
				echo "completed";
				else
				echo ""; ?> </td>
				<td class="delete" align="center"> 
					<a href="admin.php?del_task=<?php echo $row['description'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script>
    $(document).ready(function(){
        $('.sidenav').sidenav();
		$('.datepicker').datepicker();
    });
    
</script>
</body>
</html>
