
		  <tr><td><br><b>Strategy</b> (See MAFFT <a href='http://mafft.cbrc.jp/alignment/software/algorithms/algorithms.html' target='_blank'>algorithms</a>)<td></tr>
		
			<tr><td>
				<table class='blue' width='100%'>
		 			<tr>
						<td>
							<input type='radio' name='mafft_strategy' value='mafft_auto' onclick='javascript:select_manual(0)' checked> Auto (FFT-NS-1, FFT-NS-2, FFT-NS-i or L-INS-i; depends on data size)		
							<br><input type='radio' name='mafft_strategy' value='mafft_FFT-NS-2' onclick='javascript:select_manual(0)'> FFT-NS-2 (Fast; progressive method) 
	   					<br><input type='radio' name='mafft_strategy' value='mafft_FFT-NS-1' onclick='javascript:select_manual(0)'> FFT-NS-1 (Very fast; recommended for >2000 sequences; progressive method with a rough guide tree)
							<br><input type='radio' name='mafft_strategy' value='mafft_FFT-NS-i' onclick='javascript:select_manual(0)'> FFT-NS-i (Medium; iterative refinement method, two cycles only) 
							<br><input type='radio' name='mafft_strategy' value='FFT-NS-i2' onclick='javascript:select_manual(0)'> FFT-NS-i (Slow; iterative refinement method) 
							<br><input type='radio' name='mafft_strategy' value='mafft_E-INS-i' onclick='javascript:select_manual(0)'> E-INS-i (Very slow; recommended for <200 sequences with multiple conserved domains and long gaps)	
							<br><input type='radio' name='mafft_strategy' value='mafft_L-INS-i' onclick='javascript:select_manual(0)'> L-INS-i (Very slow; recommended for <200 sequences with one conserved domain and long gaps)
							<br><input type='radio' name='mafft_strategy' value='mafft_G-INS-i' onclick='javascript:select_manual(0)'> G-INS-i (Very slow; recommended for <200 sequences with global homology)
							<br><input type='radio' name='mafft_strategy' value='mafft_manual' onclick='javascript:select_manual(1)'> Manual parameters (see below)
		 				</td>
		 			</tr>
				</table>
			</td></tr>
		<tr><td>		
		<table id='TableManual' width='100%><tr width='100%'>
		<td align='left'><br><b>Manual parameters </b>(See MAFFT <a href='http://mafft.cbrc.jp/alignment/software/manual/manual.html' target='_blank'>manual</a>)<td></tr>
			<tr><td>
				<table class='blue' width='100%' >
		 			<tr>		
						<td>Tree rebuilding number (default=2)</td>
		               <td><SELECT name='mafft_retree' disabled>		
							<option value='0'   >0 (fast)</option>
							<option value='1'   >1 (for big alignment)</option>
							<option value='2' selected  >2 (default)</option>
							<option value='5'   >5</option>		
							<option value='10'   >10</option>
							<option value='20'   >20</option>
							<option value='50'   >50</option>
							<option value='80'   >80</option>
							<option value='100'   >100 (long run / small alignment)</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
		 			<tr>			
						<td>Maxiterate (default=0)</td>
		               <td><SELECT name='mafft_maxiterate' disabled>		
							<option value='0' selected >0 (fast)</option>
							<option value='1'   >1</option>
							<option value='2' > 2 (for big alignment)</option>
							<option value='5'   >5</option>		
							<option value='10'   >10</option>
							<option value='20'   >20</option>
							<option value='50'   >50</option>
							<option value='80'   >80</option>
							<option value='100'   >100 (long run / small alignment)</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
		 			<tr>	
						<td>Perform FFTS</td>
		               <td><SELECT name='mafft_ftts' disabled onchange='mafft_fttsChanged()'>	
							<option value='mafft_none' selected >none</option>
							<option value='mafft_localpair' >localpair</option>
							<option value='mafft_genafpair' >genafpair</option>
							<option value='mafft_globalpair'>globalpair</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
		 			<tr>	
		      		<td colspan=2><input type=checkbox name='mafft_nofft' disabled>
						Do not use FFT approximation (for long aligment)				
		 				</td>
		 			</tr>
    			</table>
			</td></tr></table></td></tr>
		  <tr><td><br><b>Other parameters</b><td></tr>
		
			<tr><td>
				<table class='blue' width='100%'>
		 			<tr>		
						<td>Sequence <b>type</b> (nucleotides or amino acids)
		               <SELECT name='mafft_type' onChange='mafft_typeChanged()'>		
							<option value='mafft_nucauto' >Automatic</option>
							<option value='mafft_nuc'     >Nucleotides</option>
							<option value='mafft_amino'   >Amino acids</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
		 			<tr>		
						<td>Output <b>format</b>
		               <SELECT name='mafft_output'>		
							<option value='mafft_output_fasta' selected>FASTA</option>
							<option value='mafft_phylipout'   >PHYLIP</option>
							<option value='mafft_clustalout'   >ClustalW</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
		 			<tr>		
						<td>Output <b>order</b>
		               <SELECT name='mafft_output_order'>		
							<option value='mafft_output_order' >Same as input</option> 
							<option value='mafft_reorder' >Aligned</option>
						</SELECT></td>	
		 				</td>
		 			</tr>
				</table>
			</td></tr>
			<tr><td>
	
				<table class='blue' width='100%'>
		 			<tr>		
						<td>Substitution matrix (Amino acids)
		               <SELECT name='mafft_matrix'>		
							<option value='BLOSUM 30'   >BLOSUM 30</option>
							<option value='BLOSUM 45'   >BLOSUM 45</option>
							<option value='BLOSUM 62' selected  >BLOSUM 62</option>
							<option value='BLOSUM 80'   >BLOSUM 80</option>		
							<option value='JTT PAM 100'   >JTT PAM 100</option>
							<option value='JTT PAM 200'   >JTT PAM 200</option>
						</SELECT></td>			
		 			</tr>
		 			<tr>		
						<td>Substitution matrix (Nucleotides)
		
		               <SELECT name='mafft_kimura'>		
							<option value='1'   >1PAM / &kappa;=2</option>
							<option value='20'   >20PAM / &kappa;=2</option>
							<option value='200' selected  >200PAM / &kappa;=2</option>		
						</SELECT>
		     * Switch it to '1PAM / &kappa;=2' when aligning closely related DNA sequences.
		     </td>			
		 			</tr>
		           <tr>						
						<td>Gap opening penalty (1.0 - 3.0) 
		      		<input type=checkbox name='checkbox_gop' onclick='gop_Changed()'><input type=text name='mafft_gop' size='5' value='$mafft_gop' disabled>		
		 				</td>
		 			</tr>
		           <tr>						
						<td>Offset penalty (0.0 - 1.0) 
		      		<input type=checkbox name='checkbox_lep' onclick='lep_Changed()'><input type=text name='mafft_lep' size='5' value='$mafft_lep' disabled>		
		 				*If long gaps are not expected, set it as 0.1 or larger value.</td>
		 			</tr>
				</table>
			</td></tr>