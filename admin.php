<?php 

	session_start();

	if (isset($_SESSION['username'])) {
		$_SESSION['act'] = 0;

 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin</title>
		<link rel="icon" type="image/png" href="img/logoBlackUns.png" />
		<link rel="stylesheet" type="text/css" href="css/newStyle.css">
	</head>
	<body>
		<div id="header">
			<div class="logo">
				<img src="img/logoUns.png" alt="Logo UNS"/>
				<div>Perpustakaan Universitas Sebelas Maret</div>
			</div>
			<div class="rightHeader buttonMenu purple">
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
			<div id="wrapper3">
				<h2>Selamat Datang <?php echo $_SESSION['username']; ?></h2>
				<a href="#" class="optionAdmin">Tambah Anggota</a>
				<a href="#" class="optionAdmin">Edit Anggota</a>
				<a href="#" class="optionAdmin">Hapus Anggota</a>
				<a href="#" class="optionAdmin">Cari Anggota</a>
				<a href="#" class="optionAdmin">Tambah Koleksi</a>
				<a href="#" class="optionAdmin">Edit Koleksi</a>
				<a href="#" class="optionAdmin">Cari Koleksi</a>
				<a href="peminjaman.php" class="optionAdmin">Peminjaman</a>
				<a href="pengembalian.php" class="optionAdmin">Pengembalian</a>
				<a href="#" class="optionAdmin">Cetak Surat Bebas</a>
				<a href="#" class="optionAdmin">Atur Hari Libur</a>
				<a href="#" class="optionAdmin">Cetak Laporan</a>
				<?php if ($_SESSION['level'] == 'super admin') {
					
					echo "<a href='#' class='optionAdmin'>Tambah Pustakawan</a>
					<a href='#' class='optionAdmin'>Edit Pustakawan</a>";
				} ?>
			</div>
			
		</div>
	</body>
</html>

<?php } else {
		header('location:login.php?errorMsg=3');
		exit();
	}

?>