<?php
		
	
	include "function.php";


	if ($_GET['a'] == 'login') {

		if (isset($_POST['username']) && isset($_POST['password'])) {
			
			$username = $_POST['username'];
			$password = $_POST['password'];

			if ($username == '' || $password == '') {
				header('location: login.php?errorMsg=2');
				exit();
			}

			session_start();

			$cek = loginPustakawan($username, $password);

			if ($cek >= 1) {
				$level = getDataLevel($username, $password);
				$idPustakawan = getDataIdPustakawan($username, $password);
				$_SESSION['level'] = $level;
				$_SESSION['idPustakawan'] = $idPustakawan;
				$_SESSION['username'] = $username;
				$_SESSION['act'] = 0;
				header("location:admin.php");	
			} else {
				header('location: login.php?errorMsg=1');
			}
			
		} else {
			header('location: login.php?errorMsg=2');
		}
	} elseif ($_GET['a'] == 'peminjaman') {
		
		if (isset($_POST['idAnggota']) && isset($_POST['idKoleksi'])) {

			$idAnggota = $_POST['idAnggota'];
			$idKoleksi = $_POST['idKoleksi'];

			if ($idAnggota == '' || $idKoleksi == '') {
				header('location: peminjaman.php?errorMsg=2');
				exit();
			}

			session_start();

			$cekMahasiswa 	= getVal('anggota', 'idAnggota' , $idAnggota);
			$cekKoleksi 	= getVal('koleksi', 'idKoleksi' , $idKoleksi);

			// echo "$cekMahasiswa";

			if ($cekMahasiswa > 0) {
				if ($cekKoleksi > 0) {

						$cekSudahDikembalikan = cekSudahDikembalikan($idAnggota, $idKoleksi);

						if ($cekSudahDikembalikan == 0) {
											
							$cekMaksPeminjaman = cekMaksPeminjaman($idAnggota);

							if ($cekMaksPeminjaman < 5) {

									$perpanjangan = 1;

									$date = date('Y-m-j');
									$newDate = calculateDate($date);

									updatePinjamKoleksi($idKoleksi);
									
									$masukan = masukanPeminjaman($idAnggota, $idKoleksi, $_SESSION['idPustakawan'], $date, $newDate, $perpanjangan);

									if ($masukan) {
										$_SESSION['idAnggota'] = $idAnggota;
										$_SESSION['namaAnggota'] = getData('anggota','nama','idAnggota',$idAnggota);
										$_SESSION['idKoleksi'] = $idKoleksi;
										$_SESSION['judulKoleksi'] = getData('koleksi','judulKoleksi','idKoleksi',$idKoleksi);
										$_SESSION['tanggalPinjam'] = date('d - m - Y');
										$_SESSION['tanggalHarusKembali'] = date('d - m - Y',strtotime($newDate));
										header('location:laporanpeminjaman.php');
									} else {
										header('location:peminjaman.php?errorMsg=7'); //error memasukan data
										exit();
									}
								} else {
									header('location:peminjaman.php?errorMsg=4'); //error maks pinjam
									exit();
								}
								
							} else {

								$idPeminjaman = getIdPeminjaman($idKoleksi);
								$cekMaksPerpanjangan = cekMaksPerpanjangan($idPeminjaman);

								if ($cekMaksPerpanjangan < 3) {

									// if ($cekMaksPerpanjangan == '') {
									// 	$cekMaksPerpanjangan = 0;
									// }

									$perpanjangan = $cekMaksPerpanjangan+1;
									// echo $perpanjangan;

									$date = date('Y-m-d');
									$newDate = calculateDate($date);
									
									$updatePerpanjangan = updatePerpanjangan($newDate, $perpanjangan, $idPeminjaman);
									if ($updatePerpanjangan) {
										$_SESSION['idAnggota'] = $idAnggota;
										$_SESSION['namaAnggota'] = getData('anggota','nama','idAnggota',$idAnggota);
										$_SESSION['idKoleksi'] = $idKoleksi;
										$_SESSION['judulKoleksi'] = getData('koleksi','judulKoleksi','idKoleksi',$idKoleksi);
										$_SESSION['tanggalPinjam'] = date('d - m - Y');
										$_SESSION['tanggalHarusKembali'] = date('d - m - Y',strtotime($newDate));
										header('location:laporanpeminjaman.php?pr=1205');
									} else {
										header('location:peminjaman.php?errorMsg=6'); //error memasukan data
									}
								} else {
									header('location:peminjaman.php?errorMsg=5'); //error tidak boleh memperpanjang lagi	
								}
								
							}
							

					} else {
						header("location:peminjaman.php?errorMsg=3");	
					}

				} else {
					header("location:peminjaman.php?errorMsg=3");
				}

			} else {
				header("location:peminjaman.php?errorMsg=1");
			}

		} elseif ($_GET['a'] == 'pengembalian') {
			if (isset($_POST['idKoleksi'])){
				// $idAnggota = $_POST['idAnggota']; // ??????
				$idKoleksi = $_POST['idKoleksi'];

				if ($idKoleksi == '') {
					header('location: pengembalian.php?errorMsg=2');
					exit();
				}
				// $cekMahasiswa 	= getVal('anggota', 'idAnggota' , $idAnggota); // ??????
				$cekKoleksi 	= getVal('koleksi', 'idKoleksi' , $idKoleksi);

				// if ($cekMahasiswa > 0) { // ??????
					if ($cekKoleksi > 0) {

						$cekSudahDikembalikan = cekSudahDikembalikan($idKoleksi);

						if ($cekSudahDikembalikan > 0) {
							$date = strtotime(date('Y-m-j'));
							$idPeminjaman = getIdPeminjaman($idKoleksi);
							$tanggalHarusKembali = getData('peminjaman','tanggalHarusKembali','idPeminjaman',$idPeminjaman);
							$tanggalHarusKembali = strtotime($tanggalHarusKembali);
							$selisihDetik = ($date-$tanggalHarusKembali);
							$selisihHari = $selisihDetik / 86400;
							if ($selisihHari < 1) {
								$jumlahDenda = 0;
								$selisihHari = 0;
								// echo "tanpa denda";
							} else {
								$denda = getDenda();
								$jumlahDenda = $selisihHari * $denda;
							}

							updatePinjamPengembalian($idPeminjaman, date('Y-m-d'), $jumlahDenda,$idKoleksi);

							masukanPengembalian($idPeminjaman, date('Y-m-d'), $jumlahDenda);

							session_start();

							$idAnggota = getData('peminjaman','idAnggota','idPeminjaman',$idPeminjaman);
							$_SESSION['idAnggota'] = $idAnggota;
							$_SESSION['namaAnggota'] = getData('anggota','nama','idAnggota',$idAnggota);
							$_SESSION['tanggalHarusKembali'] = date('d-m-Y', $tanggalHarusKembali);
							$_SESSION['tanggalKembali'] = date('d-m-Y');
							// echo $_SESSION['tanggalKembali'];
							$_SESSION['selisihHari'] = $selisihHari;
							$_SESSION['jumlahDenda'] = $jumlahDenda;
							header('location: 	laporanpengembalian.php');
						} else {
							header('location: pengembalian.php?errorMsg=3'); //sudah dikembalikan
							exit();
						}

					} else {
						header("location:pengembalian.php?errorMsg=1");
						exit();
					}

				// } else {
				// 	header("location:pengembalian.php?errorMsg=1");
				// 	exit();
				// }

			} else {
				header("location:pengembalian.php?errorMsg=2");
				exit();
			}
		} else {
			header("location:login.php?errorMsg=1");
			exit();
		}

?>