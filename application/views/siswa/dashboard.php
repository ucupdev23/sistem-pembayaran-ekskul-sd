<div class="container mt-5">
	<h2>Selamat Datang, <?= $siswa['nama_siswa']; ?>!</h2>
	<p>NISN Anda: <?= $siswa['nisn']; ?></p>

	<div class="row mt-4">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Menu Siswa</h5>
					<ul class="list-group">
						<li class="list-group-item"><a href="<?= site_url('siswa/ekskul') ?>">Daftar Ekskul & Pembayaran</a></li>
						<li class="list-group-item"><a href="<?= site_url('siswa/riwayat_pembayaran') ?>">Riwayat Pembayaran Saya</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Status Terbaru</h5>
					<p>Total Pembayaran Pending: <span class="badge badge-warning"><?= $total_pending; ?></span></p>
					<p>Total Pembayaran Terverifikasi: <span class="badge badge-success"><?= $total_terverifikasi; ?></span></p>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-4">
		<a href="<?= site_url('siswa/logout') ?>" class="btn btn-danger">Logout</a>
	</div>
</div>