
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Update offer</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Update offer</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <a href="<?php echo base_url();?>product/offer"> 
         <button type="button" class="btn btn-primary waves-effect waves-light m-1">Offer list</button>
        </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Update offer</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>product/update_offer_data" enctype="multipart/form-data">
                <div id="wizard-vertical1">
                    
                    <section>
					  <h4>General</h4>
                        <div class="form-group row">
						  <div class="col-md-6">
                            <label>Notification Title *</label>
                            <input class="form-control" name="title" value="<?php echo $offer->title; ?>" type="text">
							<div class="form_error_msg titleError"></div>
						  </div>
						  <div class="col-md-6">
							  <label>Notification Message *</label>
                                <input type="text" class="form-control" name="description" value="<?php echo $offer->description; ?>" placeholder="">
								<div class="form_error_msg descriptionError"></div>
							</div>
                          
						   	
                        </div>


                    </section>
                    <section>
                        <div class="form-group row">
						 <div class="col-md-4">
						   <label>Offer Image</label>
                           <div class="uploadOuter">
						      <input type="file"   class="form-control" name="image"  />
                             <?php if ($offer->image != '') { ?>
                                    <a href="<?php echo base_url('aassets/images/offer/'.$offer->image . '') ?>" download>
                                        <img src="<?php echo base_url('assets/images/offer/'.$offer->image . '') ?>" alt="Hospital Image" class="images">
                                    </a>
                                <?php } ?>
                                <input type="hidden" class="form-control"  name="old_image" value='<?= ($offer->image); ?>'>
							  <div class="form_error_msg imageError"></div>
							</div>
			
						   </div>
						   
                        </div>
		
                    </section>
              
                    <section>
                    <hr> 
                                <div class="form-group row mb-2">
                                  <div class="col-12" id="docAttachDivVideo">
    								   <table id="video_tbl" class="table table-hover table-bordered table-striped" >
    										<thead>
    										<tr>
    											
    											<td>Product</td>
    											<td><img src="<?php echo base_url();?>assets/images/delete.png" alt="" style="width: 22px;height: 20px;"></td>
    										</tr>
    										</thead>
    										<tbody>
    										    
    										     <?php
                                                     $CI =& get_instance();
                                                     $CI->load->model('Product_model');
                                                     $result = $CI->product_model->getproduct_offer_list($offer->offer_id);
                                               
                                                     $k=0;
                                                      foreach($result as $rs)
									                  {
									                      $k++;
														  $pid                   = $rs->id;
														  $product_name          = $rs->product_name;
														  $product_id            = $rs->product_id;
												
                                                   ?> 
    										<tr>
    											<td>
                                                           	<select class="form-control single-select" name="product_id[]" id="product_id<?php echo $k;  ?>">
                                            				   <option value="<?php echo $product_id ?>"><?php echo $product_name ?></option>
                                            					 <?php foreach($all_product as $p) { ?>
                                            						  <option value="<?php echo $p->product_id ?>"><?php echo $p->product_name ?></option>
                                            					 <?php } ?>
                                            				  </select>
                                                           <input type="hidden" id="fid[]<?php echo $k; ?> "value="<?php echo $pid;?>" name="fid[]">
                                                       </td>
    											
    										
    											<td>
    												<a style="cursor:pointer;" id="<?php echo $pid;?>"	class="tip-top delete">

													  <button type="button" class="btn btn-danger btn-xs">

													  Delete</button>
													 
													</a>
    											</td>
    										</tr>
                                           <?php } ?>
    										</tbody>
    								    </table>
            
    						         </div>
                                      <br>
                                        <div class="col-12" style="margin-top:10px;">
                                            <input type="hidden" name="photo_cnt" id="photo_cnt" value="0" />
                                            <label class="label-control subHeads"><a href="javascript:addDocDetail1('video_tbl')" id="add_more" style="color:#000;font-size: 16px;">Add New <i class="fa fa-plus"></i></a></label>
    										
                                        </div> 
                    
                                
                                </div>
                    </section>


                    
                     <input type="hidden" class="form-control" name="offer_id" value="<?= ($offer->offer_id); ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Update</button>
                </div> <!-- End #wizard-vertical -->
				<br>
				<div class="success_message"></div>
				</form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->

