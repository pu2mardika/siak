<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$row=$row_data;

echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));
	
	foreach($field as $fd){
	?>
	<div class="form-group input">
		<label class="col-sm-4 col-xs-12 control-label" for="<?php echo $fd;?>" ><?php echo $this->lang->line($fd);?></label>
		<div class="col-sm-8 col-xs-12">
			<?php 
			$wajib=(in_array($fd,$WAJIB))?"":'required="required"';
			if(in_array($fd,$has_ref)){
				$colmn= $opsi[$fd];
				echo form_dropdown($fd,$colmn,$row[$fd],'class="form-control input-sm"'.$wajib.'" id="'.$fd.'"" title="'.$this->lang->line($fd).'"'); 
			}else{
			 	$adclas="";
				$val =isset($row[$fd])?$row[$fd]:'';
				echo '<input type="text" class="form-control input-sm '.$adclas.'" id="'.$fd.'" name="'.$fd.'" value="'.$val.'" '.$wajib.'/>';
			}
			?>
		</div>	    
	</div>
<?php } 
echo form_close();
?>