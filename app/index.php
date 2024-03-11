<?php

//Load all functions
require 'private/model/functions.php';

/* Get current user by subdomain */
$domain = user();

/* Check if user is logged in first */
if (is_logged_in($domain) == false) {
	$action = $domain . '-login';
}
else
{
	$action = $_GET['action'] ?? $domain . '-home';
}

/* If subdomain is not empty */
if (!empty($domain)) {

/* If action is set and not empty */
	if (isset($action) && !empty($action)) {
		
		$paths = $domain();

		if (isset($paths[$action])) {

			/* Return path*/
			return $paths[$action]($action);
		
		}

		/* Load 404 page */
		require_once error(404);
		exit;

	}

	/* Load home user's home page */
	require_once public_dir($domain . '-home');
	return;

}

//Students pages and functions
function students()
{

	return [
		'students-home' => 'students_home',
		'students-exams' => 'students_exams',
		'my-module' => 'my_module',
		'my-exams' => 'my_exams',
		'student-download' => 'student_download',
		'students-upload' => 'students_upload',
		'students-login' => 'students_login',
		'students-logout' => 'logout'
	];

}

//Lecturer pages and functions
function lecturer()
{
	
	return [
		'lecturer-home' => 'lecturer_home',
		'lecturer-login' => 'lecturer_login',
		'lecturer-exams' => 'lecturer_exams',
		'lecturer-view-module' => 'lecturer_view_module',
		'lecturer-set-exam' => 'lecturer_set_exam',
		'lecturer-submitted-exams' => 'lecturer_submitted_exams',
		'lecturer-download' => 'lecturer_download',
		'lecturer-logout' => 'logout'
	];

}

//Exam Department pages and functions
function examdep()
{
	
	return [
		'examdep-home' => 'exam_dep_home',
		'examdep-modules' => 'examdep_modules',
		'examdep-view-module' => 'examdep_view_module',
		'examdep-lecturer' => 'exam_dep_lecturer',
		'examdep-exams' => 'exam_dep_exams',
		'examdep-login' => 'exam_dep_login',
		'examdep-logout' => 'logout'
	];

}