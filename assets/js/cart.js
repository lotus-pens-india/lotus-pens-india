const getCartItems=()=>{$("#cart_items_div").LoadingOverlay("show");let t=localStorage.getItem("cartValues");var e={url:`${$("#base_url_input").val()}shopping_cart`,method:"POST",timeout:0,data:{cartItems:t}};$.ajax(e).done(function(t){$("#cart_items_div").LoadingOverlay("hide");let e=JSON.parse(t);if(200==e.status&&e.body.productInfo.length>0){let a=e.body.rawData;localStorage.setItem("cartValues",JSON.stringify(a));let i=createCartItemsUi(e.body.productInfo);$("#cart_items_div").empty(),$("#cart_items_div").append(i),$("#cart_items_count").text(e.body.cartItemsCount),$("#summary_price").text(e.body.cartSummaryAmt),$("#total_item_value").val(e.body.cartSummaryAmt),$("#summary_price_total").text(e.body.cartSummaryAmtWithShipping);let s=0==e.body.shppingCharges?"Free":e.body.shppingCharges;$("#shpping_price").text(s)}else localStorage.setItem("cartValues",JSON.stringify([])),$("#main_cart_page_div").empty(),$("#main_cart_page_div").append(` <div class="title-wrapper" id="empty_cart_div">
			<p class="title-headings">Shopping Cart</p>
		</div>
		<div class="row shadow-lg text-center rounded-4">
		<div class="col-12 pt-5">
			   <img src='${$("#base_url_input").val()}assets/images/empty_cart.svg' style="width:30%"/>
			</div>

			<div class="col-12 "> <h3>At the moment, your shopping cart is empty</h3></div>
		   
			<div class="col-12 pt-3 pb-3"><a href="${$("#base_url_input").val()}" class="btn btn-primary">Start Shopping Now</a></div>
		</div>`)})};$(document).ready(()=>{getCartItems()});const createCartItemsUi=t=>{let e="";if(t&&t.length>0)for(let a=0;a<t.length;a++){let i=t[a].productInformation[0],s="with_clip"==t[a].clipOption?"With Clip":"Without Clip",l=t[a].nibData[0],r=t[a].materialData[0],o=t[a].clipData[0],c=t[a].quantity,p=$("#currency_symbol").val();console.log("this is clip data",o);let d="",n="",m="";l&&(d+=`<p>Nib: ${l.name}</p>`),r&&(n+=`<p>Material: ${r.name}</p>`),o&&(m+=`${o.name}`),e+=`
            <div class="row m-1 cart-page-items" style="border-bottom: 1px solid #292929;">
                         <div class="col-3 col-lg-2 col-md-2 col-sm-3 p-0">
                             <div class="img-wrapper" style="width: 100%; display: inline-block;">
                                 <img src="${$("#base_url_input").val()}lotus_pens_admin/assets/images/product/${i.main_image}">
                             </div>
                         </div>
                         <div class="col-9 col-lg-10 col-md-10 col-sm-9 p-0">
                             <div class="w-100">
                                 <label>
                                     <h5>${i.product_name}</h5>
                                 </label>
                                 <label class="float-end">
                                     <img src="${$("#base_url_input").val()}assets/images/heart-solid.svg" style="height: 15px;width: 15px;cursor: pointer;">
                                     <img onclick="removeFromCart(${a})" src="${$("#base_url_input").val()}assets/images/trash-can-solid.svg" style="height: 15px;width: 15px;cursor: pointer;"></label>
                             </div>
                             <p>Clip: ${s},${m}</p>
                             ${d}
                             ${n}
                             <div class="w-100">
                                 <label>
                                     <h6>${p} ${t[a].finalAmount}</h6>
                                 </label>
                                 <label class="float-end">
                                     <div class="quantity">
                                         <img onclick="addQuantityToCart(${a})" src="${$("#base_url_input").val()}assets/images/square-plus-regular.svg" style="height: 20px;width: 20px;cursor: pointer;" alt="" />
                                         <input type="text" name="name" value="${c}">
                                         <img  onclick="removeQuantityToCart(${a})" src="${$("#base_url_input").val()}assets/images/square-minus-regular.svg" style="height: 20px;width: 20px;cursor: pointer;" alt="" />
                                     </div>
                             </div>

                         </div>
                     </div>
            `}return e},processToCheckout=()=>{let t=$("#is_user_login").val();if(t&&!0==t){let e=$("#coupon_code").val();""!=e?window.location.href=`checkout/${e}`:window.location.href="checkout/none"}else $("#loginModal").modal("show")},checkCouponCode=()=>{$("#cart_items_div").LoadingOverlay("show");let t=$("#coupon_code").val();if(""!=t&&"DAD20"==t||"dad20"==t){let e=$("#total_item_value").val()/100*20,a=parseInt($("#summary_price_total").text())-e,i=parseInt($("#summary_price").text())-e;$("#summary_price").text(i),$("#summary_price_total").text(a),$("#cart_items_div").LoadingOverlay("hide"),$("#coupon_message").text("Coupon Applied"),$("#checkCouponCodeBtn").prop("disabled",!0),$("#coupon_code").prop("disabled",!0)}else $("#cart_items_div").LoadingOverlay("hide"),$("#coupon_message").text("Invalid Coupon Code")},placeOrder=()=>{var t={url:`${$("#base_url_input").val()}place_order`,method:"POST"};$.ajax(t).done(function(t){let e=JSON.parse(t);if(200==e.status){let a=e.body.cart_json;localStorage.setItem("cartValues",a),getCartItems()}})};