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
			    margin-top: 1cm !important;
			    margin-bottom: 1.5cm !important; 
	        }
            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
    			page-break-after: auto;
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
                text-align: left;
                background-color: #dcdbce;
                color: #000000;
            }
			
			#table td{
                border: 1px solid #000000;
                padding: 2px 3px;
                font-size:13px;
                word-break: break-all;
            }
            
            tr {
	          break-inside: avoid;
	        }
	        
	        #table td.nowrapped{
	        	white-space: nowrap;
	        }
	        
	        #table td.nowrapped{
	        	white-space: nowrap;
	        }
	        
            #table tr:nth-child(even){background-color: #fcfcfc;}

            #table tr:hover {background-color: #ddd;}
        
            .ver-minimalist th {
				border-bottom:1px solid #6678b1;
				border-left:3px solid #fff;
				border-right:2px solid #a39fc6;
				color:#039;
				font-size:14px;
				font-weight:400;
				padding:2px;
				width:200px;
			}

			.ver-minimalist td {
				border-left:2px solid #fff;
				border-right:2px solid #fff;
				color:#669;
				font-size:14px;
				padding:2px;
			}
        </style>
    </head>
    <body>
    	<div style="text-align:center">
            <h2><?php echo setting('MyApp.companyName'); ?></h2>
        </div>
        <hr>
        <div style="text-align:center">
            <h3><?php echo $title_report; ?>
            <?php echo (isset($subtitle))?'<h5>'.$subtitle.'<h/5>':"";?>
            </h3>
        </div>
        <?php if(isset($resume)){?>}
        <table class="ver-minimalist">
        	<?php
			  	$dfield = $resume['field'];
				$RData = $resume['data'];
			  	foreach($dfield as $k => $R)
			  	{
			  		echo "<tr><th>".$R['label']."</th><td>:</td>";
			  		echo "<td align='".$R['perataan']."'>".$RData[$k]."</td></tr>";
			  	}
			  	?>        	
        </table>
        <?php }?>
        <table id="table">
            <thead>
                <tr>
                    <?php 
						$setRowNum = (isset($setRowNum) && ($setRowNum == TRUE || $setRowNum == 1))?true:false;
						$ncol = 0;
						if($setRowNum){
							echo '<th width="5%"><div align="center">NO</div></th>';
							$ncol = 1;
						}
						
						$hasopt = [];
						foreach($fields as $k =>$row){
							$l = $row['width'];
							if($l > 0){
								$hfield[]=$k;
								if($row['type'] === 'dropdown')
								{
									$hasopt[]=$k;
								}
								echo '<th width="'.$l.'%"><div align="center">'.$row['label'].'</div></th>';
							}
						}
					?>
                </tr>
            </thead>
            <tbody>
              	 <?php
				//$encrypter = \Config\Services::encrypter();
			 	
				$no=0;
				foreach ($rsdata as $data){
				$no++; 
				$data = (is_object($data))?(array)$data:$data;
			?>
					<tr>
						<?php 
						if($setRowNum){
							echo '<td><div align="center">'.$no.'</div></td>';
						}
						foreach($hfield as $hc){
							$Algn = 'left';
							$dtval = $data[$hc];
							if($fields[$hc]['type']=='date')
							{
								if(isset($ori)){$dtval = unix2Ind($data[$hc],'d-m-Y');}
							}
							if(in_array($hc, $hasopt)){$dtval = $opsi[$hc][$data[$hc]];}
							
							if(is_integer($dtval)||is_float($dtval)||is_double($dtval)){$Algn = "right";$dtval = format_angka($dtval);}	
							echo '<td class="nowrapped" align="'.$Algn.'">'.$dtval.'</td>';
						}
						?>
						
					</tr>
			 <?php }  
			 	//cek has Totals
			 	if(isset($total))
			 	{
			 		//$colspan = $ncol + count($hfield) - count($hasTotal);
			 		$colspan = 0; $c = 0;
			 		echo "<tr>";
			 		$colspan = ($colspan > 0)?'<td colspan="'.$colspan.'">':'<td>';
			 		if($setRowNum){
						echo $colspan.'Total</td>'; $c = 1;
					}
		 			foreach($hfield as $hc){
						if(array_key_exists($hc, $total)){
							echo '<td class="nowrapped" align="right">'.format_angka($total[$hc]).'</td>';
						}else{
							echo ($c == 1)?$colspan."Total</td>":"<td></td>";
						}
					}
			 		echo "</tr>";
			 	}
			 ?>
            </tbody>
        </table>
        <?php 
        //CEK CATATAN KAKI
        
        //CEK OTORISATOR
        if(isset($otorisator))
        {
        	echo "<br/>";
        	$lebar = 100/count($otorisator);
        	
        	echo '<div align="center"><strong>'.$otorisator['group_name'].'</strong></div>';
        ?>
        	<table width="100%" cellpadding="0" cellspacing="0">
        		<tr>
        			<?php
        			$komponen = $otorisator['komponen'];
        			foreach($komponen as $k => $val)
        			{
        				echo '<td width="'.$lebar.'%"><div align="center">';
        				echo $val['jabatan'].'<br/><br/><br/><br/>';   //JABATAN
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