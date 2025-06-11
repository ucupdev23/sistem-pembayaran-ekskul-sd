<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Pembayaran Ekskul SD</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			background-color: #f8f9fa;
		}

		.login-container {
			max-width: 400px;
			margin: 100px auto;
			padding: 30px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			background-color: #fff;
		}

		.login-container h2 {
			text-align: center;
			margin-bottom: 30px;
			color: #343a40;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="login-container">
			<h2>Login Sistem Pembayaran Ekskul</h2>
			<?php if ($this->session->flashdata('error')): ?>
				<div class="alert alert-danger" role="alert">
					<?= $this->session->flashdata('error'); ?>
				</div>
			<?php endif; ?>

			<form action="<?= site_url('auth/process_login') ?>" method="post">
				<div class="form-group">
					<label for="username">Username / NISN </label>
					<input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" required>
					<?= form_error('username', '<small class="text-danger">', '</small>'); ?>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" required>
					<?= form_error('password', '<small class="text-danger">', '</small>'); ?>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Login</button>
			</form>
		</div>
	</div>
</body>

</html>
