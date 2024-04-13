<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$row=$curriculum; 
	$keys=$this->config->item('dynamic_key');
	$ids=$this->kriptograf->paramEncrypt($row['id_curriculum'],$keys);

echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));
//`id_curriculum', 'id_prodi', 'curr_name', 'curr_desc', 'issued', 'state'
//prodi
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('prodi')."</label>";
echo form_dropdown('id_prodi',$cmb_prodi,$row['id_prodi'],'class="form-control input-sm" required="required" id="id_prodi" title="'.$this->lang->line('id_prodi').'"'); 
echo form_error('id_prodi','<span class="error">','</span>');
echo '</div>';

//currname
echo '<div class="form-group input">';
echo '<label for= "name">'. $this->lang->line('curr_name').'</label>';
echo '<input id="curr_name" type="text" class="form-control" required="required" name="curr_name" placeholder="'. 
 $this->lang->line('curr_name').'" title = "'.$this->lang->line('curr_name').'" value = "'.$row['curr_name'].'"/>';
echo form_error('nm_jurusan','<br><label></label><span class="error">','</span>'); 
echo '</div>';

//issued
echo '<div class="form-group input">';
echo "<label for='issued'>". $this->lang->line('curr_issued')."</label>";
echo '<input id="issued" type="text" class="form-control" required="required" name="issued"  value = "'.$row['issued'].'"/>';
echo form_error('issued','<span class="error">','</span>');
echo '</div>';

//curr_desc
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('curr_desc')."</label>";
echo '<textarea id="desc" name="curr_desc" rows="10" class="form-control editor" required="required">'.$row['curr_desc'].'</textarea>';
echo form_error('curr_desc','<span class="error">','</span>');
echo '</div>';

//state
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('state')."</label>";
echo form_dropdown('state',$options,$row['state'],'class="form-control input-sm" required="required" id="jenjang" title="'.$this->lang->line('state').'"'); 
echo form_error('state','<span class="error">','</span>');
echo '</div>';
//submit button
echo '<div class="form-group input">';
echo "<label for='submit'></label>";
echo '<button name="simpan" type="submit" class="btn btn-primary">'.$this->lang->line('save').'</button>';
echo '</div>';
echo form_close();
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idprodi").focus();
        $( 'textarea.editors' ).ckeditor();
		$( 'textarea' ).ckeditor( {
		    toolbar: [
				{ name: 'document', items: [ 'Source'] },
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],	
				{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat'] }
			]
		} );
		$( 'textarea' ).ckeditor( {
			uiColor: '#9AB8F3'
		});
		
		$('#issued').datetimepicker({
	        locale: 'id',
	        format: 'DD-MM-YYYY',
	        maxDate : 'now'
	    });
	    return false;
    });
</script>