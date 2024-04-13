<?php 
	$row=$prodi->row_array(); 
	$keys=$this->config->item('dynamic_key');
	//$ids=$this->kriptograf->paramEncrypt($row['id_prodi'],$keys);
?>

<?php echo form_open($this->uri->uri_string(), array('class' => 'contentform form-horizontal', 'id'=>'form_prodi'));
//`id_prodi`, `nm_prodi`, `desc`, `id_jur`, `jenjang`, `state`

//nm_jurusan
echo '<div class="form-group input">';
echo "<label for='name'>". $this->lang->line('prodi_name')."</label>";
echo '<input id="name" type="text" class="form-control" required="required" name="nm_prodi" placeholder="'. 
	 $this->lang->line('prodi_name').'" title = "'.$this->lang->line('prodi_name').'" value = "'.$row['nm_prodi'].'"/>';
echo form_error('nm_prodi','<br><label></label><span class="alert-warning">','</span>'); 
echo '</div>';
//desc 
echo '<div class="form-group input">';
echo "<label for='desc'>". $this->lang->line('prodi_desc')."</label>";
echo '<textarea id="desc" name="desc" rows="4" class="form-control" required="required">'.$row['desc'].'</textarea>';
echo form_error('desc','<span class="alert-warning">','</span>'); 
echo '</div>';
//jurusan
echo '<div class="form-group input">';
echo "<label for='id_jur'>". $this->lang->line('jur_name')."</label>";
echo form_dropdown('id_jur',$jurdd,$row['id_jur'], 'class="form-control input-sm" required="required" id="id_jur" title="'.$this->lang->line('jur_name').'"'); 
echo form_error('id_jur','<span class="alert-warning">','</span>'); 
echo '</div>';
//grade
echo '<div class="form-group input">';
echo "<label for='jenjang'>". $this->lang->line('prodi_grade')."</label>";
echo form_dropdown('jenjang',$egrid,$row['jenjang'], 'class="form-control input-sm" required="required" id="jenjang" title="'.$this->lang->line('prodi_grade').'"'); 
echo form_error('jenjang','<span class="alert-warning">','</span>'); 
echo '</div>';
//state
echo '<div class="form-group input">';
echo "<label for='state'>". $this->lang->line('state')."</label>";
$options=$this->lang->line('norm_state_arr');
echo form_dropdown('state',$options,$row['state'], 'class="form-control input-sm" required="required" id="state" title="'.$this->lang->line('state').'"'); 
echo form_error('state','<span class="alert-warning">','</span>'); 
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
        $("#name").focus();
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