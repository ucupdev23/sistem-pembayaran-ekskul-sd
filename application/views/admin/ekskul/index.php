<div class="container mt-5">
	<h2>Daftar Data Ekstrakurikuler</h2>
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

	<div class="row mb-3">
		<div class="col-md-6">
			<a href="<?= site_url('admin/tambah_ekskul') ?>" class="btn btn-primary">Tambah Ekskul Baru</a>
		</div>
		<div class="col-md-6 text-right">
			<a href="<?= site_url('admin/export_excel_ekskul') ?>" class="btn btn-success">Download Excel</a>
		</div>
	</div>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Ekskul</th>
				<th>Deskripsi</th>
				<th>Biaya</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($ekskul)): ?>
				<?php $no = 1;
				foreach ($ekskul as $e): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $e->nama_ekskul; ?></td>
						<td><?= $e->deskripsi ? $e->deskripsi : '-'; ?></td>
						<td>Rp<?= number_format($e->biaya, 0, ',', '.'); ?></td>
						<td>
							<a href="<?= site_url('admin/edit_ekskul/' . $e->id_ekskul) ?>" class="btn btn-warning btn-sm">Edit</a>
							<a href="<?= site_url('admin/hapus_ekskul/' . $e->id_ekskul) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus ekskul ini?');">Hapus</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5" class="text-center">Tidak ada data ekstrakurikuler.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>