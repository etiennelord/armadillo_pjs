<?php
include_once('../helper.php');
//error_reporting(E_ALL);
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

//$verifyToken = md5('unique_salt' . $_POST['timestamp']);
$type='Text';
$object_id='';
$session_id='';
if (isset($_POST['type'])) $type=$_POST['type'];
if (isset($_POST['object_id'])) $object_id=$_POST['object_id'];
if (isset($_POST['session_id'])) $session_id=$_POST['session_id'];

// Define a destination
$targetFolder = '/armadillo_workflow_pjs/usagers/'.$session_id; // Relative to the root

if (!empty($_FILES)) {
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' .$_FILES['Filedata']['name'];
			
	if (!move_uploaded_file($tempFile,$targetFile)) {
		saveFile("usagers/".session_id()."/log.txt"	,"$tempFile $targetFile");
	}
	
	
	$arr = array('type' => $type, 'name' => $_FILES['Filedata']['name'], 'object_id' => $object_id, 'armadillo_filename'=>$targetFile);
    echo json_encode($arr);
}	
?>