$(function(){

	$('#uploadCuponHome').click(function(){
		var formData = $('#couponDetails').serialize();
		const formDataArray = $('#couponDetails').serializeArray();
		console.log(formData,formDataArray)
		
		$.ajax({
			type: 'POST',
			url: '/add-coupon-info.php',
			data: formData,
			success: function(response){
				alert('Coupon information added successfully');
			},
			error: function(xhr, status, error){
				alert('Error: ' + error);
			}
		});
	});
});