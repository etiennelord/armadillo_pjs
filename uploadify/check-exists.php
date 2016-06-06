<?php
session_start();
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

$session_id=session_id();
if (isset($_POST['session_id'])) $session_id=$_POST['session_id'];
// Define a destination
$targetFolder = '/armadillo_workflow_pjs/usagers/'.$session_id; // Relative to the root

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' .$_POST['filename'])) {
	echo 1;
} else {
	echo 0;
}
?>