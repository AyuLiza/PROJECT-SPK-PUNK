<?php

session_start();

include __DIR__ . '/../tools/connection.php';

if (isset($_SESSION["login_admin"])) {
	header("location: ../admin/admin.php");
	exit();
}

if (isset($_POST['login_admin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = $conn->query("SELECT * FROM ta_admin WHERE admin_nama = '$username'");

	//cek username
	if (mysqli_num_rows($query) === 1) {

		//cek password
		$row = mysqli_fetch_assoc($query);
		if ($password === $row["admin_password"]) {

			// set session
			$_SESSION["login_admin"] = true;

			header("location: ../admin/admin.php");
			exit();
		}
	}
	$error = true;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Admin | SPK CV Ruarasa</title>
	<link rel="stylesheet" href="../tools/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../tools/css/style.css">
</head>

<body>
	<div class="login-wrap">
		<div class="login-card" style="border-color: rgba(212,168,75,0.35);">
			<div class="brand">
				<!-- Badge dengan icon kunci/shield untuk admin -->
				<div class="badge-logo" style="background: linear-gradient(135deg, #d4a84b, #f0c96a); position:relative;">
					<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="#0d1b2a">
						<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
					</svg>
				</div>
				<h2>Panel Admin</h2>
				<p>CV Ruarasa Lombok · Metode SMART</p>
				<!-- Label role -->
				<div style="display:inline-block;margin-top:10px;padding:4px 14px;background:rgba(212,168,75,0.12);border:1px solid rgba(212,168,75,0.3);border-radius:20px;font-size:0.75rem;color:var(--gold);font-weight:600;letter-spacing:0.05em;">
					ADMINISTRATOR
				</div>
			</div>

			<?php if (isset($error)) : ?>
				<div class="login-error">⚠️ Username atau Password salah!</div>
			<?php endif; ?>

			<form method="post" action="">
				<div class="form-group">
					<label class="spk-label">Username Admin</label>
					<input type="text" class="spk-input" name="username" autocomplete="off" autofocus required placeholder="Masukkan username admin">
				</div>
				<div class="form-group">
					<label class="spk-label">Password</label>
					<input type="password" class="spk-input" name="password" required placeholder="••••••••">
				</div>
				<div style="margin-top:24px;">
					<button type="submit" name="login_admin" class="btn-spk-primary w-100" style="justify-content:center;padding:12px;">
						Masuk sebagai Admin
					</button>
				</div>
			</form>

			<div style="text-align:center;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.07);">
				<span style="color:var(--muted);font-size:0.82rem;">Bukan admin? </span>
				<a href="userLogin.php" style="color:var(--teal);font-size:0.82rem;text-decoration:none;font-weight:600;">
					Login sebagai User →
				</a>
			</div>
		</div>
	</div>
</body>

</html>