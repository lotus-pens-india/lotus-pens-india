<?php
$this->load->view('Global/Header.php',$data);
?>
<?php
 if(isset($view_name)){
	$this->load->view($view_name,$data);
 }
?>
<?php
require_once 'Global/Footer.php';
?>


<script>
	$(document).ready(() => {
		ajaxCall('popular_products');
		ajaxCall('get_category');
	});
	const ajaxCall = (ajaxFor) => {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>" + ajaxFor,
			// data: "{empid: " + empid + "}",
			dataType: "json",
			success: (result) => {
				if (result.status == 200) {
					if (ajaxFor == 'popular_products') {
						makeProductDiv(result.body);
					}

					if (ajaxFor == "get_category") {
						makeCategoryDiv(result.body);
					}
				} else {

				}
			},
			error: (error) => {

			}
		});
	}

	const makeProductDiv = (result) => {
		let proDiv = '';
		result.forEach((value) => {
			proDiv += '<div class="col-6 col-md-4 col-lg-3 col-xl-2">' +
				'<div class="card shadow-sm border-0 mb-4">' +
				'<div class="card-body">' +
				'<button class="btn btn-sm btn-link p-0"><i class="material-icons md-18">favorite_outline</i>' +
				'</button>' +
				'<div class="badge badge-success float-right mt-1">Rs.' + value.discount + ' off</div>' +
				'<figure class="product-image"><img src="<?= base_url('lotus_pens_admin/assets/images/product/') ?>' + value.main_image + '" alt=""' +
				'class=""></figure>' +
				'<a href="product-details.html" class="text-dark mb-1 mt-2 h6 d-block">' + value.product_name + '</a>' +
				'<p class="text-secondary small mb-2">Imported Simla</p>' +
				'<h5 class="text-success font-weight-normal mb-0">' + value.unit_price + '<sup>.00</sup></h5>' +
				'<p class="text-secondary small text-mute mb-0">' + value.unit + '</p>' +
				'<button class="btn btn-default button-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">shopping_cart</i>' +
				'</button>' +
				'</div>' +
				'</div>' +
				'</div>';
		});
		$('#most_pop_div').empty();
		$('#most_pop_div').append(proDiv);
	}

	const makeCategoryDiv = (result) => {
		let proDiv = '';
		result.forEach((value) => {
			proDiv += '<div class="swiper-slide">' +
				'<div class="card shadow-sm border-0">' +
				'<div class="card-body">' +
				'<div class="row no-gutters h-100">' +
				'<img src="<?= base_url('lotus_pens_admin/assets/images/category/') ?>' + value.icon + '" alt=""' +
				'class="small-slide-right" style="max-height: 80%;margin-right: -19px;">' +
				'<div class="col-8">' +
				'<button class="btn btn-sm btn-link p-0"><i class="material-icons md-18">favorite_outline</i>' +
				'</button>' +
				'<a href="all-products.html" class="text-dark mb-1 mt-2 h6 d-block" style="margin-top: 95%!important;"><p>' + value.name + '</p></a>' +
				// '<p class="text-secondary small">Oranges, Grapefruit, Mandarins</p>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'</div>';
		});
		$('#main_category_div').empty();
		$('#main_category_div').append(proDiv);
	}

	
</script>