<!-- Modal -->
<?php
foreach ($fields as $k => $v) {
	if(key_exists($k, $rsdata))
	{
		$val[$k] = $rsdata[$k];
	}else{
		$val[$k] = '';
	}
}

$subtitle =(isset($title))?$title:"FORM";

$Hidden = [];

if(isset($hidden)){$Hidden = $hidden ;}
?>
<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $subtitle ;?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open(current_url(),'class="contentform was-validated"',$Hidden); ?>
      <div class="modal-body">
        <?= csrf_field() ?>
        <?php
		foreach($fields as $fd => $row){
			//CEK KONDISI FIELDS
			$extra = $row['extra'];
			$extra['class'] = 'form-control';
		//	$extra['placeholder'] = $row['label'];
			$forID = $extra['id'];
			
			//chek nilai NULL atau tidak
			$nilai = (is_null($val[$fd]))?"":$val[$fd];
			
			$input = $inputype[$row['type']];
			
			if($input == 'form_dropdown'){
				$option = $opsi[$fd];
				//echo $input($fd,$option,set_select($fd,$val[$fd]),$extra);
				$formInput = form_dropdown($fd,$option,$nilai,$extra);
			}elseif($input == 'form_hidden'){
				$data = [
					'type'  => 'hidden',
					'name'  => $fd,
					'id'    => $fd,
					'value' => set_value($fd,$nilai),
					'class' => $extra['class'],
				];
				$row['label']="";
				$formInput = form_input($data);
				//echo $input($fd,set_value($fd,$val[$fd]),$extra,$row['type']);
			}else{
			//	echo set_value($fd,$val[$fd]);
				$formInput = $input($fd,set_value($fd,$nilai),$extra,$row['type']);
			}
		?>
			<div class="form-floating">
				<label for="<?php echo $forID;?>"><?php echo $row['label'];?></label>
				<?=$formInput?>	    
			</div>
			
		<?php } ?>
			<div id="addOnInput" class="form-floating"></div>
			<div id="dtviews"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup/Batal</button>
        <button type="button" id="btn_ok" class="btn btn-primary">Simpan</button>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

<?php  
//	$this->section('pageScripts');
$addONJs=(isset($addONJs))?$addONJs:"";
?>
<script> 
	$(document).ready(function ($) {
        var options = {
                beforeSend: function(){
                    // Replace this with your loading gif image
                    $(".frmmsg").html('<p><img src = "<?php echo base_url() ?>assets/styles/images/ajax.gif" class = "loader" /></p>');
                  
                },
                complete: function(response){
                    // Output AJAX response to the div container
                    $("<?= $rtarget ;?>").html(response.responseText);
    				setTimeout(function () {
	                    location.reload();
	                    self.$("#confirm-cancel").trigger("click");
               		}, 900);              
                }
            };  
            $("#btn_ok").click(function(){
            	//$(".contentform").submit();
            	$('#myModal').modal('hide').on('hidden.bs.modal', function (event) {
				    $(".contentform").submit();
				  //  location.reload();
				});
            }) 
            $("#btn_btl").click(function(){
            	location.reload();
            })
            // Submit the form
            $(".contentform").ajaxForm(options);  
	        $('#myModal').modal('show');
		/*	$("#npwp").mask("99-999-999-9-999-999");
			$('.inputtgl').datetimepicker({
			    locale: 'en',
			    format: 'DD-MM-YYYY'
			});		
		*/
		<?= $addONJs ?>
		return false;
    });			
</script>
<?php
//	$this->endSection();
?>