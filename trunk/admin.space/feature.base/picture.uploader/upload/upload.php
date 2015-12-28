<?php
include '../../../../includes/configuration/master.configuration.php';


if (!empty($_FILES)) {

/*************************************************************************************************************************
	CAPTURE ALL THE VARIABLE
**************************************************************************************************************************/
	$nav_tab_id			= $_GET['nav_tab_id'];
	$feature_id			= $_GET['feature_id'];

/*************************************************************************************************************************
	GET ALL THE FEATURE'S RELATED VARIABLES
**************************************************************************************************************************/
	$target_original		= GetSetting('target_original', $feature_id);
	$target_extra_large		= GetSetting('target_extra_large', $feature_id);
	$target_large			= GetSetting('target_large', $feature_id);
	$target_medium			= GetSetting('target_medium', $feature_id);
	$target_small			= GetSetting('target_small', $feature_id);
	$extra_large_width		= GetSetting('extra_large_width', $feature_id);
	$extra_large_height		= GetSetting('extra_large_height', $feature_id);
	$large_width			= GetSetting('large_width', $feature_id);
	$large_height			= GetSetting('large_height', $feature_id);
	$medium_width			= GetSetting('medium_width', $feature_id);
	$medium_height			= GetSetting('medium_height', $feature_id);
	$small_width			= GetSetting('small_width', $feature_id);
	$small_height			= GetSetting('small_height', $feature_id);
	$multimedia_type		= GetSetting('multimedia_type', $feature_id);
	$picture_type			= GetSetting('picture_type', $feature_id);
	$resample_extra_large	= GetSetting('resample_extra_large', $feature_id);
	$resample_large			= GetSetting('resample_large', $feature_id);
	$resample_medium		= GetSetting('resample_medium', $feature_id);
	$resample_small			= GetSetting('resample_small', $feature_id);
	
	
/*************************************************************************************************************************
	DO THE PROCESSING
**************************************************************************************************************************/
	$filename			= basename($_FILES['Filedata']['name']);
	$file_basename 		= substr($filename, 0, strripos($filename, '.')); // strip extention
	$file_ext     		= substr($filename, strripos($filename, '.'));
	$size				= $_FILES['Filedata']['size'] / 1024 ;
	
	$sort_number		= getUsortNumber('multimedia', 'ASC', 'feature_id', $feature_id);


/*************************************************************************************************************************
	CHECK THE MAX NUMBER OF PICS ALLOWED AND DELETE THE LAST ONE IF MAX NUMBER REACHED
**************************************************************************************************************************/	
	if (getSetting('max_upload',$feature_id) > 0) {
	
		$mySQL	= "SELECT * FROM multimedia WHERE nav_tab_id = '$nav_tab_id' AND feature_id = '$feature_id' AND status >0";
		$recSET	= mysql_query($mySQL) or die (mysql_error());
		
		if (mysql_num_rows($recSET) >= getSetting('max_upload',$feature_id)) {
		
			$mySQL	= $mySQL." ORDER BY usort DESC";
			$recSET	= mysql_query($mySQL) or die (mysql_error());
			$recROW	= mysql_fetch_assoc($recSET);	
			
			$multimedia_id	= $recROW['multimedia_id'];		
			deleteMultimedia($multimedia_id);
		}
		
	}

/*************************************************************************************************************************
	INSERT A NEW RECORD IN THE MULTIMEDIA TABLE AND USE THE ID AS THE NAME FOR THE FILE
**************************************************************************************************************************/
	$mySQL									= "INSERT INTO multimedia (nav_tab_id, picture_type, multimedia_type, multimedia_name, size, extension, date, status, feature_id, usort) 
												VALUES ('$nav_tab_id', '$target_large', '$multimedia_type', '$filename', '$size', '$file_ext', now(), '3', '$feature_id', '$sort_number')";

	mysql_query($mySQL) or die(mysql_error());

	$name									= mysql_insert_id()."$file_ext";
	if (empty($_GET['nav_tab_id'])) $name	= session_id()."$file_ext";
	
	$tempFile 								= $_FILES['Filedata']['tmp_name'];
	$targetFile 							= "$docRoot$target_original$name";

/*************************************************************************************************************************
	CREATE THE FOLDER IF NOT EXISTS AND MOVE THE UPLOADED FILE IN IT
**************************************************************************************************************************/	
	mkdir(str_replace('//','/',"$docRoot$target_original"), 0755, true);			// make the directory if it doesn't exist
	mkdir(str_replace('//','/',"$docRoot$target_extra_large"), 0755, true);			// make the directory if it doesn't exist
	mkdir(str_replace('//','/',"$docRoot$target_large"), 0755, true);				// make the directory if it doesn't exist
	mkdir(str_replace('//','/',"$docRoot$target_medium"), 0755, true);				// make the directory if it doesn't exist
	mkdir(str_replace('//','/',"$docRoot$target_small"), 0755, true);				// make the directory if it doesn't exist
	
	move_uploaded_file($tempFile,$targetFile);

	$original_image	= $targetFile;
	
/*************************************************************************************************************************
	IF THE FILE IS OTHER TYPE REDIRECT TO ANOTHER ORIGNAL SOURCE AND PREVENT DELETING IT
**************************************************************************************************************************/
	if (strtolower($file_ext) == ".swf") {
		
		$delete_original 	= 'no';
		$file_ext			= '.jpg';
		$original_image		= $docRoot."multimedia/pictures/template/admin.space/icons/flash.icon.jpg";
	}
	if (strtolower($file_ext) == ".pdf") {
		
		$delete_original 	= 'no';
		$file_ext			= '.jpg';
		$original_image		= $docRoot."multimedia/pictures/template/admin.space/icons/pdf.icon.jpg";
	}

	if (strtolower($file_ext) == ".rar") {
		
		$delete_original 	= 'no';
		$file_ext			= '.jpg';
		$original_image		= $docRoot."multimedia/pictures/template/admin.space/icons/rar.icon.jpg";
	}

	if (strtolower($file_ext) == ".zip") {
		
		$delete_original 	= 'no';
		$file_ext			= '.jpg';
		$original_image		= $docRoot."multimedia/pictures/template/admin.space/icons/zip.icon.jpg";
	}

/*************************************************************************************************************************
	RESIZE ORIGINAL IMAGE IN MULTIPLE FORMATS
**************************************************************************************************************************/		
	
	if($resample_extra_large != 'no') {
		$final_image	= "$docRoot$target_extra_large$name";
		processImage($original_image, $final_image, $extra_large_height, $extra_large_width, $file_ext);
	}

	if($resample_large != 'no') {
		$final_image	= "$docRoot$target_large$name";
		processImage($original_image, $final_image, $large_height, $large_width, $file_ext);
	}
	
	if($resample_medium != 'no') {
		$final_image	= "$docRoot$target_medium$name";
		processImage($original_image, $final_image, $medium_height, $medium_width, $file_ext);
	}
	
	if($resample_small != 'no') {
		$final_image	= "$docRoot$target_small$name";
		processImage($original_image, $final_image, $small_height, $small_width, $file_ext);
	}
		

/*************************************************************************************************************************
	DELETE THE ORIGINAL FILE TO REDUCE SPACE CONSUMPTION ON THE SERVER
**************************************************************************************************************************/
	
	if(file_exists($original_image) AND $delete_original != 'no')unlink($original_image);
	
	

}
echo "1";
?>