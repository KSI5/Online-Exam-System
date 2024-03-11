<?php

if (isset($_POST['staffEmail'])) {
	$staffEmail = $_POST['staffEmail'];
	$staffPassword = $_POST['staffPassword'];

	if (empty($staffEmail)) {
      	$data = ['status' => 0, 'message' => 'Staff Email is required'];
        echo json_encode($data);
        exit();
	}

	if (!filter_var($staffEmail, FILTER_VALIDATE_EMAIL)) {
      	$data = ['status' => 0, 'message' => 'Invalid Staff Email'];
        echo json_encode($data);
        exit();
	}

	if (empty($staffPassword)) {
      	$data = ['status' => 0, 'message' => 'Password is required'];
        echo json_encode($data);
        exit();
	}

	require dirname(dirname(__DIR__)) . '/private/controller/db.php';

	$conn = database();

	$sql ="SELECT * FROM staffinfo WHERE staffEmail='$staffEmail'AND staffpassword='$staffPassword' limit 1";
	$result= mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)===1){
	    $row = mysqli_fetch_assoc($result);

    	$token = rand();
    	setcookie('examdep', $token, time() + 28800, '/');
    	
    	$sql = "INSERT INTO examdep_login (user_token,staffEmail) VALUES ('$token', '$staffEmail')";

    	if($conn->query($sql) === TRUE)
    	{

	      	$data = ['status' => 1, 'message' => 'You Have Successfully Logged in'];
	        echo json_encode($data);
	        exit();

    	}
    	else
    	{

	      	$data = ['status' => 0, 'message' => 'Internal System Error'];
	        echo json_encode($data);
	        exit();
	        
    	}
    }
    else{


      	$data = ['status' => 0, 'message' => 'You Have Entered Incorrect Password'];
        echo json_encode($data);
        exit();

    }

}

?>