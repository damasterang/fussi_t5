<?php

    // session_start();
    
    include "connect.php";

    function loginPustakawan($username, $password){
        $password = md5($password);
        $query = mysql_query("SELECT * FROM pustakawan WHERE username='$username' AND password='$password'"); 
        $result = mysql_num_rows($query);
        return $result;
    }

    function getDataLevel($username, $password){
        $password = md5($password);
        $query = mysql_query("SELECT level FROM pustakawan WHERE username='$username' AND password='$password'");
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function getDataIdPustakawan($username, $password){
        $password = md5($password);
        $query = mysql_query("SELECT idPustakawan FROM pustakawan WHERE username='$username' AND password='$password'");
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function getVal($table, $col, $key){
        $query = mysql_query("SELECT * FROM $table WHERE $col='$key'"); 
        $result = mysql_num_rows($query);
        return $result;
    }

    function cekSudahDikembalikan($idKoleksi){
        // $query = mysql_query("SELECT * FROM peminjaman INNER JOIN pengembalian ON 'peminjaman.idPeminjaman'='pengembalian.idPeminjaman' WHERE 'peminjaman.idAnggota'='$idAnggota' AND 'peminjaman.idKoleksi'='$idKoleksi'")
        $query = mysql_query("SELECT * FROM peminjaman WHERE idKoleksi='$idKoleksi' AND status='pinjam'");
        $result = mysql_num_rows($query);
        return $result;
    }

    function getIdPeminjaman($idKoleksi){
        $query = mysql_query("SELECT idPeminjaman FROM peminjaman WHERE idKoleksi='$idKoleksi' AND status='pinjam'");
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function cekMaksPerpanjangan($idPeminjaman){
        $query = mysql_query("SELECT perpanjangan FROM peminjaman WHERE idPeminjaman='$idPeminjaman'"); 
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function cekMaksPeminjaman($idAnggota){
        $query = mysql_query("SELECT COUNT(*) FROM peminjaman WHERE idAnggota='$idAnggota' AND status='pinjam'"); 
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function updatePerpanjangan($tanggalHarusKembali, $perpanjangan, $idPeminjaman){
        $query = mysql_query("UPDATE peminjaman SET tanggalHarusKembali='$tanggalHarusKembali', perpanjangan='$perpanjangan' WHERE idPeminjaman='$idPeminjaman'");
        return $query;
    }

    function masukanPeminjaman($idAnggota, $idKoleksi,$idPustakawan, $date, $datePlus, $perpanjangan){
        $query = mysql_query("INSERT INTO peminjaman (idAnggota, idKoleksi, idPustakawan,tanggalPinjam, tanggalHarusKembali, status, perpanjangan) VALUES ('$idAnggota', '$idKoleksi', '$idPustakawan', '$date', '$datePlus', 'pinjam','$perpanjangan')");
        return $query;
    }

    function masukanPengembalian($idPeminjaman, $tanggalKembali, $denda){
        $query = mysql_query("INSERT INTO pengembalian (idPeminjaman, tanggalKembali, denda) VALUES ('$idPeminjaman', '$tanggalKembali', '$denda')");
        return $query;
    }

    function getData($table, $key, $colom, $val){
        $query = mysql_query("SELECT $key FROM $table WHERE $colom = '$val'");
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function updatePinjamKoleksi($idKoleksi){
        $query = mysql_query("UPDATE koleksi SET status='pinjam' WHERE idKoleksi='$idKoleksi'");
        return $query;
    }

    function updatePinjamPengembalian($idPeminjaman, $tanggalKembali, $jumlahDenda, $idKoleksi){
        $query = mysql_query("UPDATE peminjaman SET status='', tanggalKembali='$tanggalKembali',denda='$jumlahDenda' WHERE idPeminjaman='$idPeminjaman' AND status='pinjam'");
        return $query;
    }

    function getDenda(){
        $query = mysql_query("SELECT denda FROM denda");
        $result = mysql_fetch_row($query);
        return $result[0];
    }

    function calculateDate($setDate){
        $h = 4;
        $i = 1;
        $j = 'on';

        while ($j != 'off') {
            $newSetDate = strtotime ( '+'.$i.' day' , strtotime ( $setDate ) ) ;
            $newSetDate = date ( 'Y-m-j' , $newSetDate );
            if (matchDate($newSetDate) == 1) {
                $i++;
            } else {
                if ($h != 0) {
                    $i++;
                    $h--;
                } else {
                    $j = 'off';
                }
            }
            $newSetDate = strtotime ( '+'.$i.' day' , strtotime ( $setDate ) ) ;
            $newSetDate = date ( 'Y-m-j' , $newSetDate );
            
        }
        return $newSetDate;
    }

    function matchDate($date){
        $query = mysql_query("SELECT * FROM harilibur WHERE harilibur = '$date'");
        if (mysql_num_rows($query) == 1) {
            return 1;
        } else {
            return 0;
        }
    }
?>