<script type="text/javascript">
	$(function(){
		$('#add_product').ajaxForm({
			beforeSend : function(){
				$('.form_error_msg').html('');
				$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
			},
			complete : function (response) {
				var temp = JSON.parse(response.responseText);
				if(temp.status == 'success'){
					$('.success_message').show().html(temp.message);
					window.location.href = temp.redirect;
				}else if(temp.status == 'error'){
					$('.success_message').html('');
					$.each(temp.errors, function (key, val) {
						$('.'+key).html(val);
					})
				}
			}
		});
	});
	
	
	$(".delete").click(function(){

		if(confirm("Are you sure you want to delete this?"))

		{

			$(".success_message").html("");

			var element = $(this);

			var delete_id = element.attr("id");

			// var profile_image = element.attr("profile_image");

			// var data = 'delete_id=' + delete_id + '&profile_image=' + profile_image;
			var data = 'delete_id=' + delete_id;
			$.ajax({

			   type: "POST",

			   url: "<?php echo base_url();?>product/delete_offer_on_product",

			   data: data,

			   success: function(data)
			   {

				  window.location = "<?php echo base_url();?>product/update_offer?offer_id=<?php echo $offer->offer_id ?>";		   

			 }

			});

		}

		return false;

		

	});

</script>

<script type="text/javascript">
    function addDocDetail1(tableId)
    {
        var table =document.getElementById(tableId);
        var rowCount = table.rows.length;
        var row=table.insertRow(rowCount);
    	
    	
        var cell1=row.insertCell(0);
        var element1 = document.createElement('select');
        element1.type='text';
        element1.name='product_id[]';
        element1.className ='form-control';
        element1.id='product_id'+  rowCount;
        element1.onClick= function() {
        buttonClick(rowCount);
        };
        var element2 = document.createElement('input');

		element2.type='hidden';

        element2.name='fid[]';

       	element2.id='fid'+  rowCount;
        cell1.appendChild(element1);
   	    cell1.appendChild(element2);
    	
    	
    	
    	var z = document.createElement("option");
      
        element1.options.add( new Option("Select product","",  true) );
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>sales/get_product',
            success: function(res)
            {
    			//alert(res);
                var obj = JSON.parse(res);
                $.each(obj.result,function(i,item)
                {
                    var product_id = obj.result[i].product_id;
                    var val = obj.result[i].product_name;
                    if(val  !='')
                    {
                    val.value =  obj.result[i].product_name;
                    element1.options.add( new Option(val,product_id) );
                    }
                   
                });
            }
        });
        $(document).ready(function() {
				$("#product_id"+rowCount).select2();
				
	    });

 
        var cell2=row.insertCell(1);
        var element3 = document.createElement("input");
        element3.type = "checkbox";
        element3.name='chkbox[]';
        element3.id='chkbox'+  rowCount;
        element3.onchange = function()
        {
            removeDoc1(tableId);
        }
        cell2.appendChild(element3);
        hideDocDiv1(tableId);
    }
    
    function hideDocDiv1(tableId)
    {
        try{
            var table = document.getElementById(tableId);
            var rowCount = table.rows.length;
            var cnt = rowCount-1;
            if(rowCount==1)
                $("#docAttachDiv").hide();
            else
                $("#docAttachDiv").show();
        }catch(e){ alert(e); }
        $("#photo_cnt").val(cnt);
    }
    
    function removeDoc1(tableId)
    {
        //alert(tableId);
        try {
            var table = document.getElementById(tableId);
    
            var rowCount = table.rows.length;
            var cnt = rowCount-1;
            //alert(cnt);
            for(var i=0; i<rowCount; i++)
            {
                var row = table.rows[i];
                //alert(row);
                var chkbox = row.cells[1].childNodes[1];
                var chkbox1 = row.cells[1].childNodes[0];
                //alert(chkbox);
                if(null != chkbox && true == chkbox.checked || null != chkbox1 && true == chkbox1.checked) {
                    //alert('hi');
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }                  
        }catch(e) { alert(e); }
    	
    }
    </script>

