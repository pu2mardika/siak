<?php namespace App\Controllers;
class Home extends BaseController
{
	public function index()
	{
		$Room = model(\Modules\Room\Models\RombelModel::class); 
		$PTK = model(\Modules\Tendik\Models\TendikModel::class); 
		$DataDik = model(\Modules\Siswa\Models\DatadikModel::class); 
		$PD = model(\Modules\Siswa\Models\SiswaModel::class); 
		$jmRombel = count($Room->asArray()->findAll());
		$jmPTK = count($PTK->asArray()->findAll());
		$jmDataDik = count($DataDik->asArray()->findAll());
		$jmPD = count($PD->asArray()->findAll());
		$data = $this->data;
		$data['Resume'] = [
			'room' => ['title'=>"Data Rombel", 'icon'=>'book-reader', 'rdata'=>$jmRombel, 'class'=>'primary'],
			'ptk' => ['title'=>"Data PTK", 'icon'=>'user-tie', 'rdata'=>$jmPTK, 'class'=>'success'],
			'datadik' => ['title'=>"Data Peserta Didik", 'icon'=>'users-cog', 'rdata'=>$jmDataDik, 'class'=>'info'],
			'pd' => ['title'=>"Peserta Didik Aktif", 'icon'=>'user-friends', 'rdata'=>$jmPD, 'class'=>'warning'],
		];
		echo $this->_render('dashboard',$data);
	}

	//--------------------------------------------------------------------
}
