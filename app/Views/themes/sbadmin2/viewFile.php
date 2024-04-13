<?= $this->extend($layout) ?>
<?=$this->section('main') ?>
  
<div class="text-center">
  <object data="<?php echo $file_pdf;?>" type="application/pdf" width="100%" height="500px">
      <p>Unable to display PDF file. <a href="<?php echo $file_pdf;?>">Download</a> instead.</p>
    </object>
</div>

<?=$this->endSection() ?>
