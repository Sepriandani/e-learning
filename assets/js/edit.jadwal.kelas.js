$(function(){

    //script tambah kelas
	$('#tombolTambahJadwalKelas').on('click', function(){
		$('#tambahJadwalKelasLabel').html('Tambah Jadwal');
		//css selector
		$('.modal-footer button[type=submit]').html('Tambah');
	});

	//script edit mapel
	$('.tombolEditJadwalKelas').on('click', function(){
		$('#tambahJadwalKelasLabel').html('Edit JadwalKelas');
		$('.modal-footer button[type=submit]').html('Edit');

		const id = $(this).data('id');

		$.ajax({
			url: `${baseURL}data/editjadwal`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id);
				$('#mapel').val(data.mapel_id);
				$('#hari').val(data.hari);
				$('#jam').val(data.jam);
			}
		});

    });
    
});