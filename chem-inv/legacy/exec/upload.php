<?php
/**
 * EXECUTE
 *
 * Upload files
 *********************************************************/

$config = require('../default.php');

// Init session
session_start();

// Abort script if session not loaded
if (session_status() != PHP_SESSION_ACTIVE) {exit;}

try {

if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['selector'])) {

	// Init response
	$response = [];

	$selector = $_POST['selector'];

	// Security check
	if (in_array($selector, ['coa', 'msds'])) {
		security_check('leltar', 1);
	} else {
		exit;
	}

	// Set file handler
	if ($selector == 'coa') {

		if (isset($_FILES['coa#0'])) {
			$file = $_FILES['coa#0'];
		} else {
			$message['text'] = 'Nincs fájl kiválasztva';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		}

	} else {
		if (isset($_FILES['msds#0'])) {
			$file = $_FILES['msds#0'];
		} else {
			$message['text'] = 'Nincs fájl kiválasztva';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		}

	}

	// Sanitizing user inputs
	if (in_array($selector, ['coa', 'msds'])) {

		if (empty($_POST['batch_id']) or (intval($_POST['batch_id']) <= 0)) {
			$response['text'] = 'Termék ID hiányzik';
			$error_flag = TRUE;
		} else {
			$batch_id = intval($_POST['batch_id']);
		}

	}

	// No errors -> valid user input -> validate uploaded file
	if (!$error_flag) {

		// Allowed file extensions
		$allow_ext = array('pdf','doc','docx');

		// Uploaded file extension
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);

		if (!(is_uploaded_file($file['tmp_name']))) { # Is really an uploaded file? (not a hack)
			$message['text'] = 'Nincs fájl kiválasztva';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		} elseif (!(in_array($ext, $allow_ext))) { # Has it an allowed extension?
			$message['text'] = 'Csak pdf, doc vagy docx tölthető fel';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		} elseif ($file['size'] == 0) { # Not a blank file
			$message['text'] = 'Üres fájl';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		} elseif ($file['size'] > 5242880) { # Not bigger than 5MB
			$message['text'] = 'Fájl nagyobb mint 5MB';
			$message['flag'] = 'neg';
			$response []= $message;
			$error_flag = TRUE;
		}

		if (!$error_flag) { # File valid

			// Path to save
			if ($selector == 'coa') {
				$target_file = ROOT.'/docs/CoA/CoA_batch_'.$batch_id.'.'.$ext;
			} elseif ($selector == 'msds') {
				$target_file = ROOT.'/docs/MSDS/MSDS_batch_'.$batch_id.'.'.$ext;
			}

			if ($file['error'] == 0) { # If no error during upload (client side)

				// Search old file
				if ($selector == 'coa') {
					$old_file = search_file('coa', $batch_id);
				} elseif ($selector == 'msds') {
					$old_file = search_file('msds', $batch_id);
				}

				// If there is a file already uploaded
				if ($old_file) {
					// Delete old file
					unlink(ROOT.'/'.$old_file);
				}

				// Then move new file to permanent position
				if (move_uploaded_file($file['tmp_name'], $target_file)) {

					// Success
					$message['text'] = 'Fájl feltöltve';
					$message['flag'] = 'pos';
					$response []= $message;

				} else {

					$message['text'] = 'Nem sikerült a feltöltés (szerver oldali hiba miatt)';
					$message['flag'] = 'neg';
					$response []= $message;
					$error_flag = TRUE;
				}

			} else {
				$message['text'] = 'Nem sikerült a feltöltés (kliens oldali hiba miatt)';
				$message['flag'] = 'neg';
				$response []= $message;
				$error_flag = TRUE;
			}
		}
	}

	// Encode response to JSON
	$response = json_encode($response, JSON_UNESCAPED_UNICODE);
	echo $response;
}
} catch (leltar_exception $e) {$e->error_handling();}?>
