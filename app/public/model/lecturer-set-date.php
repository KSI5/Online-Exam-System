<?php

if (isset($_FILES['paper'])) {

	$date = $_POST['date'];
	$time = $_POST['time'];
	$module = $_POST['module_code'];
	$file = $_FILES['paper']['name'];
	$type = $_FILES['paper']['type'];
	$size = $_FILES['paper']['size'];
	$tmp  = $_FILES['paper']['tmp_name'];
	
	if ($type != 'application/pdf') {
	  $data = ["status" => 0, "message" => "Only .PDF file formats are allowed"];
	  echo json_encode($data);
	  return;
	}

	if (round($size / 1000) > 3000) {
	  $data = ["status" => 0, "message" => "File is too large, max-allowed-size is 3MB"];
	  echo json_encode($data);
	  return;
	}

	if (strtotime($date) < strtotime(date("Y-m-d"))) {
		$data = ["status" => 0, "message" => "Error, please set exam date for current or future date"];
	  	echo json_encode($data);
	  	return;
	}

	if (strtotime($date) >= strtotime(date("Y-m-d"))) {
		
		if (strtotime($time) < strtotime(date("H:i"))) {
			$data = ["status" => 0, "message" => "Invalid time set"];
	  		echo json_encode($data);
	  		return;
		}

	}

	require dirname(dirname(__DIR__)) . '/private/model/functions.php';
	$path = dirname(dirname(__DIR__)) . '/public/uploads/exams/' . $module;

	if (!is_dir($path)) {
	  mkdir($path);
	}

	$name = $path . '/' . $module . '.pdf';

	if(move_uploaded_file($tmp, $name))
	{
	  examdep_set_exam($date, $time, substr($path, 26) . '.pdf', strtoupper($module));
	}

}
