<?php 

session_start();

if (isset($_SESSION['username'])) {

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Peminjaman</title>
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
			<div class="rightHeader buttonMenu green">
				<a href="logout.php"><img src="img/logoLogout.png" alt="Logout"/>
					<div>Logout</div></a>
			</div>
			<div class="rightHeader buttonMenu orange">
				<a href="index.php"><img src="img/logoHome.png" alt="Home"/>
					<div>home</div></a>
			</div>
			<div class="buttonMenu username">
				<img src="img/logoLogin.png" alt="Home"/>
					<div id="username"><?php echo $_SESSION['username']; ?></div>
			</div>
		</div>
		<div id="main">
			<div id="wrapper2">
				<h1>Peminjaman Koleksi</h1>
				<form action="process.php?a=peminjaman" method="POST">
					<table border="collapse">
						<tr>
							<td><div class="label">Id Anggota</div></td>
							<td>:</td>
							<td><input type="text" name="idAnggota" placeholder="input id anggota"/></td>
						</tr>
						<tr>
							<td><div class="label">Id Koleksi</div></td>
							<td>:</td>
							<td><input type="text" name="idKoleksi" placeholder='input id koleksi'/></td>
						</tr>
					</table>
					<div class="wrapperErrorLogin">
						<?php 

							if (isset($_GET['errorMsg'])) {
								echo "<div class='errorLogin'>";
								if ($_GET['errorMsg'] == 1) {
									echo "<div>isi data form terlebih dulu</div>";
								} elseif($_GET['errorMsg'] == 2){
									echo "<div>id anggota atau id koleksi tidak boleh kosong</div>";
								} elseif($_GET['errorMsg'] == 3){
									echo "<div>anggota dan/atau koleksi tidak ditemukan</div>";
								} elseif ($_GET['errorMsg'] == 4) {
									echo "<div>anda melebihi maksimal pinjam</div>";
								} elseif ($_GET['errorMsg'] == 5) {
									echo "<div>tidak boleh memperpanjang lagi</div>";
								} elseif ($_GET['errorMsg'] == 6) {
									echo "<div>gagal memasukan data</div>";
								} elseif ($_GET['errorMsg'] == 7) {
									echo "<div>anda harus melakukan peminjaman terlebih dahulu</div>";
								}
								echo "<img class='warning' src='img/warning.png'/></div>";
							}

						?>
					</div>
					<button type="submit" name="submit">Pinjam</button>
				</form>
			</div>
			<div id="sideMenu" class="<?php 
				if ($_SESSION['act'] == 0) {
					echo 'sideMenuAct'; 
					$_SESSION['act'] = 1;
				}
			?>">
				<a href="#" class="navMenu">Tambah Anggota</a>
				<a href="#" class="navMenu">Edit Anggota</a>
				<a href="#" class="navMenu">Hapus Anggota</a>
				<a href="#" class="navMenu">Cari Anggota</a>
				<a href="#" class="navMenu">Tambah Koleksi</a>
				<a href="#" class="navMenu">Edit Koleksi</a>
				<a href="#" class="navMenu">Cari Koleksi</a>
				<a href="peminjaman.php" class="navMenu">Peminjaman</a>
				<a href="pengembalian.php" class="navMenu">Pengembalian</a>
				<a href="#" class="navMenu">Cetak Surat Bebas</a>
				<a href="#" class="navMenu">Atur Hari Libur</a>
				<a href="#" class="navMenu">Tambah Pustakawan</a>
				<a href="#" class="navMenu">Edit Pustakawan</a>
				<a href="#" class="navMenu">Cetak Laporan</a>
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

<?php

} else {
	header("location:login.php?errorMsg=3");
}

?>