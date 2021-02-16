$(function(){

    $('#tombolTambahVideo').on('click', function(){
        $('#tambahVideoLabel').html('Tambah Video');
        $('.modal-footer button[type=submit]').htm('Tambah');
    });

    $('.tombolEditVideo').on('click', function(){
        $('#tambahVideoLabel').html('Edit Video');
        $('.modal-footer button[type=submit]').html('Edit');

        const id = $(this).data('video');

        $.ajax({
            url: `${baseURL}guru/editVideo`,
            data: {
                id : id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#videoId').val(data.id),
                $('#judulVideo').val(data.judul),
                $('#link').val(data.link)
            }
        });
    });

});