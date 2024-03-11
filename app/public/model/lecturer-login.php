<?php

if (isset($_POST['num'])) {
	$snum = $_POST['num'];
	$spassword = $_POST['pass'];

	if (empty($snum)) {
      	$data = ['status' => 0, 'message' => 'Staff number is required'];
        echo json_encode($data);
        exit();
	}

	if (!preg_match('/^[0-9]{7}+$/', $snum)) {
      	$data = ['status' => 0, 'message' => 'Invalid staff number'];
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

	$sql ="SELECT * FROM staffinfo WHERE staffNumber='$snum'AND staffpassword='$spassword' limit 1";
	$result= mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)===1){
	    $row=mysqli_fetch_assoc($result);

    	$token = rand();
    	setcookie('lecturer', $token, time() + 28800, '/');

    	$sql = "INSERT INTO lecturer_login (user_token,staffNumber) VALUES ('$token', '$snum')";

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