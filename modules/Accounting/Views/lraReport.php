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
			    margin: 1cm !important;
			  /*  margin-bottom: 1cm !important; */
	        }
	        
            #table {
                font-family: "Times New Roman", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
    			page-break-after: auto;
    			margin: 0 0 20px 0;
    			/*box-shadow: 0 1px 3px rgba(0,0,0,0.2);*/
    			
            }
            
            hr, h2, h3 {
            	margin: 0;
            }
            
            h5{
   				font-weight:lighter !important;
            }

                       
            #table td{
                padding: 2px 3px;
                font-size:14px;
                word-break: break-all;
              /*  border: 1px solid #000000;*/
            }
		    
            tr {
	            page-break-inside: avoid; page-break-after: avoid;
	        }
	        
            #table tr.subtotal td{
                color: #000000;
               /* background-color: #e1f5d1;*/
                font-weight: bold;
                font-size:14px;
            } 
            
            #table tr.total td{
                color: #000000;
             /*   background-color: #8e9a84;*/
                font-weight: bold;
                font-size:14px;
            }  
            
            #table tr.subtotal td.subx {
                border-top: 1px solid #000000;
            } 
            
            #table tr.subtotal td.subtotal {
                border-bottom: 1px solid #000000;
            }
            
            #table tr.total td.total {
                border-top: 1px solid #000000;
            }
            
            #table tr.total td.totx {
                border-top: 1px solid #000000;
            }
            
            span.a {
			  display: inline-block; /* the default for span */
			  width: 120px;
			  padding: 5px;  
			}

			span.b {
			  display: inline-block;
			  width: 120px;
			  height: 100px;
			  padding: 5px;
			  border: 1px solid blue;    
			  background-color: yellow; 
			}

            
        </style>
    </head>
    <body>
		<div style="text-align:center">
			<h2><?php echo setting('MyApp.companyName'); ?></h2>
		    <h3>LAPORAN PERHITUNGAN SHU <h5><?php echo $subtitle; ?></h5></h3>
		</div>
		
		<table id="table" cellspacing="0">
			<thead>
		        <tr>
		            <th width="3%"></th>
		            <th width="30%"></th>
		            <th width="3%"></th>
		            <th width="16%"></th>
		            <th width="3%"></th>
		            <th width="17%"></th>
		            <th width="3%"></th>
		            <th width="18%"></th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php
		    	$jhead = 0; $RL = 0;
		    	foreach ($gdata as $ops){
					$jdata = $ops['data'];
					 $ndata =0;
					//pengulangan untuk masing-masing data
					foreach($jdata as $i =>$hdr)
					{
						if(array_key_exists($i, $rsdata)){
							$recSet = $rsdata[$i];
							echo "<tr><td colspan='8'>&nbsp;</td></tr>";
							echo "<tr><td colspan='3'>".strtoupper($hdr['title'])."</td><td></td><td></td><td></td><td></td><td></td></tr>"; //BRS JUDUL
							$subtotal=0;
							//pengulangan baris data perkiraan BB
							foreach ($recSet as $data){
								//test_result($data);
								echo "<tr>
										<td></td>
										<td>".$data['nama_akun']."</td>";
								if($hdr['type']=='mix'){
									$koef=($data['norm_balance']=="Kr")?1:-1;
									$amount = $data['amount'] * $koef;
									echo "<td align='right'>Rp</td>";
									echo "<td align='right'>".format_angka($amount)."</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>";
								}
								
								if($hdr['type']=='pure'){
									$amount = $data['amount'];
									echo "<td></td><td></td><td align='right'>Rp</td><td align='right'>".format_angka($amount)."</td><td></td><td></td>";
								}
								echo "</tr>"; //BARIS DATA
								$subtotal +=$amount;
								$ndata++; // menghitung jumlah data di opsi bersangkutan
							} 
							echo "<tr class='subtotal'>
									  <td colspan='3'>Jumlah ".$hdr['title']."</td>
									  <td></td>
									  <td></td>
									  <td class='subx'></td>
									  <td class='subtotal' align='right'>Rp</td>
									  <td class='subtotal' align='right'>".format_angka($subtotal)."</td>
								  </tr>"; //BARIS Subtotal per Kelompok perkiraan
							
							$tot = $subtotal * $hdr['koef'];
							$RL += $tot;
						} //END IF IS KEY EXIST	
						// 
					} //END FOREACH JDATA
					
					if($ndata > 0){ //menambahkan subtotal untuk masing masing kelompok Laporan
						$jhead++;
						echo "<tr class='total'>
								  <td colspan='3'>".$ops['title']."</td>
								  <td></td>
								  <td></td>
								  <td></td>
								  <td class='total' align='right'>Rp</td>
								  <td class='total' align='right'>".format_angka($RL)."</td>
							  </tr>"; //BARIS Subtotal per Kelompok perkiraan	  
					}
			?>				
			<?php } //END FOREACH recSet 
				  if($jhead > 2){
				  echo "<tr class='total'>
							  <td colspan='3'>Jumlah".$ops['title']."</td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td class='total' align='right'>Rp</td>
							  <td class='total' align='right'>".format_angka($RL)."</td>
						</tr>"; //BARIS Subtotal per Kelompok perkiraan
				   echo "<tr><td colspan='8'>&nbsp;</td></tr>";
				  }
			?>  
		    </tbody>
		</table>
		<br>
		<div><span class="a">Disahkan di</span><span class="a">: Amlapura</span>	</div>
		<div><span class="a">Pada tanggal</span><span class="a">:&nbsp;<?php echo format_date($periode['akhir']);?></span>	</div>
		
		<?php 
        //CEK CATATAN KAKI

        if(isset($otorisator))
        {
        	echo "<br/>";
        	$lebar = 100/count($otorisator);
        	
        	echo '<div align="center"><strong>'.$otorisator['group_name'].'</strong></div><br>';
        ?>
        	<table width="100%" cellpadding="0" cellspacing="0">
        		<tr>
        			<?php
        			$komponen = $otorisator['komponen'];
        			foreach($komponen as $k => $val)
        			{
        				echo '<td width="'.$lebar.'%"><div align="center">';
        				echo $val['jabatan'].'<br/><br/><br/><br/>';   //JABATANsu
        				echo "<strong>".$val['nama'].'</strong>';
        				echo '</div></td>';
        			}
        			?>
        		</tr>
        	</table>
        <?php
        }
        
        if(isset($validator))
        {
        	echo "<br/>";
        	$lebar = 100/count($validator);
        ?>
        	<table width="100%" cellpadding="0" cellspacing="0">
        		<tr>
        			<?php
        			foreach($validator as $k => $val)
        			{
        				echo '<td width="'.$lebar.'%"><div align="center">';
        				echo $val['jabatan'].'<br/><br/><br/><br/>';   //JABATAN
        				echo "<strong>".$val['nama'].'</strong><br/>';
						echo (array_key_exists('nip', $val))?"NIP. ".$val['nip']:"";
        				echo '</div></td>';
        			}
        			?>
        		</tr>
        	</table>
        <?php
        }
        ?>
		
  </body>
</html>