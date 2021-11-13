<?php

	function image_resize($src, $w, $h){ 
		$info = getimagesize($src);
		$width = $info[0];
		$height = $info[1];
		$type = $info[2];
			switch($info[2]){
				case 1:
					$img = imageCreateFromGif($src);
					imageSaveAlpha($img, true);
				break;
				case 2:
					$img = imageCreateFromJpeg($src);
				break;
				case 3:
					$img = imageCreateFromPng($src); 
					imageSaveAlpha($img, true);
				break;
			}
		
		$tmp = imageCreateTrueColor($w, $h);
		if ($type == 1 || $type == 3) {
			imagealphablending($tmp, true); 
			imageSaveAlpha($tmp, true);
			$transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127); 
			imagefill($tmp, 0, 0, $transparent); 
			imagecolortransparent($tmp, $transparent);    
		}   
 
		$tw = ceil($h / ($height / $width));
		$th = ceil($w / ($width / $height));
		if ($tw < $w) {
			imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);        
		} else {
			imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);    
		}            
 
		$img = $tmp;

		switch ($type) {
			case 1: 
				header('Content-Type: image/gif'); 
				imageGif($img);
			break;			
			case 2: 
				header('Content-Type: image/jpeg');
				imageJpeg($img, null, 100);
			break;			
			case 3: 
				header('Content-Type: image/x-png');
				imagePng($img);
			break;
		}
		imagedestroy($img);
		exit();
	}
	
$src = $_GET['src'];
$wh = $_GET['w'];
$hh = $_GET['h'];
image_resize($src, $wh, $hh);
?>