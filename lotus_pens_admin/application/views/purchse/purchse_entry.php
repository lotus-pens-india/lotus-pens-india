<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Purchase Entry</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Purchase</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Purchase Entry</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <a href="<?php echo base_url();?>purchse/purchse_list"> 
         <button type="button" class="btn btn-primary waves-effect waves-light m-1">purchase list</button>
        </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Purchase entry</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>purchse/add_purchase_entry_data">
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
                             
						  <div class="col-md-4">
                            <label>Supplier Name *</label>
                               <select class="form-control single-select"  name="supplier_id" id="supplier_id" onchange="getsupplier();">
                				  <option value="">Select supplier</option>
                				  <?php foreach($all_supplier as $supplier) { ?>
                					   <option value="<?php echo $supplier->supplier_id ?>"><?php echo $supplier->company_name ?></option>
                				  <?php } ?>
                				  </select>
                				<div class="form_error_msg supplier_idError"></div>
                            </div>
						  <div class="col-md-4">
							  <label>Mobile no</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile no" readonly>
								<div class="form_error_msg mobile_noError"></div>
								<label id="existmobile_no" style="color:green;font-size:13px;"></label>
							</div> 
							<div class="col-md-4">
							  <label>Email id</label>
                                <input type="text" class="form-control" name="email_id" id="email_id" placeholder="Email id" readonly>
							</div>
							
                          	
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
							  <label>Address</label>
                                <textarea type="text" class="form-control" name="address" id="address" placeholder="Address" readonly></textarea>
							</div>
                        </div>    

   
                        <hr>
                        <div class="form-group row mb-2">
                                  
                                   	<div class="col-12" id="docAttachDivVideo">
    								   <table id="video_tbl" class="table table-hover table-bordered table-striped" >
    										<thead>
    										<tr>
    											
    											<td>Product Name</td>
    											<td>Unit</td>
    											<td>Price</td>
    											<td>qty</td>
    											<td>Bag amt</td>
    											<td>Discount</td>
    											<td>Dis amt</td>
    											<td>Total amt</td>
    											<td>Delete</td>
    										</tr>
    										</thead>
    										<tbody>

    
    										</tbody>
    								    </table><br>
            
    						         </div><br>
   
                                        <div class="col-12">
                                            <input type="hidden" name="photo_cnt" id="photo_cnt" value="0" />
                                            <label class="label-control subHeads"><a href="javascript:addDocDetail1('video_tbl')" id="add_more" style="color:#000">Add New <i class="fa fa-plus"></i></a></label>
    										
                                        </div>
                   
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="label-control col-md-2"> Total Purchse Amount  </label>
                					   <div class="col-md-2">
                					       <input type="text" name="total_amount" id="totalbagamt" class="form-control" placeholder="Total Purchse Amount" style="background-color:#eee" readonly>
                					   </div>
                					 <label class="label-control col-md-2"> Total  Discount  </label>
                					   <div class="col-md-2">
                					       <input type="text" name="total_discount" id="totalbag" class="form-control" placeholder="Total  Discount" style="background-color:#eee" readonly>
                					   </div>
                					   <label class="label-control col-md-2">Grand Purchse Amount  </label>
                					<div class="col-md-2">
                						<input type="text" name="grand_total_amount" id="totalamount" class="form-control" placeholder="Grand Purchse Amount" style="background-color:#eee" readonly>
                						
                					</div>
                					   
                				</div>

                    </section>
                   
                    
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Submit</button>
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
				$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data add!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
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
	
  $(document).on('change','#product_id1',function () {
  $('#unit1').empty();
	if($(this).val() != 'none')
	{
		var product_id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>sales/get_unit',
			data: { product_id: product_id },
			dataType: 'json',
			success: function( json ) {
				$('#unit1').append($('<option>').text("Select Unit"));
				$.each(json, function(key, value) {
					$('#unit1')
						.append($("<option></option>")
							.attr("value",value.id)
							.text(value.title));
				});
			}
		})
	}
	else
	{
		$("#unit1").empty();
	}
});

