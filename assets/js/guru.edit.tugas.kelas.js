$(function(){
    $('#tombolTambahTugasKelas').on('click', function(){
        $('#tambahTugasKelasLabel').html('Tambah Tugas');
        $('.modal-footer button[type=submit]').html('Tambah');
    });

    $('.tombolEditTugasKelas').on('click', function(){
        $('#tambahTugasKelasLabel').html('Edit Tugas');
        $('.modal-footer button[type=submit]').html('Edit');

        const id = $(this).data('id');

        $.jax({
            url: `${baseURL}guru/edittugaskelas`,
            data: {
                id : id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#id').val(data.id),
                $('#tugasKelas').val(data.tugas_id)
            }
        });

    });
});