<?php 

session_start();

if (isset($_SESSION['username'])) {
	if (isset($_SESSION['idKoleksi'])) {

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Peminjaman</title>
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
			<div id="wrapper4">
				<h1><?php if (isset($_GET['pr'])) { echo "Perpanjangan"; }
				else { echo "Peminjaman"; } ?> Berhasil</h1>
				<table border="collapse" class="left border">
					<tr>
						<td class="specialTd">Id Koleksi</td>
						<td><?php echo $_SESSION['idKoleksi']; ?></td>
					</tr>
					<tr>
						<td class="specialTd">Judul Koleksi</td>
						<td><?php echo $_SESSION['judulKoleksi']; ?></td>
					</tr>
					<tr>
						<td class="specialTd">Id Anggota</td>
						<td><?php echo $_SESSION['idAnggota']; ?></td>
					</tr>
					<tr>
						<td class="specialTd">Nama</td>
						<td><?php echo $_SESSION['namaAnggota']; ?></td>
					</tr>
					<tr>
						<td class="specialTd">tanggal pinjam</td>
						<td><?php echo $_SESSION['tanggalPinjam']; ?></td>
					</tr>
					<tr>
						<td class="specialTd">tanggal harus kembali</td>
						<td><?php echo $_SESSION['tanggalHarusKembali']; ?></td>
					</tr>
				</table>  
			<a href="peminjaman.php">	<div class="back">
					<div class="text">Pinjam</div>
					<img id="arrowBack" src="img/arrowBack.png" alt="arrow"/>
				</div>	</a>
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
	} else{
		header("location:peminjaman.php?errorMsg=7");
		exit();
	}
} else {
	header("location:login.php?errorMsg=3");
	exit();
}

?>