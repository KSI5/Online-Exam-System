<?php
//Get user id

function identifiyer()
{
	if (is_logged_in(user()) == TRUE) {
		
		$cookie = $_COOKIE[user()];

		if (user() == 'students') {

			$count = 0;
			$html = '';
			$sql = "SELECT * FROM studentinfo INNER JOIN students_login ON students_login.studentNumber = studentinfo.studentNumber ORDER BY id DESC LIMIT 1";
			$result = mysqli_query(db(), $sql);
			
			$row = mysqli_fetch_assoc($result);

			return [
				'studentName' => $row['studentName'],
				'studentNumber' => $row['studentNumber'],
				'studentEmail' => $row['studentEmail']
			];
			
		}

		if (user() == 'lecturer') {

			$count = 0;
			$html = '';
			$sql = "SELECT * FROM staffinfo INNER JOIN lecturer_login ON lecturer_login.staffNumber = staffinfo.staffNumber ORDER BY id DESC LIMIT 1";
			$result = mysqli_query(db(), $sql);
			
			$row = mysqli_fetch_assoc($result);

			return [
				'staffName' => $row['staffName'],
				'staffNumber' => $row['staffNumber'],
				'staffEmail' => $row['staffEmail']
			];
			
		}

		if (user() == 'examdep') {

			$count = 0;
			$html = '';
			$sql = "SELECT * FROM staffinfo INNER JOIN examdep_login ON examdep_login.staffEmail = staffinfo.staffEmail ORDER BY id DESC LIMIT 1";
			$result = mysqli_query(db(), $sql);
			
			$row = mysqli_fetch_assoc($result);

			return [
				'staffName' => $row['staffName'],
				'staffNumber' => $row['staffNumber'],
				'staffEmail' => $row['staffEmail']
			];
			
		}

	}
}

//Return Database path
function get_database()
{
	return private_dir() . '/controller/db.php';
}

/**
 * Check if user is logged in
 * Return true or false
 **/
function is_logged_in($user)
{
	if (isset($_COOKIE[$user])) {

		return select_cookie_from_db($user, $_COOKIE[$user]);

	}

	return false;
}

function select_cookie_from_db($user, $cookie)
{
	$table = $user . "_login";
	$sql = "SELECT * FROM $table WHERE user_token = '$cookie'";
	$result = db()->query($sql);

	if (mysqli_num_rows($result) > 0) {
		return true;
	}

	setcookie($user, 1, time() - 3600, '/');

	return false;
}

//Private Directory path
function private_dir()
{
	return dirname(__DIR__);
}

/* Get file path from public directory */
function public_dir($filename)
{
	$path = str_replace("\\", "/", dirname(dirname(__DIR__)));
	return $path . '/public/views/layouts/' . $filename . '.php';
}

/* Error Function */
function error($file)
{
	return public_dir('error/'.$file);
}

/* Get Subdomain */
function user()
{
	return explode('.', $_SERVER['SERVER_NAME'])[0];
}

/*Navigation*/
function navigation()
{
	return public_dir('includes/' . user() . '-nav.inc');
}

/* Require File */
function get_file($file)
{
	if ($file == 'header' || $file == 'footer') {
		return public_dir('includes/' . $file . '.inc');
	}
	
	return public_dir('includes/' . user() . '-' . $file . '.inc');
}


function db()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "examonlineportal";
	// Establishing Connection
	$conn = new mysqli($servername, $username, $password,$db);
	// Check connection
	if ($conn->connect_error) {
	   die("Connection failed: " . $conn->connect_error);
	}

	return $conn;
}

function logout($action)
{
	$action = substr($action, -6);
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

/****** End of main functions *********/

/**
 *  Students Functions 
 * 	Check if file exists
 * 	Require file or 404
 * */
function students_home($action)
{

	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function students_exams($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);

		return my_exams('includes/table.inc');
	}

	require error(404);
}

function my_exams($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);

}

