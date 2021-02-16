           <!-- Footer -->
           <footer class="sticky-footer bg-white">
               <div class="container my-auto">
                   <div class="copyright text-center my-auto">
                       <span>Created by : Seprian Dani | Kelompok 71 | KKN ITERA 2021</span>
                       <!-- <span>Copyright &copy; Your Website 2020</span> -->
                   </div>
               </div>
           </footer>
           <!-- End of Footer -->

           </div>
           <!-- End of Content Wrapper -->

           </div>
           <!-- End of Page Wrapper -->

           <!-- Scroll to Top Button-->
           <a class="scroll-to-top rounded" href="#page-top">
               <i class="fas fa-angle-up"></i>
           </a>

           <!-- Modal presensi-->
           <div class="modal fade" id="presensiSiswa" tabindex="-1" role="dialog" aria-labelledby="presensiSiswaLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header card-header">
                           <h5 class="modal-title" id="presensiSiswaLabel">Presensi pertemuan ke-<?= $setPresensi['pertemuan'] . ' ' . $mapel['mapel']; ?></h5>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">×</span>
                           </button>
                       </div>
                       <form action="<?= base_url('siswa/presensiSiswa/') . $siswa['kelas_id'] . '/' . $guru['id'] . '/' . $setPresensi['id']; ?>" method="POST">
                           <div class="modal-body">
                               <div class="form-group">
                                   <input type="text" class="form-control" id="id" name="id" value="<?= $siswa['id']; ?>" hidden>
                               </div>
                               <div class="form-group">
                                   <label for="nis" class="form-label">Nis</label>
                                   <input type="text" class="form-control" id="nis" name="nis" placeholder="masukkan nis....">
                               </div>
                               <div class="form-group">
                                   <label for="nama" class="form-label">Nama</label>
                                   <input type="text" class="form-control" id="nama" name="nama" placeholder="masukkan nama....">
                               </div>
                               <div class="form-group">
                                   <label for="email" class="form-label">Email</label>
                                   <input type="text" class="form-control" id="email" name="email" placeholder="masukkan email....">
                               </div>
                           </div>
                           <div class="modal-footer card-footer">
                               <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                               <button type="submit" class="btn btn-primary">Tambah</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>

           <!-- Logout Modal-->
           <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">×</span>
                           </button>
                       </div>
                       <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                       <div class="modal-footer">
                           <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                           <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                       </div>
                   </div>
               </div>
           </div>

           <!-- Bootstrap core JavaScript-->
           <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
           <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

           <!-- Core plugin JavaScript-->
           <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

           <!-- Custom scripts for all pages-->
           <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
           <!-- Page level plugins -->
           <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
           <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

           <!-- Page level custom scripts -->
           <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

           <!-- Page level plugins -->
           <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

           <!-- Page level custom scripts -->
           <script src="<?= base_url('assets/'); ?>js/jquery-3.5.1.min.js"></script>
           <script>
               var baseURL = '<?= base_url(); ?>';
           </script>
           <script src="<?= base_url('assets/'); ?>js/script-e-learning.js"></script>
           <script src="<?= base_url('assets/'); ?>js/edit-mapel.js"></script>
           <script src="<?= base_url('assets/'); ?>js/edit.jadwal.kelas.js"></script>
           <script src="<?= base_url('assets/'); ?>js/edit.kelas.js"></script>
           <script src="<?= base_url('assets/'); ?>js/data.edit.guru.js"></script>
           <script src="<?= base_url('assets/'); ?>js/data.edit.siswa.js"></script>
           <script src="<?= base_url('assets/'); ?>js/materi.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.edit.video.js"></script>
           <script src="<?= base_url('assets/'); ?>js/pengumuman.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.edit.tugas.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.edit.soal.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.edit.soal.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.edit.presensi.js"></script>
           <script src="<?= base_url('assets/'); ?>js/guru.kunci.jawaban.js"></script>
           <script src="<?= base_url('assets/'); ?>js/search.js"></script>
           <script>
               $(function() {
                   $('.comment-toggler').on('click', function() {
                       var t = $(this);
                       $('#' + t.data('target')).toggle('slow');
                   });
               });
           </script>

           <script>
               $(function() {
                   $('#tombolBobotNilai').on('click', function() {
                       $('.modal-footer button[type=submit]').html('Tambah');
                       $('.modal-footer').show();
                   });
               });
           </script>

           <script>
               $(function() {
                   // Mengatur waktu akhir perhitungan mundur
                   var mulaiPresensi = new Date("<?= date('M d, Y H:i:s', $setPresensi['waktu_mulai']); ?>").getTime();
                   var countDownDate = new Date("<?= date('M d, Y H:i:s', $setPresensi['waktu_berakhir']); ?>").getTime();
                   var sekarang = new Date().getTime();

                   if (mulaiPresensi > sekarang) {
                       $('#demo').hide();
                   } else {

                       // Memperbarui hitungan mundur setiap 1 detik
                       var x = setInterval(function() {
                           // Untuk mendapatkan tanggal dan waktu hari ini
                           var now = new Date().getTime();
                           // Temukan jarak antara sekarang dan tanggal hitung mundur
                           var distance = countDownDate - now;

                           // Perhitungan waktu untuk hari, jam, menit dan detik
                           var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                           var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                           var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                           var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                           // Keluarkan hasil dalam elemen dengan id = "demo"
                           $('#demo').show();
                           $('#popup').show();
                           $('#jam').html(hours);
                           $('#menit').html(minutes);
                           $('#detik').html(seconds);

                           // Jika hitungan mundur selesai, tulis beberapa teks 
                           if (distance < 0) {
                               clearInterval(x);
                               $('#demo').hide();
                               $('#popup').hide();
                               $('#statusPresensi').html('Non-active');
                           };

                       }, 1000);
                   };

               });
           </script>

           </body>

           </html>