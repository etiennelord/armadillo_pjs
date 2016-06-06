<?php
@session_start();
//error_reporting(E_ALL);
include_once('helper.php');
/**
 *  Armadillo Workflow Platform v2.0 - Online
 *  A simple pipeline system for phylogenetic analysis
 *  
 *  Copyright (C) 2009-2012  Etienne Lord
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 * 
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
	
	//====================================================================================
	//= UPDATE
	//====================================================================================
	 if(isset($_REQUEST['action'])){
		$operation = $_REQUEST['action'];	
		if ($operation=="upload") {
			//echo variable_to_html($_FILES);
			$file_with_directory="usagers/".session_id()."/". strtolower($_FILES["file"]["name"]);						
			 $file_alone=$_FILES["file"]["name"];
			 move_uploaded_file($_FILES["file"]["tmp_name"],$file_with_directory);
				// echo "done";
			// } else {
				// echo "error ".$file_with_directory;
			// }
			//--Execute workflow
			
			
			//--Mogrify			
			//$proj_mogrify="/opt/local/bin/mogrify -resize 200x200 $file_with_directory";
			//$last=system($proj_mogrify,$retour);								
			 //echo "$retour $last <br><img src='$file_with_directory'>";
		
		}
		if ($operation=="listfiles") {
			$tmp=array();
			if ($handle = opendir("usagers/".session_id()."/")) {
				$total=0;
				$totalsize=0;
				
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$size=filesize("usagers/".session_id()."/".$entry);
						$total++;
						$totalsize+=$size;
						$path_parts = pathinfo($entry);
						array_push($tmp, array('filename'=>$path_parts['basename'],'extension'=>$path_parts['extension'], 'size'=>filesize_formatted($size), 'executable'=>($path_parts['extension']=='db'), 'link'=>"usagers/".session_id()."/".$entry));
						//echo "$entry <br>";
					}
				}
				array_push($tmp, array('filename'=>'total', 'size'=>filesize_formatted($totalsize)));
				echo json_encode($tmp);
				exit();
				closedir($handle);
			}		
		 }
		 
		 if ($operation=="remove") {
			if (isset($_REQUEST['filename'])) {
			    echo "Deleting ".$_REQUEST['filename'];				
				if ($_REQUEST['filename']) {					
					if (is_readable("usagers/".session_id()."/".$_REQUEST['filename'])) {
						unlink("usagers/".session_id()."/".$_REQUEST['filename']);						
						}
				}				
			}
			exit();
		 }
		 
		  if ($operation=="run_workflow") {
			if (isset($_REQUEST['filename'])) {
			    //echo "Running ".$_REQUEST['filename'];				
				if ($_REQUEST['filename']) {					
					if (is_readable("usagers/".session_id()."/".$_REQUEST['filename'])) {
						//--Get the list of this workflow id
						$json_workflow=json_decode(getListWorkflowFilename($_REQUEST['filename']), true);
						//echo getListWorkflowFilename($_REQUEST['filename']);
						print_r($json_worflow);
						//print_r($json_worflow);
						$total=$json_workflow[count($json_workflow)-1]['id'];
						//echo $total;
						//print_r($json_workflow);
						///////////////////////////////////
						/// INITIALIZE XDISPLAY
						system("/usr/bin/Xvfb :3 &", $ret);
						apache_setenv("DISPLAY",":3", true);
						$value=":3";
						putenv("DISPLAY=$value");	
						
						  RunWorkflow($_REQUEST['filename'], $total);						
						}
				}				
			}
			exit();
		 }
		
		  if ($operation=="list_workflow") {
			if (isset($_REQUEST['filename'])) {			   		
				if ($_REQUEST['filename']) {					
					if (is_readable("usagers/".session_id()."/".$_REQUEST['filename'])) {
						getListWorkflowFilename($_REQUEST['filename']);						
						}
				}				
			}
			exit();
		 }
			
	}		

	
	
?>

<?php 
	//--Load include

	
	
	
?>	
<!doctype html>
<html lang="en" xmlns:ng="http://angularjs.org" id="ng:app" ng-app="myApp">
	<HEAD>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="viewport" content="height=device-height, initial-scale=1.0"/>
		
    	<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />

			<link rel="shortcut icon" href="data/favicon.ico" />  
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		 <!-- <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script> -->
		 <script src="js/jquery.mobile-1.3.1.min.js"></script>	<!-- This don't work-->			
		<script type="text/javascript" src="js/angular.min.js"></script>
				
		 
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/js/bootstrap.min.js"></script>		
		<script type="text/javascript" src="js/localStorageModule.js"></script>   
	
		<script type="text/javascript" src="js/controler/mainCtrl.js"></script>
		
		<!-- load angular -->
		<script type="text/javascript">
						
					//////////////////////////////////////////////////////////
					/// MAIN APPLICATION
					
					var parsedUrl = $.mobile.path.parseUrl( location.href );
					
					if (parsedUrl.hrefNoHash!=parsedUrl.href) {
						var newurl=parsedUrl.href.substring(parsedUrl.hrefNoHash.length);
						location.href=parsedUrl.hrefNoHash;
						//$.mobile.changePage( newurl, { changeHash: false });
					}
					
					var myApp = angular.module('myApp',['LocalStorageModule']).config(function($locationProvider) {					
							$locationProvider.html5Mode(true);
					});			
				
		</script>


</HEAD>
	
	<BODY ng-controller='MainCtrl'>
	<div data-role="page" id="pagePrincipale">
            <div data-role="header" style="padding:0px" data-theme="b">                
                <!-- Show if we are logged or not -->
				<a target="_self" href="#popupLogout" data-rel="dialog" data-role="button" data-icon="check" data-transition="slide-down">Logout</a> 
                <h1>Armadillo Workflow online</h1>
            </div><!-- /header -->
            <div data-role="content">


	<form target="_self" method=POST name=update_enseignes_form action='file_upload.php?action=upload' enctype="multipart/form-data">	
		<div class="fileinput fileinput-new" data-provides="fileinput">
			  <div class="input-group">
				  <div class="form-control uneditable-input span3" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
				<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="file" id="file" data-role="none"></span>
				<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
				<input target="_self" class="btn btn-default" type="submit" id="upload" value="Upload" />	
			  </div>
			</div>
			
		</form>
				
	<!-- class="rowlink" -->
	<table class="table table-striped table-bordered table-hover">
	  <thead>
		<tr><th>File</th><th>Description</th><th>Type</th><th>Size</th><th>Actions</th></tr>
	  </thead> 	  
	  <tbody >
		<tr ng-repeat='file in user_files'>			
			<td ng-show='file.executable||file.filename=="total"'><b>{{file.filename}}</b></td>
			<td ng-show='!file.executable&&file.filename!="total"'><a target="_self" href='{{file.link}}'> {{file.filename}}</a></td>
			<td></td>
			<td>{{file.extension}}</td>
			<td>{{file.size}}</td>
			<td>
			<button class='btn btn-default' ng-show='file.filename!="total"' ng-click='remove(file)'><i class="fa fa-trash-o"></i></button>
			<button class='btn btn-primary' ng-show='file.executable' ng-click='execute(file)'>Run <span ng-show='file.executing'>(running)</span></button>
			<button class='btn btn-success' ng-show='file.executable' ng-click='view(file)'>View <span ng-show='file.executing'>(running)</span></button>
			</td>
		</tr>
	  
	
	  </tbody>
	</table>	
	</div>
	</div>
	</BODY>
</HTML>	
	