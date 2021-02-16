$(function(){

    //script tambah kelas
	$('#tombolTambahMapel').on('click', function(){
		$('#tambahMapelLabel').html('Tambah Mapel');
		//css selector
		$('.modal-footer button[type=submit]').html('Tambah');
	});

	//script edit mapel
	$('.tombolEditMapel').on('click', function(){
		$('#tambahMapelLabel').html('Edit Mapel');
		$('.modal-footer button[type=submit]').html('Edit');

		const id = $(this).data('mapel');

		$.ajax({
			url: `${baseURL}data/editmapel`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id);
				$('#jurusanId').val(data.jurusan_id);
				$('#kodeMapel').val(data.kode_mapel);
				$('#mapel').val(data.mapel);
				$('#status').val(data.is_active);
			}
		});

    });
    
});