$(function(){
    $('#tombolTambahGuru').on('click', function() {
        $('#editGuruLabel').html('Tambah Guru');
        $('.modal-footer button[type=submit]').html('Tambah');
        $('.password').show();
    });

    $('.tombolEditGuru').on('click', function(){
        $('#editGuruLabel').html('Edit Guru');
        $('.modal-footer button[type=submit]').html('Edit');
        $('.password').hide();

        const id = $(this).data('guru');

        $.ajax({
            url: `${baseURL}data/editguru`,
            data: {
                id : id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#id').val(data.id),
                $('#nip').val(data.nip),
                $('#nama').val(data.nama),
                $('#email').val(data.email),
                $('#mapel').val(data.mapel_id),
                $('#status').val(data.is_active)
            }
        });
    });
});