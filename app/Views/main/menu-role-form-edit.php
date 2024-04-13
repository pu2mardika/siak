<?= $this->extend($layout) ?>
<?= $this->section('main') ?>
<?php
$checkbox[] = ['id' => 'check-all', 'name' => 'check_all', 'label' =>'Check All / Uncheck All'];
$check_all_checked = $checked ? ['check_all'] : [];
echo checkbox($checkbox, $check_all_checked);

echo '<hr class="mt-1 mb-2"/>';
?>
<form method="post" id="check-all-wrapper" action="">
<?php
	$checkbox = [];
	foreach ($role as $val) {
		$checkbox[] = ['id' => $val['id_role'], 'name' => $prefix_id . $val['id_role'], 'label' => $val['judul_role']];
	}

	echo checkbox($checkbox, $checked);
	
?>
<p class="mt-0 mb-0" style="line-height:20px">Parent akan ikut ter assign. Misal <strong>Website &raquo; Role &raquo; User Role</strong>, jika menu <strong>User Role</strong> di assign ke role admin, maka Menu <strong>Role</strong> dan <strong>Website</strong> jika belum ter assign akan ikut ter assign</p>
</form>

<?= $this->endSection() ?>