<?php

if (isset($_POST['id'])) {

	if (!empty($_POST['id'])) {
		
		$value = $_POST['value'];
		require dirname(dirname(__DIR__)) . '/private/model/functions.php';
		
		if (lecturer_update_marks($_POST['id'], $value) == TRUE) {

			echo json_encode(['status' => true]);
			return;
		}

		if (isset(lecturer_update_marks($_POST['id'], $value)['message'])) {

			$message = lecturer_update_marks($_POST['id'], $value)['message'];
			echo json_encode(['status' => false, 'message' => $message]);
			return;

		}

		echo json_encode(['status' => false, 'message' => 'Invalid Transaction ID']);
		return;

	}
	echo json_encode(['status' => false, 'message' => 'Invalid Transaction ID']);
	return;
}