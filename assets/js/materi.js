$(function(){
    //script upload file
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass("selected").html(fileName);
	});

	//script ketika tombol tambah materi diklik
	$('#tambahMateri').on('click', function(){
		$('#tamabahMateriLabel').html('Tambah Materi');
		$('.modal-footer button[type=submit]').html('Tambah');
	});

	//script edit kelas
	$('.tombolEditMateri').on('click', function(){
		$('#tambahMateriLabel').html('Edit Materi');
		$('.modal-footer button[type=submit]').html('Edit');

		const id = $(this).data('materi');

		$.ajax({
			url: `${baseURL}guru/editMateri`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id),
				$('#pertemuan').val(data.pertemuan),
				$('#judul').val(data.judul),
				$('.custom-file-label').html(data.file)
			}
		});
	});
});