function students_submitted_exams()
{
	$html = '';
	$count = 0;
	$studentNumber = identifiyer()['studentNumber'];

	$sql = "SELECT * FROM examoutput INNER JOIN students_marks ON students_marks.transactionID = examoutput.transactionID AND examoutput.studentNumber = '$studentNumber' AND email_sent = 1 ORDER BY uploadTime DESC";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result)) {

		$html .= '<tr>
	    <td>' . ++$count . '</td>
	    <td>' . $row['moduleCode'] . '</td>
	    <td>' . $row['examDate'] . '</td>
	    <td>' . substr($row['uploadTime'], 11) . '</td>
	    <td>' . $row['marks'] . '%</td>
	  </tr>';

	}

	return $html;
}

function students_marks($transactionID)
{
	$sql = "INSERT INTO students_marks (transactionID, marks, mark_status, email_sent) VALUES ('$transactionID', '0', '0', '0')";
	$result = mysqli_query(db(), $sql);
}

function students_login($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function students_modules()
{
	$studentNumber = identifiyer()['studentNumber'];
	$count = 0;
	$html = '';
	$sql = "SELECT * FROM studentmodule WHERE studentNumber = '$studentNumber'";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result)) {

		$html .= '<a href="?action=my-module&code='.$row['moduleCode'].'">'.$row['moduleCode'].'</a>';

	}

	return $html;
}

function my_module($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		// require get_file('download-table');
		return;
	}

	require error(404);
}

function get_module_code()
{

	if (isset($_GET['code']) && !empty($_GET['code'])) {
		return strtoupper($_GET['code']);
	}

}

function download_path()
{
	if (isset($_GET['dp']) && !empty($_GET['dp'])) {
		return $_GET['dp'];
	}

	require error(404);
}

function view_my_module()
{
	$html = '';
	$module_code = get_module_code();
	$date = date("Y-m-d");
	$download_btn = '';
	$submit_btn = '';
	$time_output = '00:00:00';

	/*Select student current exam*/

	$sql = "SELECT * FROM examsetup WHERE moduleCode = '$module_code' AND examDate = '$date' GROUP BY examTime, examDate DESC LIMIT 1";
	$result = mysqli_query(db(), $sql);
	
	$row = mysqli_fetch_assoc($result);
	
	if (isset($row['examTime']) == null) {
		return '<h3 class="text-center alert alert-danger"> Sorry, you currently have no exam for this module<h3>';
	}

	$time = strtotime($row['examTime']);
  $increment = strtotime('+2 hours', $time);
  $endTime = date('H:i:s', $increment);
  $remaining = $increment - strtotime(date("H:i:s"));
  $startTime = str_replace(":", "", $row['examTime']);
  $currTime = str_replace(":", "", date("H:i:s"));
  $end = str_replace(":", "", $endTime);

  if ($startTime > $currTime) {
  		$timer = false;
  }
  
  if($startTime < $currTime)
  {
  	$timer = true;
  }

  if($end < $currTime)
  {
  	$timer = true;
  }

  if ($timer == true) {
  	$time_output = date("H:i:s", strtotime("-1 hour", $remaining));
  	$download_btn = '<a href="?action=student-download&dp='.substr($row['examPaperPDF'], 9, 7).'.pdf" class="btn btn-warning" download>
            <i class="fa fa-download"></i>
          </a>';
    $submit_btn = '<a href="?action=students-upload&code='.$module_code.'" class="btn btn-success">
            <i class="fa fa-upload"></i>
          </a>';
  }

  $time_format = str_replace(":", "", $time_output);

  $format = [
  	'h' => substr($time_format, 0, 2),
  	'm' => substr($time_format, 2, 2),
  	's' => substr($time_format, 4, 2)
  ];
  
  return '<tr>
        <td>'.$row['examDate'].'</td>
        <td>'.$row['examTime'].'</td>
        <td id="time-remaining">
        	<span id="h">' . $format["h"] . '</span> :
        	<span id="m">' . $format["m"] . '</span> :
        	<span id="s">' . $format["s"] . '</span>
        </td>
        <td>
          ' . $download_btn . '
        </td>
        <td>
          ' . $submit_btn . '
        </td>
      </tr>';

}

