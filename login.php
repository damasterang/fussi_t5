<!DOCTYPE html>
<html>
	<head>
		<title>login</title>
		<link rel="icon" type="image/png" href="img/logoBlackUns.png" />
		<link rel="stylesheet" type="text/css" href="css/newStyle.css">
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/myJs.js"></script>
	</head>
	<body>
		<div id="header">
			<div class="logo">
				<img src="img/logoUns.png" alt="Logo UNS"/>
				<div>Perpustakaan Universitas Sebelas Maret</div>
			</div>
			<div class="rightHeader buttonMenu orange">
				<a href="index.php"><img src="img/logoHome.png" alt="Home"/>
					<div>home</div></a>
			</div>
		</div>
		<div id="main">
			<div id="wrapper2">
				<h1>Login</h1>
				<form action="process.php?a=login" method="POST">
					<table border="collapse">
						<tr>
							<td><div class="label">Username</div></td>
							<td>:</td>
							<td><input type="text" name="username" placeholder="input id anggota"/></td>
						</tr>
						<tr>
							<td><div class="label">Password</div></td>
							<td>:</td>
							<td><input type="password" name="password" placeholder='input password'/></td>
						</tr>
					</table>
					<div class="wrapperErrorLogin">
						<?php 

							if (isset($_GET['errorMsg'])) {
								echo "<div class='errorLogin'>";
								if ($_GET['errorMsg'] == 1) {
									echo "<div>username dan password tidak cocok</div>";
								} elseif($_GET['errorMsg'] == 2){
									echo "<div>isi form terlebih dulu</div>";
								} elseif($_GET['errorMsg'] == 3){
									echo "<div>anda harus login terlebih dulu</div>";
								}
								echo "<img class='warning' src='img/warning.png'/></div>";

							}

						?>
					</div>
					<button type="submit" name="submit">LOG IN</button>
				</form>
			</div>
		</div>
	</body>
</html>
<?php 

	if (isset($_GET['errorMsg'])) {
		echo "<script type='text/javascript'>
		$('.errorLogin').fadeIn();
		$('.errorLogin').delay(5000).fadeOut();
		</script>";
	}

?>