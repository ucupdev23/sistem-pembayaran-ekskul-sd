<div class="container mt-5">
	<h2>Daftar Ekstrakurikuler Saya</h2>
	<hr>
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success" role="alert">
			<?= $this->session->flashdata('success'); ?>
		</div>
	<?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($ekskul_terdaftar_siswa)): ?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Ekstrakurikuler</th>
					<th>Biaya</th>
					<th>Tanggal Daftar</th>
					<th>Status Keanggotaan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($ekskul_terdaftar_siswa as $se): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $se->nama_ekskul; ?></td>
						<td>Rp<?= number_format($se->biaya, 0, ',', '.'); ?></td>
						<td><?= date('d-m-Y', strtotime($se->tanggal_daftar)); ?></td>
						<td>
							<?php if ($se->status_keanggotaan == 'aktif'): ?>
								<span class="badge badge-success">Aktif</span>
							<?php else: ?>
								<span class="badge badge-secondary">Non-Aktif</span>
							<?php endif; ?>
						</td>
						<td>
							<?php // Logika sederhana: Tombol bayar muncul jika status aktif 
							?>
							<?php if ($se->status_keanggotaan == 'aktif'): ?>
								<a href="<?= site_url('siswa/bayar_ekskul/' . $se->id_siswa_ekskul) ?>" class="btn btn-primary btn-sm">Bayar Sekarang</a>
							<?php else: ?>
								<button class="btn btn-secondary btn-sm" disabled>Non-Aktif</button>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="alert alert-info">
			Anda belum terdaftar di ekstrakurikuler manapun. Silakan hubungi admin sekolah untuk pendaftaran.
		</div>
	<?php endif; ?>
	<a href="<?= site_url('siswa/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>