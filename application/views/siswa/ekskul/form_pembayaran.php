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
			Informasi Ekskul yang Akan Dibayar
		</div>
		<div class="card-body">
			<p><strong>Nama Ekskul:</strong> <?= $pendaftaran_ekskul->nama_ekskul; ?></p>
			<p><strong>Biaya Ekskul:</strong> Rp<?= number_format($pendaftaran_ekskul->biaya, 0, ',', '.'); ?></p>
			<p><strong>Tanggal Daftar:</strong> <?= date('d-m-Y', strtotime($pendaftaran_ekskul->tanggal_daftar)); ?></p>
		</div>
	</div>

	<?= form_open_multipart('siswa/bayar_ekskul/' . $pendaftaran_ekskul->id_siswa_ekskul); ?>
	<div class="form-group">
		<label for="jumlah_bayar">Jumlah Pembayaran (Rp)</label>
		<input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" step="0.01" value="<?= set_value('jumlah_bayar', $pendaftaran_ekskul->biaya); ?>" required>
		<?= form_error('jumlah_bayar', '<small class="text-danger">', '</small>'); ?>
	</div>
	<div class="form-group">
		<label for="bukti_pembayaran">Upload Bukti Pembayaran (JPG, PNG, GIF, JPEG - Max 2MB)</label>
		<input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" required>
		<small class="form-text text-muted">Pastikan gambar jelas dan tidak blur.</small>
	</div>
	<div class="form-group">
		<label for="note_siswa">Catatan Pembayaran (Opsional)</label>
		<textarea class="form-control" id="note_siswa" name="note_siswa" rows="3"><?= set_value('note_siswa'); ?></textarea>
		<?= form_error('note_siswa', '<small class="text-danger">', '</small>'); ?>
	</div>
	<button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
	<a href="<?= site_url('siswa/ekskul') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>