$(function(){
    $('.tombolEditSoal').on('click', function(){
        const id = $(this).data('edit');
        const tipe = $(this).data('tipe');

        $.ajax({
            url: `${baseURL}guru/editsoal`,
            data: {
                id : id,
                tipe: tipe
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#id').val(data.id),
                $('#pertanyaan').val(data.pertanyaan),
                $('#pilihan-A').val(data.pilihan_a),
                $('#pilihan-B').val(data.pilihan_b),
                $('#pilihan-C').val(data.pilihan_c),
                $('#pilihan-D').val(data.pilihan_d),
                $('#pilihan-E').val(data.pilihan_e)
            }
        });
    });
});