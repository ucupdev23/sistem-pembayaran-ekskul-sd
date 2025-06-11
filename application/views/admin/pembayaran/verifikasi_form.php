<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<div class="card mb-4">
		<div class="card-header">
			Detail Pembayaran
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<p><strong>NISN Siswa:</strong> <?= $pembayaran_data->nisn; ?></p>
					<p><strong>Nama Siswa:</strong> <?= $pembayaran_data->nama_siswa; ?></p>
					<p><strong>Kelas:</strong> <?= $pembayaran_data->nama_kelas; ?></p>
					<p><strong>Ekstrakurikuler:</strong> <?= $pembayaran_data->nama_ekskul; ?> (Biaya: Rp<?= number_format($pembayaran_data->biaya_ekskul, 0, ',', '.'); ?>)</p>
					<p><strong>Jumlah Dibayar:</strong> <span class="text-success font-weight-bold">Rp<?= number_format($pembayaran_data->jumlah_bayar, 0, ',', '.'); ?></span></p>
					<p><strong>Tanggal Pembayaran:</strong> <?= date('d-m-Y H:i', strtotime($pembayaran_data->tanggal_bayar)); ?></p>
					<p><strong>Note Siswa:</strong> <?= $pembayaran_data->note_siswa ? $pembayaran_data->note_siswa : '-'; ?></p>
					<p><strong>Status Saat Ini:</strong>
						<?php
						$status_badge = '';
						switch ($pembayaran_data->status_pembayaran) {
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
						<span class="badge <?= $status_badge; ?>"><?= ucfirst($pembayaran_data->status_pembayaran); ?></span>
					</p>
					<?php if ($pembayaran_data->id_admin_verifikasi): ?>
						<p><strong>Diverifikasi Oleh:</strong> <?= $pembayaran_data->nama_admin_verifikasi; ?> pada <?= date('d-m-Y H:i', strtotime($pembayaran_data->tanggal_verifikasi)); ?></p>
						<p><strong>Catatan Admin Sebelumnya:</strong> <?= $pembayaran_data->catatan_admin ? $pembayaran_data->catatan_admin : '-'; ?></p>
					<?php endif; ?>
				</div>
				<div class="col-md-6 text-center">
					<h5>Bukti Pembayaran</h5>
					<?php if ($pembayaran_data->bukti_pembayaran): ?>
						<img src="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran_data->bukti_pembayaran); ?>" class="img-fluid" alt="Bukti Pembayaran" style="max-height: 400px; object-fit: contain;">
					<?php else: ?>
						<p class="text-danger">Tidak ada bukti pembayaran diunggah.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			Form Verifikasi
		</div>
		<div class="card-body">
			<form action="<?= site_url('admin/verifikasi_pembayaran/' . $pembayaran_data->id_pembayaran) ?>" method="post">
				<div class="form-group">
					<label for="status_pembayaran">Ubah Status Pembayaran</label>
					<select class="form-control" id="status_pembayaran" name="status_pembayaran" required>
						<option value="pending" <?= set_select('status_pembayaran', 'pending', ($pembayaran_data->status_pembayaran == 'pending')); ?>>Pending</option>
						<option value="terverifikasi" <?= set_select('status_pembayaran', 'terverifikasi', ($pembayaran_data->status_pembayaran == 'terverifikasi')); ?>>Terverifikasi</option>
						<option value="ditolak" <?= set_select('status_pembayaran', 'ditolak', ($pembayaran_data->status_pembayaran == 'ditolak')); ?>>Ditolak</option>
					</select>
					<?= form_error('status_pembayaran', '<small class="text-danger">', '</small>'); ?>
				</div>
				<div class="form-group">
					<label for="catatan_admin">Catatan Admin (Opsional)</label>
					<textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3"><?= set_value('catatan_admin', $pembayaran_data->catatan_admin); ?></textarea>
					<?= form_error('catatan_admin', '<small class="text-danger">', '</small>'); ?>
				</div>
				<button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
				<a href="<?= site_url('admin/pembayaran') ?>" class="btn btn-secondary">Kembali ke Daftar Pembayaran</a>
			</form>
		</div>
	</div>
</div>