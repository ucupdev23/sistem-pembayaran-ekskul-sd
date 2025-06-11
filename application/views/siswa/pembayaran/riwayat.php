<div class="container mt-5">
	<h2>Riwayat Pembayaran Saya</h2>
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

	<?php if (!empty($riwayat_pembayaran)): ?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Ekstrakurikuler</th>
					<th>Jumlah Bayar</th>
					<th>Tgl. Bayar</th>
					<th>Status</th>
					<th>Catatan Admin</th>
					<th>Bukti</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($riwayat_pembayaran as $p): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $p->nama_ekskul; ?> (Biaya: Rp<?= number_format($p->biaya_ekskul, 0, ',', '.'); ?>)</td>
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
							<?php if ($p->status_pembayaran != 'pending' && $p->nama_admin_verifikasi): ?>
								<br><small class="text-muted">(Oleh: <?= $p->nama_admin_verifikasi; ?> pada <?= date('d-m-Y', strtotime($p->tanggal_verifikasi)); ?>)</small>
							<?php endif; ?>
						</td>
						<td><?= $p->catatan_admin ? $p->catatan_admin : '-'; ?></td>
						<td>
							<?php if ($p->bukti_pembayaran): ?>
								<a href="<?= base_url('uploads/bukti_pembayaran/' . $p->bukti_pembayaran); ?>" target="_blank" class="btn btn-info btn-sm">Lihat Bukti</a>
							<?php else: ?>
								-
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="alert alert-info">
			Anda belum memiliki riwayat pembayaran.
		</div>
	<?php endif; ?>
	<a href="<?= site_url('siswa/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>