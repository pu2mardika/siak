<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassArch extends Seeder
{
	public function run()
	{
		$Data =[
			['id_class'  => 005, 'deskripsi' =>Undangan'],
			['id_class'  => 027, 'deskripsi' =>Pengadaan Barang  dan Jasa'],
			['id_class'  => 090, 'deskripsi' =>SPT dan SPPD'],
			['id_class'  => 900, 'deskripsi' =>Keuangan Umum'],
			['id_class'  => 934, 'deskripsi' =>Surat Pernyataan Keuangan'],
			['id_class'  => 800, 'deskripsi' =>Kepegawaian'],
			['id_class'  => 044.2, 'deskripsi' =>Surat Pengantar'],
			['id_class'  => 422.5, 'deskripsi' =>Beasiswa'],
			['id_class'  => 421.3, 'deskripsi' =>Sekolah menengah atas'],
			['id_class'  => 944, 'deskripsi' =>Laporan Fisik dan Keuangan'],
			['id_class'  => 901, 'deskripsi' =>Nota Keuangan'],
			['id_class'  => 943, 'deskripsi' =>Laporan fisik pembangunan'],
			['id_class'  => 822.3, 'deskripsi' =>Berkala Golongan 3'],
			['id_class'  => 826.1, 'deskripsi' =>Ijin Belajar Dalam Negeri'],
			['id_class'  => 893.5, 'deskripsi' =>Pendidikan dan Pelatihan Lainnya'],
			['id_class'  => 454.1, 'deskripsi' =>Peribadatan Agama Hindu'],
			['id_class'  => 421.6, 'deskripsi' =>Kegiatan sekolah'],
			['id_class'  => 421.5, 'deskripsi' =>Kegiatan Pelajar'],
			['id_class'  => 466.1, 'deskripsi' =>Sumbangan Sosial Korban Bencana'],
			['id_class'  => 935, 'deskripsi' =>Keuangan - SP Pengajuan SPP-LS'],
			['id_class'  => 426.21, 'deskripsi' =>Keolahragaan Gedung Olah Raga'],
			['id_class'  => 978, 'deskripsi' =>Bantuan Presiden, Menteri dan bantuan lainnya'],
			['id_class'  => 421.7, 'deskripsi' =>Kegiatan Pelajar'],
			['id_class'  => 824.5, 'deskripsi' =>Pemindahan/Pelimpahan/Perbantuan. Lolos Butuh'],
			['id_class'  => 882.4, 'deskripsi' =>Pensiun Gol 4'],
			['id_class'  => 822.2, 'deskripsi' =>BERKALA'],
			['id_class'  => 850, 'deskripsi' =>Surat Izin'],
			['id_class'  => 861.1, 'deskripsi' =>SATYA LENCANA'],
			['id_class'  => 863, 'deskripsi' =>Konduite,DP3,Disiplin Pegawai'],
			['id_class'  => 028, 'deskripsi' =>Sarana Prasarana'],
			['id_class'  => 856, 'deskripsi' =>Cuti diluar tanggungan negara'],
			['id_class'  => 882.3, 'deskripsi' =>Pensiun Golongan III'],
			['id_class'  => 841.6, 'deskripsi' =>Tunjangan Keluargfa'],
			['id_class'  => 822.4, 'deskripsi' =>BERKALA GOLONGAN IV'],
			['id_class'  => 821, 'deskripsi' =>PLH dan PLT'],
			['id_class'  => 814.1, 'deskripsi' =>Pengangkatan Tenaga Bulanan / Tenaga Kontrak'],
			['id_class'  => 881, 'deskripsi' =>Pemberhentian Pegawai Permintaan Sendiri'],
			['id_class'  => 428, 'deskripsi' =>Kepramukaan'],
			['id_class'  => 873, 'deskripsi' =>Registrasi'],
			['id_class'  => 581, 'deskripsi' =>Permohonan Rekening Koran'],
			['id_class'  => 852, 'deskripsi' =>Cuti Besar'],
			['id_class'  => 823.3, 'deskripsi' =>Kenaikan Pangkat/Pengangkatan Pegawai Golongan III'],
			['id_class'  => 422.4, 'deskripsi' =>Adm Sekolah - Uang Sekolah'],
			['id_class'  => 424, 'deskripsi' =>Tenaga Pengajar, Guru'],
			['id_class'  => 821.2, 'deskripsi' =>Pengangkatan Dalam Jabatan, Pembebasan Dari Jabatan,Berita Acara Serah Terima Jabatan'],
			['id_class'  => 823.4, 'deskripsi' =>Kenaikan Pangkat Golongan IV'],
			['id_class'  => 040, 'deskripsi' =>Surat Pernyataan Kepala Perpustakaan'],
			['id_class'  => 468, 'deskripsi' =>PMI'],
			['id_class'  => 890, 'deskripsi' =>Rekomendasi izin belajar'],
			['id_class'  => 420, 'deskripsi' =>Pendidikan'],
			['id_class'  => 981, 'deskripsi' =>MOU'],
			['id_class'  => 593, 'deskripsi' =>Pengurusan Hak-Hak Tanah'],			
		];
		
		foreach($Data as $data){
			// insert semua data ke tabel
			$this->db->table('tbl_class_arch')->insert($data);
		}
	}
}
