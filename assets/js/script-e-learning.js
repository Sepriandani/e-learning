$(function () {
	//script upload file
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass("selected").html(fileName);
	});

	//script tambah jurusan
	$('#tombolTambahJurusan').on('click', function(){
		$('#tambahJurusanLabel').html('Tambah Jurusan');
		//css selector
		$('.modal-footer button[type=submit]').html('Tambah');
	});

	//script edit jurusan
	$('.tombolEditJurusan').on('click', function(){
		$('#tambahJurusanLabel').html('Edit Jurusan');
		$('.modal-footer button[type=submit]').html('Edit');

		const id = $(this).data('jurusan');

		$.ajax({
			url: `${baseURL}data/editjurusan`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id);
				$('#jurusan').val(data.jurusan);
			}
		});

	});

});