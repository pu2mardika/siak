<?= $this->extend($layout) ?>
<?=$this->section('main') ?>
  
<div class="text-center bg-dark">
  <object data="<?php echo $file_pdf;?>" type="application/pdf" width="100%" height="600px">
      <p>Unable to display PDF file. <a href="<?php echo $file_pdf;?>">Download</a> instead.</p>
    </object>
</div>

<?php 
if(isset($addOnAct)){
  echo '<p class="text-center"><br>';
  echo '<span>';
  foreach($addOnAct as $aksi)
  {
    echo btn_label([
      'attr' => ['class' => 'btn '.$aksi['btn_type'].' btn-xs'],
      'url' => base_url().$aksi['src'].$ids,
      'icon' => $aksi['icon'],
      'label' => $aksi['label']
    ]);
  }
  echo '</span></p>';
} 
?>
<?=$this->endSection() ?>
