<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['id_login'])) {
        echo "<script>window.location.href='../index.php';</script>";
    } else {
?>
<?php
include '../../koneksi.php';
require('../../assets/pdf/fpdf.php');

if (isset($_GET['nama'])) 
	$a = $_GET['nama'];
	$b = $_GET['tgl'];
	$q = mysqli_query($conn, "SELECT * FROM transaksi left join master on master.id_master=transaksi.id_master left join karyawan on karyawan.id_karyawan=transaksi.id_karyawan left join konsumen on konsumen.nama=transaksi.nama_R where transaksi.nama_R='$a' and transaksi.tgl_transaksi='$b'");
	$da = mysqli_fetch_array($q);


$pdf = new FPDF("P","mm",array(93,37));

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',7);
$pdf->SetX(1);
$pdf->SetTextColor(0); 
$pdf->Image('../../images/logoo.png',0,1,13);           
$pdf->Text(13, 5.6, 'LOUNDRY SEHATI');
$pdf->SetFont('Times','',5);
$pdf->Text(16, 8.4, 'JL.Kartini No. 33A'); 
$pdf->Text(14, 10.5, 'Pangarangan - Sumenep');
$pdf->Text(16, 12.8, 'Telp.082330263968');



$pdf->SetFont('Arial','B', 3.8);
$pdf->SetMargins(0.8,2,3,1,1);
	$pdf->ln(19);
	// $pdf->Cell(19, -1, 'Nomer Nota', 0, 0, 'L');
	// $pdf->Cell(9, -1, ': ' .$da['no_nota'], 0, 0, 'L');
	// $pdf->ln(2);
	$pdf->Cell(19, -1, 'Nama Pelanggan', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$da['nama_R'], 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Alamat', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$da['alamat_konsumen'], 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Nomer Tlp', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$da['nohp_konsumen'], 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Tanggal Transaksi', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .date('d-m-Y', strtotime($da['tgl_transaksi'])), 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Tanggal Selesai', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .date('d-m-Y', strtotime($da['tgl_selesai'])), 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Text(0, 31, '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -');

$qu = mysqli_query($conn, "SELECT * FROM transaksi left join master on master.id_master=transaksi.id_master left join karyawan on karyawan.id_karyawan=transaksi.id_karyawan left join konsumen on konsumen.nama=transaksi.nama_R where transaksi.nama_R='$a' and transaksi.tgl_transaksi='$b'");

while ($d = mysqli_fetch_array($qu)) {

$pdf->SetFont('Arial','B',3.8);
$pdf->SetMargins(0.8,2,3,1,1);
	$pdf->ln(2.8);
	$pdf->Cell(19, -1, 'No Nota', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$d['no_nota'], 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Jenis Cucian', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$d['jenis'], 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Berat', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$d['berat']. 'Kg', 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Jumlah Helai', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$d['jumlah_helai']. 'pcs', 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Harga', 0, 0, 'L');
	$pdf->Cell(9, -1, ': Rp.' .number_format($d['jumlah_bayar']), 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Dp', 0, 0, 'L');
	$pdf->Cell(9, -1, ': Rp.' .number_format($d['dp']), 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Sisa Kembalian', 0, 0, 'L');
	$pdf->Cell(9, -1, ': Rp.' .number_format($d['sisa_kembali']), 0, 0, 'L');
	$pdf->ln(2);
	$pdf->Cell(19, -1, 'Diskon', 0, 0, 'L');
	$pdf->Cell(9, -1, ': ' .$d['diskon']. '%', 0, 0, 'L');
	$pdf->ln(3);


}



$nat = mysqli_query($conn, "SELECT *, sum(jumlah_bayar) as jml FROM transaksi left join master on master.id_master=transaksi.id_master left join karyawan on karyawan.id_karyawan=transaksi.id_karyawan left join konsumen on konsumen.nama=transaksi.nama_R where transaksi.nama_R='$a' and transaksi.tgl_transaksi='$b'");

$jan = mysqli_fetch_array($nat); 

$pdf->SetFont('Arial','B',4.4);

$pdf->Cell(19, -1, '---------------------------------------------------------------', 0, 0, 'L');
$pdf->ln(2);
$pdf->Cell(19, -1, 'T O T A L', 0, 0, 'L');
$pdf->Cell(9, -1, ': Rp.' .number_format($jan['jml']). '', 0, 0, 'L');

// $qu = mysqli_query($conn, "SELECT * FROM transaksi left join master on master.id_master=transaksi.id_master left join karyawan on karyawan.id_karyawan=transaksi.id_karyawan left join konsumen on konsumen.nama=transaksi.nama_R where transaksi.nama_R='$a' and transaksi.tgl_transaksi='$b'");
// while ($d = mysqli_fetch_array($qu)) {
// 	$pdf->SetFont('Arial','B',2);
// 	$pdf->ln(1.5);
// 	$no=1;
// 	// $pdf->Cell(2, -1.5, $no, 1, 0, 'C');
// 	$pdf->Cell(6.7, -1.5, $d['jenis'], 1, 0, 'C');
// 	$pdf->Cell(3.6, -1.5, $d['berat'], 1, 0, 'C');
// 	$pdf->Cell(5, -1.5, 'Rp.'.$d['harga'], 1, 0, 'C');
// 	$pdf->Cell(7, -1.5, $d['status_pembayaran'], 1, 0, 'C');
// 	$pdf->Cell(3.6, -1.5, 'Rp.'.$d['dp'], 1, 0, 'C');
// 	$pdf->Cell(6.7, -1.5, 'Rp.'.number_format($d['jumlah_bayar']), 1, 0, 'C');
// 	$no++;
// }
// 	$pdf->ln(1.5);
// 	$pdf->Cell(27.9, -1.5, 'Total', 1, 0, 'C');
// 	$pdf->Cell(6.7, -1.5, 'Rp.'.$da['jml'], 1, 0, 'C');




// $pdf->Cell(190,1,'','B',0,'L');



$pdf->Output("nota.pdf","I");

?>