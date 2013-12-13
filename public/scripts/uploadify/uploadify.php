<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/bank-logo'; // Relative to the root
$wpUploadsFolder = '/var/www/vhosts/vergleich24.at/httpdocs/wp-content/uploads/bank-logo';

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	$wpTargetFile = rtrim($wpUploadsFolder,'/') . '/' . $_FILES['Filedata']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		move_uploaded_file($tempFile,$wpTargetFile);
// 		echo print_r ($_FILES);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>