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
		
		// Create image from file
		$image = null;
		switch(strtolower($_FILES['Filedata']['type']))
		{
			case 'image/jpeg': case 'image/jpg':
				$image = imagecreatefromjpeg($_FILES['Filedata']['tmp_name']);
				break;
			case 'image/png':
				$image = imagecreatefrompng($_FILES['Filedata']['tmp_name']);
				break;
			case 'image/gif':
				$image = imagecreatefromgif($_FILES['Filedata']['tmp_name']);
				break;
			default:
				exit('Unsupported type: '.$_FILES['image']['type']);
		}
		if($image != null){
			// Target dimensions
			$max_width = 115;
			$max_height = 60;
			
			// Get current dimensions
			$old_width  = imagesx($image);
			$old_height = imagesy($image);
			
			// Calculate the scaling we need to do to fit the image inside our frame
			$scale = min($max_width/$old_width, $max_height/$old_height);
			
			// Get the new dimensions
			$new_width  = ceil($scale*$old_width);
			$new_height = ceil($scale*$old_height);
			
			// Create new empty image
			$new = imagecreatetruecolor($new_width, $new_height);
			
			// Resize old image into new
			imagecopyresampled($new, $image,
						0, 0, 0, 0,
						$new_width, $new_height, $old_width, $old_height);
			imagejpeg($new, $dest.$_FILES['Filedata']['name'].'-60x115');
		}
	} else {
		echo 'Invalid file type.';
	}
}
?>