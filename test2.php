<div data-role="popup" id="popupInsertDataUpload" data-position-to="window" data-overlay-theme="a" data-theme="c" style="min-width:500px;max-width:500px;" class="ui-corner-all">
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<a href="#help" data-role="button" data-inline="true" data-icon="info" data-transition="fade" data-theme="b">Help</a>
						<div id='popupHeader'><h2>Insert Data</h2></div>
						<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					</div>
					
					<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
					
								<div data-role="collapsible" data-theme="e" data-content-theme="c" data-collapsed="false" data-collapsed-icon="info" data-expanded-icon="info" data-iconpos="right">
									<h3>Note</h3>
									<p>Select either data form an existing <b>dataset</b> or <b>upload new data</b> below. Alternatively, you can also insert an <b>empty object</b> into the workflow.</p>						
								</div>
								
								<div data-role="collapsible" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-collapsed="false"  id='usingData'>
										<h3>Choose from existing data</h3>
										<div data-role='fieldcontain' style='width:800px;'>
											<label for='select-choice-10' class='select' id='labelTitle'>Choose unaligned sequences</label>
											<select name='select-choice-10' id='select-choice-10' multiple='multiple' data-native-menu='false' >								
											</select>
										</div>
								</div>	
								
								<div data-role="collapsible" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" id='uploadData'>	
									<h3>Upload new data file (maximum file size is 20 mb)</h3>
									<form><input id="file_upload" name="file_upload" type="file" multiple="true"></form>	
								</div>		
								<!-- <div id="insert" data-role='fieldcontain'>        						
											<label for='select-choice-0' class='select'></label>
											<select name='select-choice-0' id='select-choice-0'  data-native-menu='false'></select>	
									 </div> -->
								  
														
											
									<p style='text-align:center;'>	
									<a href="javascript:uploadFile2('','');" data-role="button" data-inline="true" data-transition="flow" data-theme="b" style='text-align:center;'>Insert</a>  
									<a href="javascript:addDataEmpty('','','');" id='emptyData' data-role="button" data-inline="true" data-transition="flow" data-theme="c" style='text-align:center;'>Insert empty object</a>  							
									</p> 
						
					</div> <!--content popup -->						
    			</div>  