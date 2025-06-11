<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title; ?> - Pembayaran Ekskul SD</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			padding-top: 56px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<a class="navbar-brand" href="#">Pembayaran Ekskul SD</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<?php if ($this->session->userdata('logged_in')): ?>
						<?php if ($this->session->userdata('role') == 'super_admin' || $this->session->userdata('role') == 'admin'): ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('admin/dashboard') ?>">Dashboard Admin</a>
							</li>
							<?php if ($this->session->userdata('role') == 'super_admin'): ?>
								<li class="nav-item">
									<a class="nav-link" href="<?= site_url('admin/kelola_admin') ?>">Kelola Admin</a>
								</li>
							<?php endif; ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('admin/logout') ?>">Logout</a>
							</li>
						<?php elseif ($this->session->userdata('role') == 'siswa'): ?>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('siswa/dashboard') ?>">Dashboard Siswa</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('siswa/logout') ?>">Logout</a>
							</li>
						<?php endif; ?>
					<?php else: ?>
						<li class="nav-item">
							<a class="nav-link" href="<?= site_url('auth') ?>">Login</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
