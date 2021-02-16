$(function(){
    $('#tombolTambahTugas').on('click', function(){
        $('#tambahTugasLabel').html('Tambah Tugas');
        $('.modal-footer button[type=submit]').html('Tambah');
    });

    $('.tombolEditTugas').on('click', function(){
        $('#tambahTugasLabel').html('Edit Tugas');
        $('.modal-footer button[type=submit]').html('Edit');

        const id = $(this).data('tugas');

        $.ajax({
            url: `${baseURL}guru/edittugas`,
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#id').val(data.id),
                $('#tugas').val(data.tugas),
                $('#materi').val(data.materi),
                $('#tipe').val(data.tipe),
                $('#jumlah').val(data.jumlah)
            }
        });
    });
});