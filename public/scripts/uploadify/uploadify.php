<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads/bank-logo'; // Relative to the root

/*
 * For Logos in WordPress; Server paths
 */
$src = '/var/www/vhosts/vergleich24.at/rechner/public/uploads/bank-logo/';
$dest = '/var/www/vhosts/vergleich24.at/httpdocs/wp-content/uploads/bank-logo/';

/*
 * Local paths
 */
// $src = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
// $dest = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

if (!empty($_FILES)) {
	$bankName = strtolower(str_replace(" ", "", $_POST['bankName']));
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $bankName;
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile, $targetFile);
// 		if(!file_exists($dest.$_FILES['Filedata']['name'])){
// 			echo copy($src.$_FILES['Filedata']['name'], $dest.$_FILES['Filedata']['name']);
// 		}
		// Create image from file
		$dimensions = array(
			0 => array(	/* Logogröße für die Vergleichstabelle */
				'width' => 115,
				'height' => 60
			),
			1 => array(	/* Logogröße für die Aktionsbox */
				'width' => 171,
				'height' => 77
			),				
		);
		$image = null;
		
		switch(strtolower($fileParts['extension']))
		{
			case 'jpeg': case 'jpg':
				$image = imagecreatefromjpeg($targetFile);
				break;
			case 'png':
				$image = imagecreatefrompng($targetFile);
				break;
			case 'gif':
				$image = imagecreatefromgif($targetFile);
				break;
			default:
				exit('Unsupported type: '.$fileParts['extension']);
		}
		if($image != null){
			imagealphablending($image, true);
			
			foreach($dimensions as $dimension){
				// Target dimensions
				$max_width = $dimension['width'];
				$max_height = $dimension['height'];
				
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
				imagealphablending($new, false);
				imagesavealpha($new, true);
				
				// Resize old image into new
				imagecopyresampled($new, $image,
							0, 0, 0, 0,
							$new_width, $new_height, $old_width, $old_height);
				imagepng($new, $dest.$bankName."_$max_width-x-$max_height.png");
				imagepng($new, $src.$bankName."_$max_width-x-$max_height.png");
// 				imagepng($new, $targetPath."/".$bankName."_$max_width-x-$max_height.png");
			}
// 			unlink($targetFile);
		}
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>