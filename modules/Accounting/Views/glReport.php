<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title_report;?></title>
        <style>
            @page {
	            padding: 0 !important;
	            size: 21cm 29.7cm;
			    margin-top: 2cm !important;
			    margin-bottom:2cm !important; 
	        }
	        
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
    			/*page-break-after: auto;*/
    			margin: 0 0 5px 0;
    			box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    			table-layout: fixed;
            }
            
            hr, h2, h3 {
            	margin: 0;
            }
            
            h5{
   				font-weight:lighter !important;
            }

           #table th {
                border: 1px solid #000000;
                padding: 2px;
                font-size:14px;
            }
            
			#table td{
                padding: 2px 3px;
                font-size:12px;
                border: 1px solid #000000;
                word-break: break-all;
                break-inside: avoid;
            }
		    
            tr {
	          break-inside: avoid;
	        }
	        
	        tr.main{
	        	page-break-inside: avoid; page-break-after: avoid;
	        }
            
            #table tr td.top{
             /*   border-top: 1px solid #000000; */
                border-bottom: none;
                page-break-inside: avoid; page-break-after: avoid;
                page-break-before: auto;
            }
            
            #table tr.data td {
             /*   border-top: 1px solid #000000; */
                border-top: none;
                border-bottom: none;
                page-break-inside: avoid; page-break-after: avoid; page-break-before: avoid;
            }
             #table tr.bottom td{
                border-top: none;
                color: #5f2eff;
                page-break-before: avoid;
            }
            
            #table tr.total td{
                color: #000000;
                background-color: #d7dae2;
                font-weight: bold;
                font-size:13px;
            }
            
           /* #table tr:nth-child(even){background-color: #fcfcfc;}

            #table tr:hover {background-color: #ddd;}*/

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                background-color: #dcdbce;
                color: #000000;
            }
            
            div {
			    word-wrap: break-word;         /* All browsers since IE 5.5+ */
			    overflow-wrap: break-word;     /* Renamed property in CSS3 draft spec */
			    width: 100%;
			    page-break-inside: avoid; page-break-after: avoid;
			}
                        
        </style>
    </head>
    <body>
		<div style="text-align:center">
			<h2><?php echo setting('MyApp.companyName'); ?></h2>
		    <h3>JURNAL UMUM <h5><?php echo $subtitle; ?></h5></h3>
		</div>

		<table id="table"cellspacing="0">
		    <thead>
		        <tr style="height: 30px">
		            <th width="11%">Tanggal</th>
		            <th width="11%">No Bukti</th>
		            <th width="45%">Uraian</th>
		            <th width="5%">Ref</th>
		            <th width="14%">Debet</th>
		            <th width="14%">Kredit</th>
		        </tr>
		    </thead>
		    <tbody>
		      	 <?php
				$Jdebet = 0; $Jkredit = 0;
				foreach ($rsdata as $data){
				//$no++;
				$ndb = count($data['debet']);
				$ncr = count($data['kredit']);
				$rowspan = $ndb + $ncr + 1
			?>
					<tr class="main">
						<td class="nowrapped top"><div><?=formatTgl($data['tanggal'])?></div></td>
						<td class="nowrapped top"><div><?=$data['no_bukti']?></div></td>
						<?php 
						$debet = $data['debet'];
						$db =$debet[0];   unset($debet[0]);
						echo '<td class="nowrapped top" align="left">'.$db['nama_akun'].'</td>';
						echo '<td class="nowrapped top" align="center">'.$db['kode_akun'].'</td>';
						echo '<td class="nowrapped top" align="right">'.format_angka($db['debet']).'</td>';
						echo '<td class="nowrapped top" align="right">'.format_angka($db['kredit']).'</td>';
						$Jdebet += $db['debet'];
						$Jkredit += $db['kredit'];
						?>
					</tr>
					<?php 
					//INPUT DATA DEBET berikutnya
					
					if(count($debet) > 0){
						foreach($data['debet'] as $db){ ?>
							<tr class="data">
								<td></td><td></td>
								<td class="nowrapped" align="left"><?=$db['nama_akun']?></td>
								<td class="nowrapped" align="center"><?=$db['kode_akun']?></td>
								<td class="nowrapped" align="right"><?=format_angka($db['debet'])?></td>
								<td class="nowrapped" align="right"><?=format_angka($db['kredit'])?></td>
							</tr>
				   <?php
							$Jdebet += $db['debet']; $Jkredit += $db['kredit'];
						} //END FOREACH DEBET
					} //END IF DEBET
					
					//TULIS DATA KREDIT
					$kredit =$data['kredit'];
					if(count($kredit) > 0){
						foreach($data['kredit'] as $cr){ 
							$deskripsi = "&nbsp;&nbsp;&nbsp;&nbsp;".$cr['nama_akun']
					?>
							<tr class="data">
								<td></td><td></td>
								<td class="nowrapped" align="left"><?=$deskripsi?></td>
								<td class="nowrapped" align="center"><?=$cr['kode_akun']?></td>
								<td class="nowrapped" align="right"><?=format_angka($cr['debet'])?></td>
								<td class="nowrapped" align="right"><?=format_angka($cr['kredit'])?></td>
							</tr>
				   <?php
							$Jdebet += $cr['debet']; $Jkredit += $cr['kredit'];
						} //ENDIF FOREACH KREDIT
					} //ENDIF KREDIT ?>
					<tr  class="bottom">
				 		<td></td><td></td>
				 		<td>(<i><?=$data['deskripsi']?></i>)</td><td></td><td></td><td></td>
				 	</tr>
			<?php } //END FOREACH RDATA ?>  
			 	
				<tr class="total">
					<td colspan="3">JUMLAH</td><td></td>
					<td align="right"><?=format_angka($Jdebet)?></td>
					<td align="right"><?=format_angka($Jkredit)?></td>
				</tr>
		    </tbody>
		</table>
		
  </body>
</html>