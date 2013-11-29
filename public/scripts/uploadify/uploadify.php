<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/bank-logo'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	echo $tempFile.'\n';
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	echo $targetPath.'\n';
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	echo $targetFile.'\n';
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo print_r ($_FILES);
	} else {
		echo 'Invalid file type.';
	}
}
?>