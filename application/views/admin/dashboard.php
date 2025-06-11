<div class="container mt-5">
	<h2>Selamat Datang, <?= $user['nama']; ?>!</h2>
	<p>Anda login sebagai <?= ($user['role'] == 'super_admin') ? 'Super Admin' : 'Admin'; ?>.</p>

	<div class="row mt-4">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Navigasi Cepat</h5>
					<ul class="list-group">
						<?php if ($user['role'] == 'super_admin'): ?>
							<li class="list-group-item"><a href="<?= site_url('admin/kelola_admin') ?>">Kelola Admin</a></li>
						<?php endif; ?>
						<li class="list-group-item"><a href="<?= site_url('admin/kelas') ?>">Kelola Kelas</a></li>
						<li class="list-group-item"><a href="<?= site_url('admin/siswa') ?>">Kelola Siswa</a></li>
						<li class="list-group-item"><a href="<?= site_url('admin/ekskul') ?>">Kelola Ekskul</a></li>
						<li class="list-group-item"><a href="<?= site_url('admin/siswa_ekskul') ?>">Daftar Siswa Ekskul</a></li>
						<li class="list-group-item"><a href="<?= site_url('admin/pembayaran') ?>">Verifikasi Pembayaran</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Informasi Ringkas</h5>
					<p>Total Siswa: <?= $total_siswa; ?></p>
					<p>Total Ekskul: <?= $total_ekskul; ?></p>
					<p>Pembayaran Pending: <span class="badge badge-warning"><?= $total_pembayaran_pending; ?></span></p>
					<p>Pembayaran Terverifikasi: <span class="badge badge-success"><?= $total_pembayaran_terverifikasi; ?></span></p>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-4">
		<a href="<?= site_url('admin/logout') ?>" class="btn btn-danger">Logout</a>
	</div>
</div>