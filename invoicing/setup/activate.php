<?php
// Change this to your connection info.
include "../includes/config.php";
// First we check if the email and code exists...
if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $mysqli->prepare('SELECT * FROM users WHERE email = ? AND activation_code = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			// Account exists with the requested email and code.
			if ($stmt = $mysqli->prepare('UPDATE users SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
				// Set the new activation code to 'activated', this is how we can check if the user has activated their account.
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
				if ($stmt->execute()) {
					echo header("Location: ../index.php?id=5");
				} else {
					echo header("Location: ../index.php?id=4");
				}
			}
		} else {
			echo header("Location: ../index.php?id=6");
		}
	}
}
?>