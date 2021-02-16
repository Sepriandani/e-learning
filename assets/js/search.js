$(function(){

	//event ketika keyword ditulis
	$('#keyword').on('keyup', function(){
		$('#container').load(`${baseURL}search/daftarmapelsearch?keyword=`+ $('#keyword').val());
		$('#containerKelas').load(`${baseURL}search/daftarkelassearch?keyword=`+ $('#keyword').val());
		$('#containerSiswa').load(`${baseURL}search/daftarsiswasearch?keyword=`+ $('#keyword').val());
		$('#containerGuru').load(`${baseURL}search/daftargurusearch?keyword=`+ $('#keyword').val());
	});
});