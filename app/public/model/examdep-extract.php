<?php

if (isset($_POST['id'])) {

	if (!empty($_POST['id'])) {
		
		require dirname(dirname(__DIR__)) . '/private/model/functions.php';
		
		if (examdep_extract($_POST['id']) == TRUE) {

			echo json_encode(['status' => true]);
			return;
		}

		if (isset(examdep_extract($_POST['id'])['message'])) {

			$message = examdep_extract($_POST['id'])['message'];
			echo json_encode(['status' => false, 'message' => $message]);
			return;

		}

		echo json_encode(['status' => false, 'message' => 'Invalid Transaction ID']);
		return;

	}
	echo json_encode(['status' => false, 'message' => 'Invalid Transaction ID']);
	return;
}