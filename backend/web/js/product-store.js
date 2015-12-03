
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
					 $data['nombre'] + "</div></div>";
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
					 $data['nombre'] + "</div></div>";
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


function loadElements(){
	var arreglo=JSON.parse(sessionStorage.productos);
	sessionStorage.clear();
	$('.assign-products').html('');
	$('.unassign-products').html('');
	var productostienda=arreglo[0];
	var productosagregar=arreglo[1];
	console.log(arreglo);
	for(var producto in productostienda){
			var com=productostienda[producto];			
			var html_string = "<div class='row'><div id='" + com['id'] + "' class='btn removeProduct'" +
					" data-toggle='tooltip' title='" + "' style='width:100%' name="+com['Nombre']+">"  
					+ com['Nombre'] + "</div></div>";
		$('.assign-products').append(html_string);
		}
	for(var producto in productosagregar){
			var com=productosagregar[producto];			
			var html_string = "<div class='row'><div id='" + com['id'] + "' class='btn addProduct'" +
					" data-toggle='tooltip' title='" + "' style='width:100%' name="+com['nombre']+">" +
					  com['Nombre'] + "</div></div>";
		$('.unassign-products').append(html_string);
		}
		console.log(productosagregar);
}