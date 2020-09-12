<?php
$this->load->view('Head_akademik');
?>

<!-- Conten Wrapper, Contains page content -->
<div class="content-wrapper">
  <style>
  .custom-size {
    font-size: 18px;
    font-weight: bold;
  }

  .table tbody tr td {
    vertical-align: middle;
  }
</style>

<?php 

function hari_ini(){
  $hari = date("D");

  switch($hari){
    case 'Sun':
    $hari_ini = "Minggu";
    break;

    case 'Mon':     
    $hari_ini = "Senin";
    break;

    case 'Tue':
    $hari_ini = "Selasa";
    break;

    case 'Wed':
    $hari_ini = "Rabu";
    break;

    case 'Thu':
    $hari_ini = "Kamis";
    break;

    case 'Fri':
    $hari_ini = "Jumat";
    break;

    case 'Sat':
    $hari_ini = "Sabtu";
    break;

    default:
    $hari_ini = "Tidak di ketahui";   
    break;
  }

  return "<b>" . $hari_ini . "</b>";

}

    //ini fungsi untuk mendapatkan hari pada waktu yang telah ditentukan
function hari_pada_tanggal($date){
  if ($date=="") {
    return "";
  } else {
    $hari = date("D", strtotime($date));

    switch($hari){
      case 'Sun':
      $hari_ini = "Minggu";
      break;

      case 'Mon':     
      $hari_ini = "Senin";
      break;

      case 'Tue':
      $hari_ini = "Selasa";
      break;

      case 'Wed':
      $hari_ini = "Rabu";
      break;

      case 'Thu':
      $hari_ini = "Kamis";
      break;

      case 'Fri':
      $hari_ini = "Jumat";
      break;

      case 'Sat':
      $hari_ini = "Sabtu";
      break;

      default:
      $hari_ini = "Tidak di ketahui";   
      break;
    }

    return $hari_ini;     
  }
}

    //untuk menyimpan ruangan yang tersedia pada setiap sesi
    $s1 = array(); //sesi 1
    $s2 = array(); //sesi 2
    $s3 = array(); //sesi 3
    $s4 = array(); //sesi 4

    $s1_block = 0;
    $s2_block = 0;
    $s3_block = 0;
    $s4_block = 0;
    
    //defaultnya get hari pada hari ini :D
    // $hari = hari_pada_tanggal(date("Y-m-d"));
    //$hari = "Senin";

    //ini manggil functionnya
    $hari = hari_pada_tanggal(date('Y-m-d'));
    $tanggal = date("Y-m-d");
    
    //apabila ada filter tanggal yang dimasukkan
    if(!empty($inputtgl)) {
      //get hari pada tanggal yang diinputkan
      $hari = hari_pada_tanggal($inputtgl);
      $tanggal = $inputtgl;
    }
    
    $tgl_absen = date("Y-m-d");
    
    //cek jadwal untuk input kelas pengganti
    if (isset($_POST['cek'])) {
      if (!empty($_POST['tanggal'])) {
        $tgl_absen = $_POST['tanggal'];
      }
    }

    $datasesi = array(
      "07.00 - 08.40",
      "09.00 - 10.40",
      "12.00 - 13.40",
      "14.00 - 15.40",
    );


    
    ?>
    <?php
    $this->load->model('PenggantiAkademikM');
    $index = 0;
    foreach ($tampilRuang as $ruang) {



      foreach ($datasesi as $sesi) {
                          # code...



        $hasil = $this->PenggantiAkademikM->getJadwalAkademikW();

        if (!empty($hasil)) {
          //ada jadwal
          //cek apakah jadwal pada cell ini ada jadwalnya dosen yang mau kelas pengganti?

          //dosen yang pertama adalah dosen yang akan melakukan kelas pengganti
          if ($kelas[0]->nama_dosen == $hasil[0]->Dosen) {
            if($sesi == "07.00 - 08.40"){
            //sesi 1 diblock
              $s1_block = 1;
            //sesi 1 arraynya dikosongin
              $s1 = array();
            }
            elseif ($sesi == "09.00 - 10.40") {
            //sesi 1 diblock
              $s2_block = 1;
            //sesi 1 arraynya dikosongin
              $s2 = array();
            }
            elseif ($sesi == "12.00 - 13.40") {
            //sesi 1 diblock
              $s3_block = 1;
            //sesi 1 arraynya dikosongin
              $s3 = array();
            }
            elseif ($sesi == "14.00 - 15.40") {
            //sesi 1 diblock
              $s4_block = 1;
            //sesi 1 arraynya dikosongin
              $s4 = array();
            }
            
          }

                              // echo $hasil[0]->Kelas;
                              // echo $hasil[0]->Dosen;

        } else {
                              // gak ada jadwal
                              // cek apakah pada ruangan dan sesi ini (cell ini) ada kelas pengganti hadir
          $cek_kelas_pengganti_hadir = $this->PenggantiAkademikM->getKelasPenggantiHadirCustom($ruang->namaRuang, $sesi, $tgl_absen);


          if (!empty($cek_kelas_pengganti_hadir)) {
                                //cek apakah pada cell ini ada jadwalnya kelas pengganti dosen yang mau kelas pengganti?
            if ($kelas[0]->nama_dosen == $cek_kelas_pengganti_hadir[0]->nama_dosen) {
              if($sesi == "07.00 - 08.40"){
              //sesi 1 diblock
                $s1_block = 1;
              //sesi 1 arraynya dikosongin
                $s1 = array();
              }
              elseif ($sesi == "09.00 - 10.40") {
              //sesi 1 diblock
                $s1_block = 2;
              //sesi 1 arraynya dikosongin
                $s1 = array();
              }
              elseif ($sesi == "12.00 - 13.40") {
              //sesi 1 diblock
                $s1_block = 3;
              //sesi 1 arraynya dikosongin
                $s1 = array();
              }
              elseif ($sesi == "14.00 - 15.40") {
              //sesi 1 diblock
                $s1_block = 4;
              //sesi 1 arraynya dikosongin
                $s1 = array();
              }
            }

                                // apabila pada pada cell ini terdapat kelas pengganti hadir (pegganti dari pertemuan sebelumnya)
            // echo "<p style='padding-top: 8px'><label class='label label-success'>Kelas Pengganti</label></p>";
            // echo "<p>" . $cek_kelas_pengganti_hadir[0]->nama_kelas . "</p>";
          }

          //cek apakah pada cell ini sesinya telah diblok?
          if ($s1_block != 1) {
            $s1[$ruang->id_ruang] = $ruang->namaRuang;
                                // array_push($s1, $ruang->id_ruang);
            // echo "<a class='btn btn-success'><i class='fa fa-check'></i></a>";
          }
        }
      }
      $index++;
    }
    ?>
    <!-- Content Header (Page Header)-->
    <section class="content-header">
      <h1><b>Kelas Pengganti Prodi Komputer dan Sistem Informasi</b></h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Kelas Pengganti</a></li>
      </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php
          $this->load->helper('form');
          $error = $this->session->flashdata('error');
          if($error)
          {
            ?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?php echo $this->session->flashdata('error'); ?>                    
            </div>
            <?php } ?>
            <?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
              ?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
              </div>
              <?php } ?>

              <div class="row">
                <div class="col-md-12">
                  <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7">
              <div class="box box-primary">
                <!-- Box Header -->
                <div class="box-header with-border">
                  <center><h3 class="box-title" >Jadwal Pengganti Harian<br></h3></center>
                </div>

                <div class="box-body">
                  <div class="col-md-12">
                    <form action="" method="POST">
                      <div class="form-group text-center">
                        <label>Masukkan Pengechekan Tanggal</label>
                        <input id="getTanggal" type="date" min="<?php echo date('Y-m-d') ?>" name="tanggal" class="form-control" value="<?php echo $tgl_absen ?>" required>
                      </div>
                      <div class="form-group text-center">
                        <input name="cek" type="submit" class="btn btn-primary" value="Cek">
                      </div>
                    </form>
                  </div>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th><center>07.00 - 08.40</center></th>
                        <th><center>09.00 - 10.40</center></th>
                        <th><center>12.00 - 13.40</center></th>
                        <th><center>14.00 - 15.40</center></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                  //load model JadwalAkademikM
                      $this->load->model('JadwalAkademikM');

                      $index = 0;

                      foreach ($tampilRuangAkademik as $ruang) {

                        ?>
                        <tr>
                          <td><b><center><?php echo $ruang->namaRuang; ?></center></b></td>
                          <?php 
                          foreach ($datasesi as $sesi) {
                          # code...

                            ?>
                            <td style="padding: 0">
                              <center>
                                <?php
                                $hasil = $this->JadwalAkademikM->getJadwalAkademikW(hari_pada_tanggal($tgl_absen),$sesi,$ruang->namaRuang);

                                if (!empty($hasil)) {
                              //ada jadwal
                              //cek apakah jadwal pada cell ini ada jadwalnya dosen yang mau kelas pengganti?
                                  ?>
                                  <span><?php echo $hasil[0]->Kelas; ?></span><br>
                                  <span><?php echo $hasil[0]->Dosen; ?></span>
                                  <?php
                                } else {
                              // gak ada jadwal
                              // cek apakah pada ruangan dan sesi ini (cell ini) ada kelas pengganti hadir
                                  $cek_kelas_pengganti_hadir = $this->JadwalAkademikM->getKelasPenggantiHadirCustom($ruang->namaRuang, $sesi, $tgl_absen);


                                  if (!empty($cek_kelas_pengganti_hadir)) {
                                //cek apakah pada cell ini ada jadwalnya kelas pengganti dosen yang mau kelas pengganti?

                                // apabila pada pada cell ini terdapat kelas pengganti hadir (pegganti dari pertemuan sebelumnya)
                                    echo "<p style='padding-top: 8px'><label class='label label-success'>Kelas Pengganti</label></p>";
                                    echo "<p>" . $cek_kelas_pengganti_hadir[0]->nama_kelas . "</p>";
                                  }else{

                              //cek apakah pada cell ini sesinya telah diblok?
                                  if($sesi == "07.00 - 08.40"){
                                    //sesi 1 diblok
                                    if ($s1_block != 1) {
                                      $s1[$ruang->id_ruang] = $ruang->namaRuang;
                                    // array_push($s1, $ruang->id_ruang);
                                      //ini maksudnya tombol ini menyimpan value berupa ruang dll
                                      echo "<a class='tombolpilih btn btn-success' data-ruang='".$ruang->namaRuang."' data-sesi='".$sesi."' data-idruang='".$ruang->id_ruang."'><i class='fa fa-check'></i></a>";
                                    }
                                  }
                                  elseif ($sesi == "09.00 - 10.40") {
                                    if ($s2_block != 1) {
                                      $s2[$ruang->id_ruang] = $ruang->namaRuang;
                                    // array_push($s1, $ruang->id_ruang);
                                      echo "<a class='tombolpilih btn btn-success' data-ruang='".$ruang->namaRuang."' data-sesi='".$sesi."' data-idruang='".$ruang->id_ruang."'><i class='fa fa-check'></i></a>";
                                    }
                                    }elseif ($sesi == "12.00 - 13.40") {
                                    //sesi 1 diblock
                                      if ($s3_block != 1) {
                                        $s3[$ruang->id_ruang] = $ruang->namaRuang;
                                    // array_push($s1, $ruang->id_ruang);
                                        echo "<a class='tombolpilih btn btn-success' data-ruang='".$ruang->namaRuang."' data-sesi='".$sesi."' data-idruang='".$ruang->id_ruang."'><i class='fa fa-check'></i></a>";
                                      }
                                    }
                                      elseif ($sesi == "14.00 - 15.40") {
                                    //sesi 1 diblock
                                        if ($s4_block != 1) {
                                          $s4[$ruang->id_ruang] = $ruang->namaRuang;
                                    // array_push($s1, $ruang->id_ruang);
                                          echo "<a class='tombolpilih btn btn-success' data-ruang='".$ruang->namaRuang."' data-sesi='".$sesi."' data-idruang='".$ruang->id_ruang."' ><i class='fa fa-check'></i></a>";
                                        }
                                      }
                                    }
                                      ?>
                                    </center>
                                  </td>
                                  <?php
                                }
                              }
                                ?>
                                <!-- ========================================================================= ini adalah akhir dari sesi pertama -->
                              </tr>
                              <?php
                              $index++;
                            }

                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <?php 

        //semua isi sesi dijadikan 1
                  $all = array( 
                    "07.00 - 08.40"=>$s1, 
                    "09.00 - 10.40"=>$s2, 
                    "12.00 - 13.40"=>$s3, 
                    "14.00 - 15.40"=>$s4
                  );

                  ?>

                  <div class="col-md-5">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">Mengajukan Kelas Pengganti</h3>
                        <p><?php

              // foreach ($s1 as $key=>$value) {
                //echo var_dump($all);
                // echo $key . " " . $value . "<br>";
              // }

                        ?>
                      </p>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-2">
                              <label>Kelas</label>
                            </div>
                            <div class="col-md-10">
                              <p><?php echo $kelas[0]->nama_kelas ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-2">
                              <label>Dosen</label>
                            </div>
                            <div class="col-md-10">
                              <p><?php echo $kelas[0]->nama_dosen ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-2">
                              <label>Hari</label>
                            </div>
                            <div class="col-md-10">
                              <p><?php echo hari_pada_tanggal($tgl) . ", " . date("d-F-Y", strtotime($tgl)); ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-2">
                              <label>Ruang</label>
                            </div>
                            <div class="col-md-10">
                              <p><?php echo $kelas[0]->nama_ruang ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form action="<?php echo base_url() ?>inputKelasPengganti" method="POST" role="form">
                    <div class="box box-primary">
                      <div class="box-body" >
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Tanggal Hadir</label>
                              <input type="text" class="form-control" id="tgl_input" name="tgl_hadir" value="<?php echo $tgl_absen ?>" required readonly>
                              <input type="hidden" class="form-control" id="id_kelas" name="id_kelas" value="<?php echo $kelas[0]->id_kelas ?>" required readonly>
                              <input type="hidden" class="form-control" name="tgl_absen" value="<?php echo $tgl ?>" required readonly>
                              <p class="text-muted"><small><i>*Silahkan lakukan cek ketersediaan</i></small></p>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Ruangan</label>
                              <input type="text" class="form-control" id="ruang" name="ruang" required readonly>
                              <input type="hidden" class="form-control" id="id_ruang" name="id_ruang" required readonly>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Sesi</label>
                              <input type="text" class="form-control" id="sesi" name="sesi" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Keterangan</label>
                              <textarea rows="3" class="form-control" name="keterangan" placeholder="Isikan keterangan kelas pengganti" required></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="box-footer">
                        <input type="submit" class="btn btn-primary pull-right" value="Simpan">
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </section>
          </div>
          <script>

            /** add active class and stay opened when selected */
            var url = window.location;

  // for sidebar menu entirely but not cover treeview
  $('ul.sidebar-menu a').filter(function() {
    return this.href == url;
  }).parent().addClass('active');
  
  // for treeview
  $('ul.treeview-menu a').filter(function() {
    return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>
<script type="text/javascript">
  //ini manggil class dari a tadi
  $('.tombolpilih').click(function(){
    //ini get id pas input
    var ruang = $(this).data("ruang");
    var sesi = $(this).data("sesi");
    var id_ruang = $(this).data("idruang");
    $("#ruang").val(ruang);
    $("#sesi").val(sesi);
    $("#id_ruang").val(id_ruang);
  });
</script>
</body>
<footer class="main-footer">
  <strong><center>Copyright &copy; Sistem Informasi Kelas Pengganti KOMSI</center></strong>
</footer>
</html>