<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/bank-logo'; // Relative to the root

/*
 * For Logos in WordPress 
 */
$src = '/var/www/vhosts/vergleich24.at/rechner/public/uploads/bank-logo/';
$dest = '/var/www/vhosts/vergleich24.at/httpdocs/wp-content/uploads/bank-logo/';

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		if(!file_exists($dest.$_FILES['Filedata']['name'])){
			copy($src.$_FILES['Filedata']['name'], $dest.$_FILES['Filedata']['name']);
		}
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>