$(function(){

    //script tambah kelas
	$('#tombolTambahKelas').on('click', function(){
		$('#tambahKelasLabel').html('Tambah Kelas');
		//css selector
		$('.modal-footer button[type=submit]').html('Tambah');
	});

	//script edit kelas
	$('.tombolEditKelas').on('click', function(){
		$('#tambahKelasLabel').html('Edit Kelas');
		$('.modal-footer button[type=submit]').html('Edit');

		const id = $(this).data('kelas');

		$.ajax({
			url: `${baseURL}data/editkelas`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id);
				$('#kode').val(data.kode_kelas);
				$('#kelas').val(data.kelas);
				$('#kelasJurusan').val(data.jurusan_id);
			}
		});

    });
    
});