function check_students_start_time($module_code, $examDate)
{
	$sql = "SELECT * FROM students_start_time WHERE moduleCode = '$module_code' AND examDate = '$examDate'";
	$result = db()->query($sql);

	if (mysqli_num_rows($result) > 0) {
		return true;
	}

	return false;

}

function students_check_submission_time($module)
{
	$examDate = date("Y-m-d");
	$studentNumber = identifiyer()['studentNumber'];
	$sql = "SELECT * FROM students_start_time WHERE moduleCode = '$module' AND examDate = '$examDate' AND studentNumber = $studentNumber";
	$results = db()->query($sql);

	$row = mysqli_fetch_assoc($results);

	$time = strtotime($row['startTime']);
  $startTime = strtotime('+2 hours', $time);
  $endTime = date('H:i:s', $startTime);

	if (strtotime(date("H:i:s")) > strtotime($endTime)) {
		return false;
	}

	return true;
}

function students_start_time($module_code)
{

	$examDate = date("Y-m-d");

	if (check_students_start_time($module_code, $examDate) == false) {
		
		$studentNumber = identifiyer()['studentNumber'];
		$startTime = date("H:i:s");

		$sql = "INSERT INTO students_start_time (studentNumber, moduleCode,startTime, examDate) VALUES ('$studentNumber', '$module_code', '$startTime', '$examDate')";
		db()->query($sql);

	}
	else
	{
		exit;
	}
	
}

function student_download()
{
	$module_code = substr(download_path(), 0, 7);
	students_start_time($module_code);

	$path = dirname(dirname(__DIR__)) . '/public/uploads/exams/' . $module_code . '/' . download_path();

	if (file_exists($path)) {
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($path) . '"');
		header('Cache-Control: must-revalidate');
		header('Expires: 0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($path));
		readfile($path);

		exit();

	}

}

function students_upload($action)
{

	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function students_uploader()
{
	if (file_exists(get_file('uploader'))) {
		return get_file('uploader');
	}
	require error(404);
}

function students_char()
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$first = substr((str_shuffle($chars)), 0, 4);
	$second = substr(identifiyer()['studentNumber'], 0, 4);
	$third = rand(100, 999);
	$fourth = $third % 7; 

	return $first . $second . '-' . $third . $fourth;
}

function students_submission($file, $module)
{
 
 	$date = date("Y-m-d");
	$student = identifiyer()['studentNumber'];
	$startTime = date("Y-m-d H:i:s");
	$uploadTime = date("Y-m-d H:i:s");
	$transactionID = students_char();

	$file = $student . '_' . $module . '_EXAM_' . date("Ymd-H i s") . '.pdf'; 

	$sql = "INSERT INTO examoutput (
		transactionID,
		startTime,
		uploadTime,
		examDate,
		answerPaperPDF,
		studentNumber,
		moduleCode
	) VALUES (
		'$transactionID', 
		'$startTime', 
		'$uploadTime', 
		'$date', 
		'$file', 
		'$student', 
		'$module'
	)";

	if (db()->query($sql) === TRUE) {

		$data = ["status" => 1, "message" => "Exam uploaded successfully"];
		echo json_encode($data);

	} else {
		
		$data = ["status" => 0, "message" => $startTime . ": Error occured, please try again later"];
		echo json_encode($data);

	}

	db()->close();

	students_marks($transactionID);
}

/****** End of students functions *********/

/**
 *  Lecturer Functions 
 * 	Check if login file exists
 * 	Require file or 404
 * */

