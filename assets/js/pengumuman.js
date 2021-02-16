
$(function() {
    $('.detail-toggler').on('click', function() {
        var t = $(this);
        $('#' + t.data('target')).toggle('slow');
    });

    $('#tombolTambahPengumuman').on('click', function(){
        $('#tambahPengumumanLabel').html('Tambah Pengumuman');
        $('.modal-footer button[type=submit]').html('Tambah');
    });

    $('.tombolEditPengumuman').on('click', function(){
        $('#tambahPengumumanLabel').html('Edit Pengumuman');
        $('.modal-footer button[type=submit]').html('Edit');
        
        const id = $(this).data('id');

		$.ajax({
			url: `${baseURL}admin/editPengumuman`,
			data: {
				id : id
			},
			method: 'post',
			dataType: 'json',
			success: function(data){
				$('#id').val(data.id),
				$('#headline').val(data.headline),
				$('#pengumuman').val(data.pengumuman),
				$('.custom-file-label').html(data.gambar)
			}
		});

    });
});