<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>

  <div>
  <?= view_cell('Modules\Register\Libraries\Widget::buktidaftar', $rsdata) ?>
  </div>

<div class="text-center">
  <?php echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs'],
				'url' => $ur_l,
				'icon' => 'fa fa-print',
				'label' => 'Cetak'
			]);
    ?>
</div

<?= $this->endSection() ?>