<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal'));

//`id_skl`, `curr_id`, `id_prodi`, `skl`, 'state'

//id_prodi
echo '<div class="form-group input">';
echo "<label for='prodi'>". $this->lang->line('prodi')."</label>";
echo form_dropdown('id_prodi',$cmb_prodi,'','class="form-control input-sm" required="required" id="prodi" title="'.$this->lang->line('prodi').'"'); 
echo form_error('id_prodi','<span class="error">','</span>');
echo '</div>';
//skl
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('curr_skl')."</label>";
echo '<textarea id="skl" name="skl" rows="10" class="form-control editor" required="required"></textarea>';
echo form_error('skl','<span class="error">','</span>');
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

//curr_id
echo form_hidden('curr_id',$ids);
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
    });
</script>