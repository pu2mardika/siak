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
			    margin-bottom: 2cm !important; 
	        }
	        
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
    			page-break-after: always;
    			margin: 0 0 20px 0;
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
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                background-color: #b5b4aa;
                color: #000000;
            }
            
            
			#table td{
                padding: 2px 3px;
                font-size:12px;
                border: 1px solid #000000;
                word-break: break-all;
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
            }
            
            #table tr.data td {
             /*   border-top: 1px solid #000000; */
                border-top: none;
                border-bottom: none;
            }
             #table tr.bottom td{
                border-top: none;
                color: #5f2eff;
            }
            
            #table tr.total td{
                color: #000000;
                background-color: #d7dae2;
                font-weight: bold;
                font-size:13px;
            }
            
            #table tr:nth-child(even){background-color: #fcfcfc;}

          /*  #table tr:hover {background-color: #ddd;}*/
          
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
		    <h3>BUKU BESAR <h5><?php echo $subtitle; ?></h5></h3>
		</div>
		
		<?php
		$Jdebet = 0; $Jkredit = 0;
		foreach ($rsdata as $AcID => $rdata){
		?>
		<span>Perkiraan:&nbsp;<?php echo $AcID."-".$rdata['nama_akun'];?></span>
		<table id="table"cellspacing="0">
		    <thead>
		        <tr style="height: 30px">
		            <th width="12%">Tanggal</th>
		            <th width="28%">Uraian</th>
		            <th width="6%">Ref</th>
		            <th width="18%">Debet</th>
		            <th width="18%">Kredit</th>
		            <th width="18%">Saldo</th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php
				$Jdebet = 0; $Jkredit = 0; $saldo=0;
				$recSet = $rdata['recSet'];
				foreach ($recSet as $data){
					$Jdebet += $data['debet'];
					$Jkredit += $data['kredit'];
					$saldo = abs($Jdebet - $Jkredit);
			?>
					<tr>
						<td class="nowrapped top" align="left"><?=format_date($data['tanggal'])?></td>
						<td class="nowrapped top" align="left"><?=$data['deskripsi']?></td>
						<td class="nowrapped top" align="center">JU-</td>
						<td class="nowrapped top" align="right"><?=format_angka($data['debet'])?></td>
						<td class="nowrapped top" align="right"><?=format_angka($data['kredit'])?></td>
						<td class="nowrapped top" align="right"><?=format_angka($saldo)?></td>
					</tr>					
			<?php } //END FOREACH recSet ?>  
			 	
				<tr class="total">
					<td colspan="3">JUMLAH</td>
					<td align="right"><?=format_angka($Jdebet)?></td>
					<td align="right"><?=format_angka($Jkredit)?></td>
					<td align="right"><?=format_angka($saldo)?></td>
				</tr>
		    </tbody>
		</table>
		<?php } //END FOREACH RSDATA ?>
		
  </body>
</html>