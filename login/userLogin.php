<?php
session_start();
include __DIR__ . '/../tools/connection.php';

if (isset($_SESSION["login_user"])) {
	header("location: ../home/home.php");
	exit();
}

if (isset($_POST['login_user'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = $conn->query("SELECT * FROM ta_user WHERE user_nama = '$username'");
	if (mysqli_num_rows($query) === 1) {
		$row = mysqli_fetch_assoc($query);
		if ($password === $row["user_password"]) {
			$_SESSION["login_user"] = true;
			header("location: ../home/home.php");
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
	<title>Login | SPK CV Ruarasa</title>
	<link rel="stylesheet" href="../tools/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../tools/css/style.css">
</head>

<body>
	<!-- Background berbeda: teal accent untuk user -->
	<div class="login-wrap" style="background: radial-gradient(ellipse at 40% 60%, rgba(46,196,182,0.08) 0%, transparent 60%), var(--navy);">
		<div class="login-card" style="border-color: rgba(46,196,182,0.25);">
			<div class="brand">
				<!-- Badge teal untuk user -->
				<div class="badge-logo" style="background: linear-gradient(135deg, #2ec4b6, #5de8dc);">
					<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="#0d1b2a">
						<path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
					</svg>
				</div>
				<h2>CV Ruarasa Lombok</h2>
				<p>Sistem Pendukung Keputusan · Metode SMART</p>
				<!-- Label role -->
				<div style="display:inline-block;margin-top:10px;padding:4px 14px;background:rgba(46,196,182,0.12);border:1px solid rgba(46,196,182,0.3);border-radius:20px;font-size:0.75rem;color:var(--teal);font-weight:600;letter-spacing:0.05em;">
					USER
				</div>
			</div>

			<?php if (isset($error)) : ?>
				<div class="login-error">⚠️ Username atau Password salah!</div>
			<?php endif; ?>

			<form method="post" action="">
				<div class="form-group">
					<label class="spk-label">Username</label>
					<input type="text" class="spk-input" name="username" autocomplete="off" autofocus required
						placeholder="Masukkan username"
						style="border-color:rgba(46,196,182,0.2);">
				</div>
				<div class="form-group">
					<label class="spk-label">Password</label>
					<input type="password" class="spk-input" name="password" required placeholder="••••••••"
						style="border-color:rgba(46,196,182,0.2);">
				</div>
				<div style="margin-top:24px;">
					<!-- Tombol teal untuk user -->
					<button type="submit" name="login_user" class="btn-spk-primary w-100"
						style="justify-content:center;padding:12px;background:linear-gradient(135deg,#2ec4b6,#5de8dc);box-shadow:0 2px 8px rgba(46,196,182,0.3);">
						Masuk sebagai User
					</button>
				</div>
			</form>

			<div style="text-align:center;margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.07);">
				<span style="color:var(--muted);font-size:0.82rem;">Punya akses admin? </span>
				<a href="adminLogin.php" style="color:var(--gold);font-size:0.82rem;text-decoration:none;font-weight:600;">
					Login sebagai Admin →
				</a>
			</div>
		</div>
	</div>
</body>

</html>