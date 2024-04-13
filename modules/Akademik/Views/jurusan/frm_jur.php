<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));
//`id_jur` ,  `nm_jurusan` ,  `desc` ,  `state`
if(isset($jurusan)){
	$dt=$jurusan->row_array();
}else{
	$dt=array('nm_jurusan'=>'', 'desc'=>'', 'state'=>'');
}
//nm_jurusan
echo '<div class="form-group input">';
echo "<label for='name'>". $this->lang->line('jur_name')."</label>";
echo '<input id="name" type="text" class="form-control" required="required" name="nm_jurusan" 
value="'.$dt['nm_jurusan'].'" placeholder="'.$this->lang->line('jur_name').'" 
title = "'.$this->lang->line('jur_name').'"/>';
echo form_error('nm_jurusan','<br><label></label><span class="error">','</span>')."</div>"; 

//desc 
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('jur_desc')."</label>";
//echo '<input id="desc" type="text" required="required" name="desc" placeholder="'. 
$this->lang->line('jur_desc').'" title = "'.$this->lang->line('jur_desc').'"/>'; 
echo '<textarea id="desc" name="desc" rows="10" class="form-control editor" required="required">'.$dt['desc'].'</textarea>';
echo form_error('desc','<span class="error">','</span>')."</div>";

//state
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('state')."</label>";
echo form_dropdown('state',$options,$dt['state'],'class="form-control input-sm" required="required" id="jenjang" title="'.$this->lang->line('state').'"'); 
echo form_error('state','<span class="error">','</span>')."</div>";

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
    });
</script>