<?php
@session_start();
include_once('bd.php');
date_default_timezone_set('America/Montreal');
@connection_db();	
			//====================================================================================
			//= ADMIN TEST
			//====================================================================================
			//--Privilege des utilisateurs (see bd.php)
			// -1: Unregistered
			//  0: Registered
			// 99: Sysop
			$user_privilege=-1; 		
			if (isset($_SESSION['id_client'])&&isset($_SESSION['nom'])) {
				$user_privilege=bd_getUserPrivilege(mysql_real_escape_string($_SESSION['id_client']));		
			}	
	
	//====================================================================================
	//= UPDATE
	//====================================================================================
	 if(isset($_REQUEST['action'])){
		//--Look for privilege here
		if ($user_privilege<=1) exit(); //--Verify admin
		
		//--Be sure the directory 'definition' exists
		
		
		$operation = $_REQUEST['action'];	
		
		
		if ($operation=="upload") {
			//--Create the publicite here and add flag if created
			//echo variable_to_html($_REQUEST);
			//echo variable_to_html($_FILES);
			//--Create the publicite here 
			// if (isset($_POST['id_publicite'])) { $id_publicite=addslashes($_POST['id_publicite']);}
			// if (isset($_POST['start_date'])) { $start_date=addslashes($_POST['start_date']);}
			// if (isset($_POST['end_date'])) { $end_date=addslashes($_POST['end_date']);}
			// if (isset($_POST['url'])) { $url=addslashes($_POST['url']);}
			// if (isset($_POST['codePostal'])) { $codePostal=addslashes($_POST['codePostal']);}
			// if (isset($_POST['distance'])) { $distance=addslashes($_POST['distance']);}
			// if (isset($_POST['where'])) { $where=addslashes($_POST['where']);}
			// $codePostal = strtolower($codePostal);
			// $codePostal = trim($codePostal);
			// $codePostal=str_replace(" ","",$codePostal);
			$id_client=$_SESSION['id_client'];
			echo variable_to_html($_REQUEST);
			echo variable_to_html($_FILES);
			if ($_FILES['file_fr']['error']!=4) {
				//--TO DO SET FLAG HERE
			
					$image_fr=$id_publicite."_fr.gif";			
					 move_uploaded_file($_FILES["file_fr"]["tmp_name"],"/var/www/html/admin/definition/".$image_fr);
					
					//--CREATE OR UPDATE
					// $sqlq="DELETE FROM Publicite WHERE id_publicite='$id_publicite';";
					// $res=mysql_query($sqlq);
					// $sqlq="INSERT INTO Publicite (id_publicite, start_date, end_date, click_count_fr, click_count_en, view_position, url, image_fr, image_en, id_client, status, codePostal, distance) VALUES 
							// ('$id_publicite', '$start_date', '$end_date', 0, 0, '$where', '$url', '$image_fr', '$image_en', '$id_client', 1, '$codePostal', '$distance');";
					
					// $res=mysql_query($sqlq);									
						// if (!$res) {				
							// //--TO DO SET FLAG HERE
							// echo("Error ".mysql_error());
						// }				
			}
			
		}
		if ($operation=="listfiles") {
			$tmp=array();
			//--Use the client id
			
			if ($handle = opendir("definition/")) {
				$total=0;
				$totalsize=0;
				
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$size=filesize("definition/".$entry);
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
					if (is_readable("definition/".$_REQUEST['filename'])) {
						unlink("definition/".$_REQUEST['filename']);						
						}
				}				
			}
			exit();
		 }
		 
		
		if ($operation=="info") {
			//--Return a JSON of the publicite
			$tmp= file_get_contents_utf8("http://mygrocerytour.com/statistiques/users.pub_shown.data");
			$tmp_array=explode("\n",$tmp); //--Read by line
			
			$data_array=array();
			
			for ($i=0;$i<count($tmp_array);$i++)  
				{
					$line=json_decode($tmp_array[$i], true);
					
					print_r($line);
					
					$codePostal=$line['user_info'][9];
					$pub=$line['show_pub'];
					if (isset($data_array[$pub])) {
						$data_array[$pub]['count']++;
					} else {
						$data_array[$pub]=array();
						$data_array[$pub]['count']=1;
						$data_array[$pub]['codePostal']=array();						
						$data_array[$pub]['count_clicked']=0;
					}
					if (isset($data_array[$pub]['codePostal'][$codePostal])) {
						$data_array[$pub]['codePostal'][$codePostal]++;
					} else {
						$data_array[$pub]['codePostal'][$codePostal]=1;
					}
					
					//--Get clicked info
					$tmp= file_get_contents_utf8("http://mygrocerytour.com/statistiques/users.pub.".$pub);
					$lt=explode("\n",$tmp);
					$data_array[$pub]['count_clicked']+=count($lt);
				}
			
			echo json_encode($data_array);
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
				
		 <link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.0.1-p7/js/bootstrap.min.js"></script>		
	
		<script src="js/jqm/jquery.mobile-1.3.1.min.js"></script>				
		<script type="text/javascript" src="js/angular.min.js"></script>
		<script type="text/javascript" src="js/localStorageModule.js"></script>    
			
		<link rel="stylesheet" href="js/jqm/jqm-datebox.min.css" />
		<script type="text/javascript"  src="js/jqm/jqm-datebox.core.min.js"></script>
		<script type="text/javascript"  src="js/jqm/jqm-datebox.mode.calbox.min.js"></script>
		
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>		
		<!-- load angular -->
		<script type="text/javascript">
						
					//////////////////////////////////////////////////////////
					/// MAIN APPLICATION
					
					var parsedUrl = $.mobile.path.parseUrl( location.href );
					
					// if (parsedUrl.hrefNoHash!=parsedUrl.href) {
						// var newurl=parsedUrl.href.substring(parsedUrl.hrefNoHash.length);
						// location.href=parsedUrl.hrefNoHash;
						// //$.mobile.changePage( newurl, { changeHash: false });
					// }
					
					var myApp = angular.module('myApp',['LocalStorageModule']).config(function($locationProvider) {					
							$locationProvider.html5Mode(true);						
					});			
										
					/////////////////////////////////////////////////////////////
					/// MAP
					
					/*
				   Be sure we have some data before showing some page
				*/
										
		</script>
     <!--------------------------------------------------------------------------------
		-------------------------  LOAD SOME ANGULAR --------------------------------------
		---------------------------------------------------------------------------------->
		<script type="text/javascript" src="js/factory/factoryAdmin.js"></script>	
		<script type="text/javascript" src="js/controler/mainCtrlAdmin.js"></script>
		<script type="text/javascript" src="js/taffy-min.js"></script>	
		<script type="text/javascript" src="js/filter/currency.js"></script>
		<script type="text/javascript" src="js/filter/date.js"></script>
		<script type="text/javascript" src="js/util.js"></script>
		<script type="text/javascript" >
		 $(document).delegate("#new_pub", "pagebeforeshow",
					function (event) {
							 var $scope=  angular.element($(this)).scope();
							// console.log($scope);
							 $scope.load_map();
							 $scope.$apply();							
				 });
		</script>
		<!-- MAP -->
		
		<style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
   <?php 			
			//--Insert in the scope the user privilege
			//--This make all bug ...
			echo "<script>var log_admin = $user_privilege;</script>";
			//--If not logged -> display the login dialog...
			//-- AND DON'T LOAD ANYTHING ELSE!
			//--Echo the associated javascript
			
			if ($user_privilege!=-1) {
						echo '
						<script type="text/javascript">
						var myApp = angular.module("myApp",["LocalStorageModule"]).config(function($locationProvider) {					
								$locationProvider.html5Mode(true);
						});		
						$(document).ready(function() { 
							$("#login-submit").click(function(event){
										var email = document.getElementById("email").value;
										var pass  = document.getElementById("pass").value;
										var retour = func_login(email,pass);
								});  
						});
						
						function func_login(email,pass){
							$.ajax({
								type: "POST",
								url:  "login.php",
								data: ({emailConnexion: email , passwordConnexion: pass}),
								cache: false,
								async: true,
								dataType: "text",
								success: onSuccess,
								error: function (data) {console.log("error");console.log(data);}
							});				
							function onSuccess(data){ 
								console.log("Connexion : " + data);
								if(data == "success_login"){
									location.reload(true);
								}
								else if(data == "email_inexistant"){
									$("#messageLogin").html("<font color=red>Email inexistant</font>");
								}
								else if(data == "failed_login"){
									$("#messageLogin").html("<font color=red>Mot de passe incorrect</font>");
								}
							}
							}
							
							</script>
							
							<body>
								<div data-role="dialog" id="popupMenu" data-theme="b" data-transition="pop" data-position-to="window">
									  <div data-role="content">
										<div style="padding:10px 20px;">
											<h3>
											Please log to mygrocerytour.com
											</h3>											
											<div id="messageLogin"></div>
											<form>
											<label for="email" class="ui-hidden-accessible">Email:</label>
											<input type="text" name="email" id="email"  ng-model="email" placeholder="email" data-theme="c" />
											<label for="pass" class="ui-hidden-accessible">Password:</label>
											<input type="password" name="pass" id="pass" ng-model="password" placeholder="password" data-theme="c" />
											</form>	
											<button id="login-submit" data-theme="b" data-icon="check">Log in</button>
										</div>
									</div>
								</div>
						</body></html>';
				exit();
				}
			?>

</HEAD>
	
	<BODY ng-controller='MainCtrl'>
	
	<!--------------------------------------------------------------------------------
				---------------------  DEFINITIONS FILE  -----------------------------
		---------------------------------------------------------------------------------->
		<div data-role="page" id="pagePrincipale">
            <div data-role="header" data-theme="b">
				<a target="_self" href="index.php" data-icon="arrow-l">Back</a>
				<a target="_self" ng-click='regenerate_front_pub()' data-icon="refresh">Regenerate Front-End<span id='refresh_front_end_pub'></span> </a>
                <H1>IMPORT IMAGE DEFINITION</H1>
            </div>
            <div data-role="content">
                <div class="content-primary" ng-controller='MainCtrl'>
					 <!-- <input placeholder="Search date..." data-type="search"  ng-model="search" class="ui-input-text ui-body-c" ng-click='search=""'> -->					
					
					 <table class="table table-condensed panel">  	  	  
					  <thead>
						  <th>Date</th>
						  <th>Definition</th>
						  <th>Results</th>						  
						  <th>Info</th>
					  </thead>
					  <tbody>
						  <!-- | filter:search  table-bordered table-striped table-hover-->
						  <tr ng-repeat="pub in ( totalPublicite = (publicite | filter:search | orderBy:uend ) | limitTo:20 )">		
						  <td>
							<img class='img-polaroid' style='max-width:100px;max-heigth:200px;' src='../pub/{{pub.image_fr}}'></img>
							{{pub.ustart | datelg:'dd MMM yyyy'}} - {{pub.uend| datelg:'dd MMM yyyy'}} ({{pub.click_count}} click)
						  </td>
						  <td>
						  	<span ng-show="pub.where==0">Haut</span>
						  	<span ng-show="pub.where==1">Bas</span>
						  	<span ng-show="pub.where==2">Coté</span>
						  </td>
						   <td>
						   {{pub.codePostal}} - {{pub.distance}} km
							</td>
							<td>
							{{pub.url}}
							<span ng-show="pub.status==2" class="label label-default">inactive</span>
							<span ng-show="pub.status==1" class="label label-success">active</span>
							</td>
							<td>
							<!-- <button type="button" data-role='none' class="btn btn-primary" ng-click='edit_publicite(pub)'>Edit</button>  -->
							<button type="button" data-role='none' class="btn btn-danger" ng-click='remove_publicite(pub.id_publicite)'><i class="icon-trash"></i> Delete</button>
							</td>
						  </tr>
						  <tr>
							  <td colspan=4>									
							 <a target="_self" href="#new_def" class="btn btn-large btn-primary" data-role='none' >Upload new definition</a>				  
							  </td>															 							 
						  </tr>
					</tbody>
					 </table>	
					 
                </div>
            </div>
			<div data-role="footer" class="ui-bar" data-theme="b">
				
			</div>
        </div>
	<!--------------------------------------------------------------------------------
				---------------------  NEW  -----------------------------
	---------------------------------------------------------------------------------->
	<div data-role="page" id="new_def">
            <div data-role="header" style="padding:0px" data-theme="b">                
                <!-- Show if we are logged or not -->
				<a target="_self" href="#pagePrincipale" data-rel="dialog" data-role="button" data-icon="arrow-l" data-transition="slide-down">Back</a> 
                <h1>Definition</h1>
            </div><!-- /header  -->
            <div data-role="content">

	<form target="_self" method=POST id="upload_file" action="upload_definition.php?action=upload" enctype="multipart/form-data">	
		  			<input type="text" style="display:none;" name="id_publicite" id="flyer_id" ng-model="pub.id_publicite" ng-init="new_pub_id()">																	
						
					<ul data-role="listview">
					 		
							<li>
								<div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="input-group">
									<div class="form-control uneditable-input span3" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
									<span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input data-role="none" type="file" name="file_fr"></span>
									<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								  </div>
								</div>		
										
										<div class="alert alert-info">					 
											<strong><i class="icon-info-sign"></i></strong> Note: the definition file must be in the format of the <a href='template_produit.xls'>template</a> and be in tab-separated value '.tsv'<br>
																							To prepare it, just export in excel using the tab-separated value export option.
										</div>		
										<button class="btn btn-large btn-primary" data-role='none' ng-click='create_definition()'>Upload new definition</button>
								</div>
								
							</li>
					</ul>
					
			</form>	
		<div data-role="footer" class="ui-bar" data-theme="b">
					
		</div>
	</div>
	
	
	</BODY>
</HTML>	
<?php 
@deconnection_db();	
?>	