</script>

<script type="text/javascript">
		
function getproductdetails()
{
    var unit=$("#unit1").val();
	//alert(iname);
     $.ajax({
    type:"post",  
        data: {
               unit:unit
              },
    url:"<?php echo base_url();?>sales/getproductdetails", 
    success:function(response)
    {
		//alert(response);

    		var x=response.split("#");
    		document.getElementById('price1').value=x[0];
    		document.getElementById('discount1').value=x[1];
			
    },
});

}


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
        cell1.appendChild(element1);
    	
    	
    	
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
        var element3 = document.createElement('select');
        element3.type='text';
        element3.name='unit[]';
        element3.className ='form-control';
        element3.id='unit'+  rowCount;

    	var z = document.createElement("option");
        $('#product_id'+rowCount).change(function() {
    		//alert('kkk');
            var product_id = $('#product_id'+rowCount+ ' option:selected').val();
    	    element3.options.add( new Option("Select unit","",  true) );
            $.ajax({
                type: 'POST',
		    	url: '<?php echo base_url();?>sales/get_unit_details',
			    data: { product_id: product_id },
                datatype: 'HTML',
                success: function (result) 
                {
    				//alert(result);
                    $('#unit'+rowCount).html(result);
                },
            });
        });
        
         $(document).ready(function() 
         {
				$("#unit"+rowCount).select2();
				
	    });

        cell2.appendChild(element3);

        var cell3=row.insertCell(2);
        var element4 = document.createElement('input');
        element4.type='text';
        element4.name='unit_price[]';
        element4.className ='form-control';
        element4.placeholder ='price';
        element4.id='price'+  rowCount;
                
        cell3.appendChild(element4);
        
        var cell4=row.insertCell(3);
        var element5 = document.createElement('input');
        element5.type='text';
        element5.name='qty[]';
        element5.className ='form-control';
        element5.placeholder ='qty';
        element5.id='qty'+  rowCount;
        element5.onkeyup = function() 
		{
                totalise(rowCount);
				my();
				my1();
				my2();
        };
        cell4.appendChild(element5);
        
        
        var cell5=row.insertCell(4);
        var element6 = document.createElement('input');
        element6.type='text';
        element6.name='total_amt[]';
        element6.className ='form-control';
        element6.placeholder ='total amount';
        element6.style='background-color:#eee';
        element6.id='total'+  rowCount;
        cell5.appendChild(element6);
        
        
        
        var cell6=row.insertCell(5);
        var element7 = document.createElement('input');
        element7.type='text';
        element7.name='discount[]';
        element7.className ='form-control';
        element7.placeholder ='discount';
        element7.id='discount'+  rowCount;
        $('#unit'+rowCount).change(function(){
			//alert('kkk');
            var unit = $('#unit'+rowCount+' option:selected').val();
			//alert(hsn_code);
            $.ajax({
				type:"post",  
					data: {
					unit:unit
			  
			 },
				url:"<?php echo base_url();?>sales/getproductdetails",         
				success:function(r1)
				{
			   //alert(r1);
				var x=r1.split("#");
				
				document.getElementById("discount"+rowCount).value=x[1];

				},
			 });
        });
        
        element7.onkeyup = function() 
		{
                totalise(rowCount);
				my();
				my1();
				my2();
        };
        cell6.appendChild(element7);
        
        
        var cell7=row.insertCell(6);
        var element8 = document.createElement('input');
        element8.type='text';
        element8.name='bag_dis[]';
        element8.className ='form-control';
        element8.placeholder ='Discount amt';
        element8.style='background-color:#eee';
        element8.id='total1'+  rowCount;
        cell7.appendChild(element8);
        
        
        var cell8=row.insertCell(7);
        var element9 = document.createElement('input');
        element9.type='text';
        element9.name='total_amt[]';
        element9.className ='form-control';
        element9.placeholder ='Total amt';
        element9.style='background-color:#eee';
        element9.id='total2'+  rowCount;
        cell8.appendChild(element9);
        
        
    	
        var cell9=row.insertCell(8);
        var element10 = document.createElement("input");
        element10.type = "checkbox";
        element10.name='chkbox[]';
        element10.id='chkbox'+  rowCount;
        element10.onchange = function()
        {
            removeDoc1(tableId);
        }
        cell9.appendChild(element10);
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
                var chkbox = row.cells[8].childNodes[1];
                var chkbox1 = row.cells[8].childNodes[0];
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
    
    
     <script type='text/javascript'>
   
    function totalise(id)
	{  
		var q = 'qty'+id;
		var p = 'price'+id;
		var d = 'discount'+id;
		var tot = 'total'+id;
		var twd = 'total1'+id;
		var twd1 = 'total2'+id;

		var qtd      = document.getElementById(q).value;
		var per      = document.getElementById(p).value;
		var dis      = document.getElementById(d).value;

        var total_amt = parseFloat(per)*parseFloat(qtd);
        document.getElementById(tot).value = total_amt.toFixed(2);
        
        var dis_amt = (parseFloat(total_amt * dis)/100) ;
        document.getElementById(twd).value = dis_amt.toFixed(2);
   
	    var tot_amt =  total_amt - dis_amt;
	    document.getElementById(twd1).value = tot_amt.toFixed(2);	
	//rate_cal();	
    }

	
    
	function my()
	{
		
		try {
		var table = document.getElementById('video_tbl');
		var Count = table.rows.length;	
			var totval=0,tot_final_amt=0;
			for(var i=1; i<Count; i++) 
			{			
				var twd1 = 'total2'+i;	
							
					if(document.getElementById(twd1).value.length == 0)
						var totval = 0;
					else
						var totval = document.getElementById(twd1).value;
					
					tot_final_amt +=  parseFloat(totval);													
					document.getElementById('totalamount').value = tot_final_amt.toFixed(2);
				
					
			}		
		}
		catch(e) {
			//alert(e); 
		}	
	}
	
	function my1()
	{
		
		try {
		var table = document.getElementById('video_tbl');
		var Count = table.rows.length;	
			var totval=0,tot_final_amt=0;
			for(var i=1; i<Count; i++) 
			{			
				var twd = 'total1'+i;	
							
					if(document.getElementById(twd).value.length == 0)
						var totval = 0;
					else
						var totval = document.getElementById(twd).value;
					
					tot_final_amt +=  parseFloat(totval);													
					document.getElementById('totalbag').value = tot_final_amt.toFixed(2);
				
					
			}		
		}
		catch(e) {
			//alert(e); 
		}	
	}
	
	
		function my2()
	{
		
		try {
		var table = document.getElementById('video_tbl');
		var Count = table.rows.length;	
			var totval=0,tot_final_amt=0;
			for(var i=1; i<Count; i++) 
			{			
				var tot = 'total'+i;	
							
					if(document.getElementById(tot).value.length == 0)
						var totval = 0;
					else
						var totval = document.getElementById(tot).value;
					
					tot_final_amt +=  parseFloat(totval);													
					document.getElementById('totalbagamt').value = tot_final_amt.toFixed(2);
				
					
			}		
		}
		catch(e) {
			//alert(e); 
		}	
	}
	</script>
	
	<script>

$(document).on('change','#zone_id',function () {
  $('#area_id').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_area_by_zone_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#area_id').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#area_id')
						.append($("<option></option>")
							.attr("value",value.area_id)
							.text(value.area_name));
				});
			}
		})
	}
	else
	{
		$("#area_id").empty();
	}
});
</script>
<script type="text/javascript">
		
function getsupplier()
{
	
	
    var supplier_id=$("#supplier_id").val();
	//alert(iname);
     $.ajax({
    type:"post",  
        data: {
               supplier_id:supplier_id
              },
    url:"<?php echo base_url();?>purchse/get_supplier", 
    success:function(response)
    {

    		var x=response.split("#");
    		document.getElementById('mobile_no').value=x[0];
    		document.getElementById('email_id').value=x[1];
    		document.getElementById('address').value=x[2];
			
    },
});

}


</script>
