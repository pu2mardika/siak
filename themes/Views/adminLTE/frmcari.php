<?= $this->extend($layout) ?>
  <?= $this->section('main') ;
if(isset($subtitle)){echo $subtitle;}

$Hidden = [];
$urldata = ($urlFdata)?$urlFdata:"";
$urldata = base_url($urldata);

if(isset($hidden)){$Hidden = $hidden ;}
	
echo form_open(current_url(),'',$Hidden);
?>
	<div class="row justify-content-md-center">
	    <div class="col-md-auto text-info">
	      <?php echo (isset($instruction))?$instruction:"";?>
	    </div>
	</div>
	
	<div class="row">
	    <div class="col-9">
	    <?php
	    foreach($fields as $fd => $row){
	    ?>
	     <div class=""></div>
		  <input type="text" id="idfinder"name="<?php echo $fd;?>" class="form-control autocomplete" placeholder="<?php echo $row['label'];?>" aria-label="<?php echo $row['label'];?>">
		  
		<?php }?>
	    </div>
	    <div class="col-3">
		    <button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Lanjut</button>
		</div>
   </div>
<?php echo form_close();?>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url('js/jquery.easy-autocomplete.min.js');?>"></script>

<?php if($session->getFlashdata('warning')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('warning'); ?>","warning")
	</script>
<?php } ?>
<?php if($session->getFlashdata('sukses')) { ?>
	<script>
	  swal("Berhasil", "<?php echo $session->getFlashdata('sukses'); ?>","success")
	</script>
<?php } ?>
<?php if($session->getFlashdata('errors')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('errors'); ?>","warning")
	</script>
<?php } ?>
<script>
	var uri = '<?php echo $urldata;?>';
	var options = {
		url: function(phrase) {
		//	var tp = $("#dtp").attr("data-value-type");
			return uri + '/' + phrase;
		},
		//getValue: 'idx',
		getValue: function(element) {
	         var my_value = element.dataID + ' | ' + element.deskripsi;
	         return my_value;
	    },
		
		cssClasses: "input-group mb-3",
		
		list: {
			onSelectItemEvent: function() {
		      //  var finding = $("#idfinder").getSelectedItemData().dataID; //get the id associated with the selected value
		     //   $("#dtIDx").val(finding).trigger("change");
		      //  $("#regId").val(mid).trigger("change");
		      }
		}
	};

	$('#idfinder').easyAutocomplete(options);

</script>
<?php
if(isset($addONJs)){	
?>
<script> 
	$(document).ready(function() {
		<?= $addONJs ?>
	});			
</script>

<?php
}
$this->endSection();
?>