function lecturer_login($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_home($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_exams($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_set_exam($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_set_exam_form($file)
{
	if (file_exists(get_file($file))) {
		require get_file($file);
		return;
	}

	require error(404);
}

function lecturer_download()
{

	$module_code = substr(download_path(), 9, 7);

	$path = dirname(dirname(__DIR__)) . '/public/uploads/students/exams/' . $module_code . '/' . download_path();

	if (file_exists($path)) {
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($path) . '"');
		header('Cache-Control: must-revalidate');
		header('Expires: 0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($path));
		readfile($path);

		exit();

	}

}
function lecturer_load_all_modules()
{
	$modules = [];
	$staffNumber = identifiyer()['staffNumber'];
	$sql = "SELECT * FROM moduleleader INNER JOIN moduleinfo ON moduleleader.moduleCode = moduleinfo.moduleCode AND moduleleader.staffNumber = $staffNumber";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$modules[] = $row['moduleCode'];
	}

	return $modules;
}

function lecturer_available_exams()
{

	$count = 0;
	$html = '';

	$sql = "SELECT * FROM examsetup 
	INNER JOIN moduleinfo 
	ON examsetup.moduleCode = moduleinfo.moduleCode 
	WHERE examsetup.examDate = CAST(CURRENT_DATE AS DATE) 
	GROUP BY examsetup.moduleCode";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$html .= '<tr>
            <td>' . ++$count . '</td>
            <td>' . $row['moduleCode'] . '</td>
            <td>' . str_replace('-', ' ', $row['examDate']) . '</td>
            <td>' . $row['examTime'] . '</td>
        </tr>';
	}

	return $html;
	
}

function lecturer_modules($action)
{
	if (file_exists(get_file($action))) {
		require get_file($action);
		return;
	}

	require error(404);
}

function lecturer_list_modules()
{
	$staffNumber = identifiyer()['staffNumber'];
	$count = 0;
	$html = '';
	$sql = "SELECT * FROM moduleinfo INNER JOIN moduleleader ON moduleleader.moduleCode = moduleinfo.moduleCode AND moduleleader.staffNumber = $staffNumber";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$html .= '<tr>
            <td>' . ++$count . '</td>
            <td>' . $row['moduleCode'] . '</td>
            <td>' . $row['description'] . '</td>
            <td>
              <a href="?action=lecturer-set-exam&code='.$row['moduleCode'].'" class="btn btn-warning">
                <i class="fa fa-gear"></i>
              </a>
            </td>
        </tr>';
	}

	return $html;
}

function lecturer_view_module($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_submitted_exams($action)
{

	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function lecturer_get_submitted_exams()
{
	$count = 0;
	$html = '';

	$sql = "SELECT * FROM students_marks INNER JOIN examoutput ON students_marks.transactionID = examoutput.transactionID AND students_marks.mark_status = 0 AND students_marks.email_sent = 1 ORDER BY moduleCode DESC";
	$result = mysqli_query(db(), $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		$btn = '';
		if ($row['mark_status'] == 0) {
			$btn = '<span onClick="updateMarks(this.id)" id="'.$row["transactionID"].'" class="btn btn-success">
	                <i class="fa fa-edit"></i>
	            </span>';
		}

		$html .= '<tr>
            <td>' . ++$count . '</td>
            <td>' . $row['transactionID'] . '</td>
            <td>' . $row['studentNumber'] . '</td>
            <td>' . $row['moduleCode'] . '</td>
            <td>' . $row['examDate'] . '</td>
            <td>' . substr($row['uploadTime'], 11) . '</td>
            <td>
            	<a href="?action=lecturer-download&dp='.$row['answerPaperPDF'].'" class="btn btn-warning" download>
                <i class="fa fa-download"></i>
              	</a>
            </td>
            <td>
            	<input type="text" value="' . $row['marks'] . '" id="marks-' . $row['transactionID'] . '" style="width: 50px">
            </td>
            <td>
            	'.$btn.'
            </td>
          </tr>';
	}
	
	return $html;
}

function lecturer_update_marks($id,$val)
{
	$sql = "UPDATE students_marks SET marks = '$val', mark_status = '1' WHERE transactionID = '$id'";
	$result = mysqli_query(db(), $sql);

	if ($result == true) {
		return json_encode(['status' => true, 'message' => 'Marks updated']);
	}

	return json_encode(['status' => false, 'message' => 'Marks Failed to update']);
}

/****** END of Lecturer Functions *********/

/* Exam Department Functions */

function exam_dep_login($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function exam_dep_home($action)
{
	if (file_exists(public_dir($action))) {
		$res = examdep_get_modules();
		require public_dir($action);
		return;
	}

	require error(404);
}

function examdep_get_modules()
{
	$html = '';
	$count = 0;
	$sql = "SELECT * FROM moduleinfo ORDER BY moduleCode ASC";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$html .= '<tr>
            <td>' . ++$count . '</td>
            <td>' . $row['moduleCode'] . '</td>
            <td>' . $row['description'] . '</td>
        </tr>';
	}

	return $html;
}

function get_students_by_module($module)
{
	$students = [];
	$sql = "SELECT studentNumber FROM studentmodule WHERE moduleCode = '$module'";
	$result = mysqli_query(db(), $sql);
	
	if (count(mysqli_fetch_assoc($result)) > 0) {
		
		while($row = mysqli_fetch_assoc($result)) {
			$students[] = $row['studentNumber'];
		}

		return $students;
	}

	return;
}

function examdep_set_exam($date, $time, $file, $module)
{
	$time = $time . ":00";
	if (get_students_by_module($module) == null) {
		$data = ["status" => 0, "message" => "Invalid students count"];
		echo json_encode($data);
		return;
	}
	
	$total = count(get_students_by_module($module));

	for ($i=0; $i < $total; $i++) { 
		$student = get_students_by_module($module)[$i];
		
		$file = $student . '_' . $module . '_EXAM_' . date("Ymd-H i s") . '.pdf'; 

		$sql = "INSERT INTO examsetup (moduleCode, examDate, examTime, examPaperPDF) VALUES ('$module', '$date', '$time', '$file')";
		if (db()->query($sql) === TRUE) {

			$data = ["status" => 1, "message" => "Exam set successfully"];
			$response = json_encode($data);

		} else {
			
			$data = ["status" => 0, "message" => "Error occured, please try again later"];
			$response = json_encode($data);

		}
	}

	echo $response;

	db()->close();
}

function exam_dep_lecturer($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function exam_dep_exams($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function examdep_exam_list()
{

	$count = 0;
	$html = '';
	$before = date('Y-m-d', strtotime('-30 days'));

	$sql = "SELECT * FROM examoutput INNER JOIN students_marks ON examoutput.transactionID = students_marks.transactionID WHERE examDate > '$before' AND email_sent = 0 ORDER BY moduleCode ASC";
	$result = mysqli_query(db(), $sql);
	
	while($row = mysqli_fetch_assoc($result)) {
		$html .= '
			<tr>
            <td>'.++$count.'</td>
            <td>'.$row["transactionID"].'</td>
            <td>'.$row["studentNumber"].'</td>
            <td>'.$row["moduleCode"].'</td>
            <td>'.$row["uploadTime"].'</td>
            <td>'.$row["examDate"].'</td>
            <td>
              <span onClick="extract(this.id)" id="'.$row["transactionID"].'" class="btn btn-success">
                <i class="fa fa-shuffle"></i>
              </span>
            </td>
          </tr>
		';
	}

	return $html;
}

function examdep_extract($id)
{
	$sql = "SELECT * FROM examoutput INNER JOIN moduleleader ON 
	moduleleader.moduleCode = examoutput.moduleCode 
	JOIN staffinfo ON moduleleader.staffNumber = staffinfo.staffNumber
	WHERE examoutput.transactionID = '$id'";
	$result = mysqli_query(db(), $sql);

	$row = mysqli_fetch_assoc($result);

	if ($row['transactionID'] == $id) {

		$headers = "";
		$message = "";
		$module_code = $row['moduleCode'];
		$examDate = $row['examDate'];
		$student_number = $row['studentNumber'];
		$staffName = $row['staffName'];
		$filename = $row['answerPaperPDF'];
		$headers .= "From: exam-dep@unisa.ac.za\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		$message .= "Hi $staffName,\r\n";
		$message .= "An exam has been submitted, please see details of student below: \n\n";
		$message .= "Student Number: $student_number\n";
		$message .= "Transaction ID: $id\n";
		$message .= "Module Code: $module_code\n";
		$message .= "Exam Date: $examDate\n";
		$subject = $id;
		$to = $row['staffEmail'];

		if (examdep_extract_upload($id) == true) {
			
			if(mail($to, $subject, $message, $headers) == true)
			{

				return true;
			
			}
			else
			{

				return json_encode(['status' => false, 'message' => 'Couldn\'t send email']);

			}

		}

		return false;
		
	}

	return false;
}

function examdep_extract_upload($id)
{
	$sql = "UPDATE students_marks SET email_sent = '1' WHERE transactionID = '$id'";
	$result = mysqli_query(db(), $sql);

	if ($result == true) {
		return json_encode(['status' => true]);
	}

	return json_encode(['status' => false]);
	
}

function examdep_modules($action)
{
	if (file_exists(get_file($action))) {
		require get_file($action);
		return;
	}

	require error(404);
}

function examdep_daily_exams()
{
	
	$sql = "SELECT * FROM examsetup WHERE examDate = CAST(CURRENT_DATE AS DATE)";
	$result = db()->query($sql);

	$total = '<div class="examdep-card card-danger">
				'. mysqli_num_rows($result) .'
				<h4 class="card-text">Daily Exams</h4>
			</div>';

	echo $total;

}

function examdep_weekly_exams()
{
	
	$sql = "SELECT * FROM examoutput WHERE examDate = CAST(CURRENT_DATE - INTERVAL -1 WEEK AS DATE)";

	$result = db()->query($sql);

	$total = '<div class="examdep-card card-warning">
				'. mysqli_num_rows($result) .'
				<h4 class="card-text">Weekly Exams</h4>
				</div>';

	echo $total;

}

function examdep_number_of_modules()
{
	
	$num_of_mod = 0;
	$sql = "SELECT COUNT(ModuleCode) AS 'Number of Modules', examDate FROM ExamSetup
		Where examDate = CURRENT_DATE
		GROUP BY examDate";
		
	$result = db()->query($sql);
	$row = mysqli_fetch_assoc($result);

	if (isset($row['Number of Modules']) != null) {
		$num_of_mod = $row['Number of Modules'];
	}

	$total = '<div class="examdep-card card-primary">
			'. $num_of_mod .'
			<h4 class="card-text">Number of Modules</h4>
			</div>';

	echo $total;

}

function examdep_submitted_files()
{
	
	$sql = "SELECT COUNT(moduleCode) AS 'SUBMITTED FILES' FROM examoutput WHERE examDate = CAST(CURRENT_DATE AS DATE)";
	
	$result = db()->query($sql);
	$row = mysqli_fetch_assoc($result);

	$total = '<div class="examdep-card card-success">
				'. $row['SUBMITTED FILES'] .'
				<h4 class="card-text">Submitted Files</h4>
				</div>';
	echo $total;

}

function examdep_view_module($action)
{
	if (file_exists(public_dir($action))) {
		require public_dir($action);
		return;
	}

	require error(404);
}

function totalModules()
{
	$data = [];
	$sql = "SELECT moduleCode FROM moduleinfo";
	$result = mysqli_query(db(), $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		$data[] = $row['moduleCode'];
	}

	return json_encode($data);
}

function totalStudents()
{
	$date = date("Y-m-d");
	$data = [];
	$totalModules = json_decode(totalModules());

	for ($i=0; $i < count($totalModules); $i++) { 
		$module = $totalModules[$i];

		$sql = "SELECT COUNT(*) AS TOTAL FROM examsetup WHERE moduleCode = '$module' AND examDate = '$date'";
		$result = mysqli_query(db(), $sql);

		while($row = mysqli_fetch_assoc($result))
		{
			$data[] = $row['TOTAL'];
		}

		if(count($totalModules) == $i + 1)
		{
			return json_encode($data);
		}
	}

}