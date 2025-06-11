<div class="container mt-5">
	<h2>Daftar Pembayaran Siswa</h2>
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

	<a href="<?= site_url('admin/export_excel_pembayaran') ?>" class="btn btn-success mb-3">Download Excel</a>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>NISN - Nama Siswa</th>
				<th>Kelas</th>
				<th>Ekskul</th>
				<th>Jumlah Bayar</th>
				<th>Tgl. Bayar</th>
				<th>Status</th>
				<th>Verifikator</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($pembayaran)): ?>
				<?php $no = 1;
				foreach ($pembayaran as $p): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $p->nisn; ?> - <?= $p->nama_siswa; ?></td>
						<td><?= $p->nama_kelas; ?></td>
						<td><?= $p->nama_ekskul; ?></td>
						<td>Rp<?= number_format($p->jumlah_bayar, 0, ',', '.'); ?></td>
						<td><?= date('d-m-Y H:i', strtotime($p->tanggal_bayar)); ?></td>
						<td>
							<?php
							$status_badge = '';
							switch ($p->status_pembayaran) {
								case 'pending':
									$status_badge = 'badge-warning';
									break;
								case 'terverifikasi':
									$status_badge = 'badge-success';
									break;
								case 'ditolak':
									$status_badge = 'badge-danger';
									break;
							}
							?>
							<span class="badge <?= $status_badge; ?>"><?= ucfirst($p->status_pembayaran); ?></span>
						</td>
						<td><?= $p->nama_admin_verifikasi ? $p->nama_admin_verifikasi . ' <br>(' . date('d-m-Y', strtotime($p->tanggal_verifikasi)) . ')' : '-'; ?></td>
						<td>
							<a href="<?= site_url('admin/verifikasi_pembayaran/' . $p->id_pembayaran) ?>" class="btn btn-info btn-sm">Detail & Verifikasi</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="9" class="text-center">Tidak ada data pembayaran.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>