$(function(){

	$("#search").on('keyup', function(){

		$("#search_result").addClass('active');
		 var search = $('#search').val();

			$.post('ajax_search.php', {

				search: search

			}, 

					function(data) {


						$('#search_result').html(data);
					}
			)
	});

	$(document).on('click', function(){


			$("#search_result").removeClass('active');

	});
})