$(function(){

    $('#tombolTambahSiswa').on('click', function() {
        $('#editSiswaLabel').html('Tambah Siswa');
        $('.modal-footer button[type=submit]').html('Tambah');
        $('.password').show();
    });

    $('.tombolEditSiswa').on('click', function(){
        $('#editSiswaLabel').html('Edit Siswa');
        $('.modal-footer button[type=submit]').html('Edit');
        $('.password').hide();

        const id = $(this).data('siswa');

        $.ajax({
            url: `${baseURL}data/editsiswa`,
            data: {
                id : id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#id').val(data.id),
                $('#nis').val(data.nis),
                $('#nama').val(data.nama),
                $('#email').val(data.email),
                $('#jurusan').val(data.jurusan_id),
                $('#kelas').val(data.kelas_id),
                $('#semester').val(data.semester),
                $('#status').val(data.is_active)
            }
        });
    });

});