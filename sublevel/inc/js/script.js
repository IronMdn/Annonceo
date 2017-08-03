$( document ).ready(function() {

$('.voir-plus a').on('click', function(e) {
	e.preventDefault();
	console.log($('#categorie').val());

	$.ajax({
		url: "https://localhost/annonceo/sublevel/api.php",
		method: "GET",
		data: {
			$_GET: $('#categorie').val()
			$('#pays').val()
			$('#membre').val()
		},
		dataType: "json" // optionel
	})
	
	// .done(function( data ) {

		
	// 	})

	// .fail(function( jqXHR, textStatus ) {
	// 	alert( "Request failed: " + textStatus );
	// });





});



});