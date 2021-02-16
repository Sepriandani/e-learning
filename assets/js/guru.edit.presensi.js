$(function(){
    $('#tombolTambahPresensiKelas').on('click', function(){
        $('#tambahPresensiKelasLabel').html('Tambah Presensi');
        $('.modal-footer button[type=submit]').html('Tambah');
    });

    $('.tombolEditPresensiKelas').on('click', function(){
        $('#tambahPresensiKelasLabel').html('Edit Presensi');
        $('.modal-footer button[type=submit]').html('Edit');

        const id = $(this).data('presensi');

        $.ajax({
            url: `${baseURL}guru/editpresensi`,
            data:{
                id : id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#idPresensi').val(data.id),
                $('#pertemuanPresensi').val(data.pertemuan),
                $('#jamMulai').val(data.jam_mulai),
                $('#menitMulai').val(data.menit_mulai),
                $('#detikMulai').val(data.detik_mulai),
                $('#jamBerakhir').val(data.jam_berakhir),
                $('#menitBerakhir').val(data.menit_berakhir),
                $('#detikBerakhir').val(data.detik_berakhir)
            }
        });

    });
});