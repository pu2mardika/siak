<?= $this->extend($layout) ?>
<?= $this->section('main') ;?>
WILLIH
<?= $this->endSection() ?>

<?php  if(isset($addONJs)){
	$this->section('pageScripts');
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script> 
	$(document).ready(function() {
		<?= $addONJs ?>
	});			
</script>
<?php
	$this->endSection();
}
?>

<script type="text/javascript">
    window.onload = function() {
        new Audio('Into the Wild - Red to Black.mp3').play();
    };
</script>