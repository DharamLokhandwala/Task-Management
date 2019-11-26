<?php
session_start();
if(empty($_SESSION["username"]) || $_SESSION["loggedin"]==false)
	{
	 header("location:login.php");
	}

require_once "dbconnect.php";

$username=$_SESSION["username"];
/*
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
*/


if (isset($_GET['del_task'])) {
	$desc = $_GET['del_task'];
	//$mysqli_query="SELECT completed FROM task WHERE description= '$desc'";
	$row1= mysqli_fetch_assoc(mysqli_query($conn, "SELECT completed FROM task WHERE description= '$desc' "));
	//echo $row1["completed"];
	if($row1["completed"]==0)
	{mysqli_query($conn, "UPDATE task SET completed=1 WHERE description= '$desc' "); echo"here";}
	else
		mysqli_query($conn, "UPDATE task SET completed=0 WHERE description= '$desc' ");
	print_r(mysqli_error($conn));
}	




?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Kanit:500|Patua+One|Bowlby+One+SC&display=swap" rel="stylesheet">
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("#option").hide();
		$("#register").click(function(){
  $("#option").toggle();
});
	});
</script>		-->
	<title></title>
</head>
<body>
<!--<div style="display: inline;">
	<div id="register">Register</div>
	<div id="option">
		<a href="registeremp.php">Employee</a><br>
		<a href="registerclient.php">client</a>
	</div>	
	<div><a href="logout.php">Logout</a></div>
	
</div>-->
<header>
        <nav class="navbar-wrapper teal lighten-2">
            <div class="container">
                <a href="" class="sidenav-trigger" data-target="mobile-menu">
                        <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down nav-items">
                  
                    <li><a href="logout.php">Logout</a></li>
                    
				</ul>
				<ul class="left hide-on-med-and-down nav-items">
                  
                    <li>Employee Task Details</li>
                    
                </ul>

                <ul class="sidenav grey lighten-2" id="mobile-menu">
                    
                    <li><a href="#events">Logout</a></li>
                   
                </ul>
            </div>
        </nav>
    </header>


<!--
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="input_form">
	
		<input type="text" name="task" placeholder="task" class="task_input">
		<input type="date" name="start_date" class="task_input">
		<input type="date" name="end_date" class="task_input">
		<input type="text" name="username" placeholder="username" class="task_input">	
		<input type="text" name="client" placeholder="client name" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>		-->
	
	<table>
	<thead>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th>START</th>
			<th>END</th>
		<!--	<th>USER</th>	-->
			<th>CLIENT</th>
			<th>STATUS</th>
			<th style="width: 40px;">Mark complete</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($conn, "SELECT * FROM task where username='$username' ");

		$i = 1; while ($row = mysqli_fetch_array($tasks))  { ?>	
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['description']; ?> </td>
				<td class="task"> <?php echo $row['start_date']; ?> </td>
				<td class="task"> <?php echo $row['end_date']; ?> </td>
			<!--	<td class="task"> <?php echo $row['username']; ?> </td>		-->
				<td class="task"> <?php echo $row['client']; ?> </td>
				<td class="task"> <?php if($row['completed']==1)
				echo "completed";
				else
				echo ""; ?> </td>
				<td class="delete" align="center"> 
					<a href="employee.php?del_task=<?php echo $row['description'] ?>">O</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>


</body>
</html>
