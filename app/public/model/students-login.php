<?php

if (isset($_POST['name'])) {
	$sname = $_POST['name'];
	$spassword = $_POST['pass'];

	if (empty($sname)) {
      	$data = ['status' => 0, 'message' => 'Student name is required'];
        echo json_encode($data);
        exit();
	}

	if (!preg_match('/^[a-zA-Z ]+$/', $sname)) {
      	$data = ['status' => 0, 'message' => 'Invalid student name'];
        echo json_encode($data);
        exit();
	}

	if (empty($spassword)) {
      	$data = ['status' => 0, 'message' => 'Password is required'];
        echo json_encode($data);
        exit();
	}

	require dirname(dirname(__DIR__)) . '/private/controller/db.php';

	$conn = database();

	$sql ="SELECT * FROM studentinfo WHERE studentName='$sname'AND studentpassword='$spassword' limit 1";
	$result= mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)===1){
	    $row=mysqli_fetch_assoc($result);

    	$token = rand();
    	setcookie('students', $token, time() + 28800, '/');
    	$studentNumber = $row['studentNumber'];

    	$sql = "INSERT INTO students_login (user_token,studentNumber) VALUES ('$token', '$studentNumber')";

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