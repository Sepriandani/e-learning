$(function(){
    $('#tombolKunciJawaban').on('click', function(){
        $('#kunciJawabanLabel').html('Buat kunci jawaban');
        $('.modal-footer button[type=submit]').html('Buat');
        $('#tampilKunciJawaban').hide();
        $('#inputKunciJawaban').show();
        $('#inputBobotNilai').hide();
        $('.modal-footer').show();
    });
    $('#tombolLihatJawaban').on('click', function(){
        $('#kunciJawabanLabel').html('kunci jawaban');
        $('#tampilKunciJawaban').show();
        $('#inputKunciJawaban').hide();
        $('#inputBobotNilai').hide();
        $('.modal-foote').hide();
    });
});