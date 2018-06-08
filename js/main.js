$(function(){

	$("#search").on('keyup', function(){

		var search = $("#search").val();

		$.post('search.php', {

			search: search
			
		}, function (data){

			$('#result').html(data);

		});
	});


	$('#search').on('keyup', function(){

		$('#result').addClass('active');
	});

	$(document).on('click', function(){

		$('#result').removeClass('active');

	});
})