
$(document).ready(function(){
	//Se quita el producto del almacén
	$(document).on("click", ".removeProduct", function(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content"); //Anti-forgery token
		var productoId = $(this).attr("id");
		var comercioId = $('input[name="model-id"]').val();
		$.ajax({
			url: '/comercios/remove_product',
			type: 'post',
			dataType: 'json',
			data: {
				__csrf : csrfToken,
				ProductoTienda : {
						idproducto : productoId, 
						idcomercio : comercioId
					}
			},
		})
		.done(function($data){
			//Creando el string con codigo html del producto que se inserta en la 
            //tabla de productos no asignado
			var html_string = "<div class='row'><div id='" + $data['id'] + "' class='btn addProduct'" +
					" data-toggle='tooltip' title='" + $data['tooltip'] + "' style='width:100%'>" +
					$data['categoria'] + " - " + $data['nombre'] + "</div></div>";
			//Se mueve gráficamente el producto de la lista de asignado a no asignado
			$('#' + productoId).remove();
			$('.tooltip').remove();
			$('.unassign-products').append(html_string);
		})
		.fail(function(){
			alert("Ajax ha fallado!");
		})
	})
	//Se agrega el producto en el almacén
	$(document).on("click", ".addProduct", function(){
		var csrfToken = $('meta[name="csrf-token"]').attr("content"); //Anti-forgery token
		var productoId = $(this).attr("id");
		var comercioId = $('input[name="model-id"]').val();
		$.ajax({
			url: 'add_product',
			type: 'post',
			dataType: 'json',
			data: {
				__csrf : csrfToken,
				ProductoTienda : {
						idproducto : productoId, 
						idcomercio : comercioId
					}
			},
		})
		.done(function($data){
			//Creando el string con codigo html del producto que se inserta en la 
            //tabla de productos no asignado
			var html_string = "<div class='row'><div id='" + $data['id'] + "' class='btn removeProduct'" +
					" data-toggle='tooltip' title='" + $data['tooltip'] + "' style='width:100%'>" +
					$data['categoria'] + " - " + $data['nombre'] + "</div></div>";
			//Se mueve gráficamente el producto de la lista de no asignado a asignado
			$('#' + productoId).remove();
			$('.tooltip').remove();
			$('.assign-products').append(html_string);
		})
		.fail(function(){
			alert("Ajax ha fallado!");
		})
	})
})
