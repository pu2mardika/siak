<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));
//`id_curriculum`, `curr_name`, `issued`, `curr_desc`, `state`
//prodi
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('prodi')."</label>";
echo form_dropdown('id_prodi',$cmb_prodi,'','class="form-control input-sm" required="required" id="id_prodi" title="'.$this->lang->line('id_prodi').'"'); 
echo form_error('id_prodi','<span class="error">','</span>');
echo '</div>';
//currname
echo '<div class="form-group input">';
echo '<label for= "name">'. $this->lang->line('curr_name').'</label>';
echo '<input id="curr_name" type="text" class="form-control" required="required" name="curr_name" placeholder="'. 
 $this->lang->line('curr_name').'" title = "'.$this->lang->line('curr_name').'"/>';
echo form_error('nm_jurusan','<br><label></label><span class="error">','</span>'); 
echo '</div>';
//issued
echo '<div class="form-group input">';
echo "<label for='issued'>". $this->lang->line('curr_issued')."</label>";
echo '<input id="issued" type="text" class="form-control" required="required" name="issued"/>';
echo form_error('issued','<span class="error">','</span>');
echo '</div>';
//curr_desc
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('curr_desc')."</label>";
echo '<textarea id="desc" name="curr_desc" rows="5" class="form-control editor" required="required"></textarea>';
echo form_error('curr_desc','<span class="error">','</span>');
echo '</div>';
//curr_l_duration
echo '<div class="form-group input">';
echo '<label for= "l_duration">'. $this->lang->line('curr_l_duration').'</label>';
echo '<input id="l_duration" type="text" class="form-control" required="required" name="l_duration" placeholder="1" title = "'.$this->lang->line('curr_l_duration').'"/>';
echo form_error('l_duration','<br><label></label><span class="error">','</span>'); 
echo '</div>';
//curr_system
echo '<div class="form-group input">';
echo "<label for='curr_system'>". $this->lang->line('curr_system')."</label>";
echo form_dropdown('curr_system',$ls_options,'','class="form-control input-sm" required="required" id="curr_system" title="'.$this->lang->line('curr_system').'"'); 
echo form_error('curr_system','<span class="error">','</span>');
echo '</div>';
//state
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('state')."</label>";
echo form_dropdown('state',$options,'','class="form-control input-sm" required="required" id="state" title="'.$this->lang->line('state').'"'); 
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