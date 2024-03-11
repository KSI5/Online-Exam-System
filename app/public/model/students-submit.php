<?php

if (isset($_FILES['paper'])) {

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

	require dirname(dirname(__DIR__)) . '/private/model/functions.php';

	if(students_check_submission_time($module) == false)
	{
		$data = ["status" => 0, "message" => "Exam time has lapsed"];
		echo json_encode($data);
		return;
	}

	$path = dirname(dirname(__DIR__)) . '/public/uploads/students/exams/' . $module;
	$new_name = $path . '/' . identifiyer()['studentNumber'] . '_' . $module . '_EXAM_' . date("Ymd-H i s") . '.pdf';

	if (!is_dir($path)) {
	  mkdir($path);
	}

	$name = identifiyer()['studentNumber'] . '_' . $module . '_EXAM_' . date("Ymd-H i s") . '.pdf';

	if(move_uploaded_file($tmp, $new_name))
	{
	  students_submission($name, strtoupper($module));
	}

}
