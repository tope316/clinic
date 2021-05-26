<style type="text/css">
.tis_mem{
height: 15px;
}
</style>


<!-- Customer List -->
<div id="customer_list" style="display:none;">      
<div class="modal-body">

<table class="table table-bordered" width="850px" id="cust_list"  >

<thead style="background-color:#0BAFCC;">
<tr>
<th class="table_head2"><center>LastAccessed</th>
<th class="table_head2"><center>Customer Code</th>
<th class="table_head2"><center>Customer Name</th>
<th class="table_head2"><center>Sub Code</th>
<th class="table_head2"><center>Currency</th>
<th class="table_head2">Action</center></th>
</tr>  
</thead>

<tbody>

<?php 
if($customer)
{
$i = 0;
foreach($customer as $customer_list)
{


$custlist[] = $customer_list;

echo '<tr class="table_member2">
<td>'.$customer_list->LastAccessed.'</td>
<td><a style="cursor:pointer; text-decoration:none;" onclick="setvalue('.$i.');">'.$customer_list->Company_Code.'</a></td>
<td width="200px">'.$customer_list->Company.'</td>
<td>'.$customer_list->subcode.'</td>
<td>'.$customer_list->doc_currency.'</td>
<td><a href="#"><i class="icon-large icon-pencil"></i></a> | <a href="#"><i class="icon-large icon-remove"></i></a></td>
</tr>';
$i++;
}
}



?>

</tbody>



</table>
</div>      
</div>



<?php 

echo "
<script type='text/javascript'>
	function setvalue(ctr){
		var obj = ".json_encode($custlist).";

		$('#quot_cust_code').val(obj[ctr].Company_Code);
		$('#quot_custname').val(obj[ctr].Company_Code);
		$('#quot_pay_term_code').val(obj[ctr].payCode);
		$('#quot_pay_term').val(obj[ctr].myDescription);
		$('#quot_currency_code').val(obj[ctr].doc_currency);
		$('#quot_currency').val(obj[ctr].Rate);
		$('#quot_tax_code').val(obj[ctr].Tax_Code);
		$('#quot_tax').val(obj[ctr].inv_rate);

		$('#customer_list').dialog('close');
	}
</script>";
 ?>
<!-- Customer List -->




<!-- Payment term -->

<div id="payterm_list" style="display:none;">      
<div class="modal-body">

<table class="table table-bordered" style="min-height:40px;" id="pay_term_list"  >

<thead style="background-color:#0BAFCC;">
<tr>
<th class="table_head"><center>LastAccessed</th>
<th class="table_head"><center>Code</th>
<th class="table_head"><center>Description</th>
<th class="table_head" width="45px">Action</center></th>
</tr>  
</thead>

<tbody>

<?php 
if($payterm)
{
$i = 0;
foreach($payterm as $payterm_list)
{


$paytermlist[] = $payterm_list;

echo '<tr class="table_member">
<td>'.$payterm_list->LastAccessed.'</td>
<td><a style="cursor:pointer; text-decoration:none;" onclick="set_payterm('.$i.');">'.$payterm_list->Code.'</a></td>
<td>'.$payterm_list->myDescription.'</td>
<td><a href="#"><i class="icon-large icon-pencil"></i></a> | <a href="#"><i class="icon-large icon-remove"></i></a></td>
</tr>';
$i++;
}
}



?>

</tbody>



</table>
</div>      
</div>

<?php 

echo "
<script type='text/javascript'>
	function set_payterm(ctr){
		var obj = ".json_encode($paytermlist).";


		$('#quot_pay_term_code').val(obj[ctr].Code);
		$('#quot_pay_term').val(obj[ctr].myDescription);
;

		$('#payterm_list').dialog('close');
	}
</script>";
 ?>


<!-- Payment term -->








<!-- Item List -->
<div id="item_listing" style="display:none;">      
<div class="modal-body">

	<div id="myCarousel" class="carousel slide">

  <!-- Carousel items -->
  <div class="carousel-inner" id="item_list_dyn">


  </div>
  <!-- Carousel nav -->

</div>


</div>   
<div style="position:absolute; top:200px; width:870px;">
  <span class="carousel-control left" href="#myCarousel" style="cursor:pointer;" data-slide="prev">&lsaquo;</span>
  <span class="carousel-control right" href="#myCarousel" style="cursor:pointer;" data-slide="next">&rsaquo;</span>
</div>  
<br><br><br><br><br>
<button class="btn btn-success action_btn" id="new_item">Add Item <i class="icon icon-plus"></i></button><br><br>
</div>



<?php 

echo "
<script type='text/javascript'>
	function setvalue(ctr){
		var obj = ".json_encode($custlist).";

		$('#quot_cust_code').val(obj[ctr].Company_Code);
		$('#quot_custname').val(obj[ctr].Company_Code);
		$('#quot_pay_term_code').val(obj[ctr].payCode);
		$('#quot_pay_term').val(obj[ctr].myDescription);
		$('#quot_currency_code').val(obj[ctr].doc_currency);
		$('#quot_currency').val(obj[ctr].Rate);
		$('#quot_tax_code').val(obj[ctr].Tax_Code);
		$('#quot_tax').val(obj[ctr].inv_rate);

		$('#customer_list').dialog('close');
	}
</script>";
 ?>
<!-- Item List -->




<!-- Item List -->
<div id="item_list_details" style="display:none;">      
<div class="modal-body" style="max-height:800px;">

<table class="table table-bordered" style="height:20px;" id="pay_term_list" >
<tr >
	<th class="table_head" style="background-color:#0BAFCC; height:15px;" id="item_select">Items</th>
	<td style="line-height:10px"><input type="text" name="item" id="id"  readonly="true" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Description</th>
	<td><input type="text" name="item" id="id" readonly="true" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Quantity</th>
	<td><input type="text" name="item" id="id" style="height:15px; width:95px;"/> <input type="text" name="item" id="id" readonly="true" style="width:95px; height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Price</th>
	<td><input type="text" name="item" id="id" readonly="true" style="height:15px; width:95px;"/> <input type="text" name="item" id="id" style="height:15px; width:95px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Amount</th>
	<td><input type="text" name="item" id="id" readonly="true" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Ref No.</th>
	<td><input type="text" name="item" id="id" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Specification</th>
	<td><input type="text" name="item" id="id" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">EDT Date</th>
	<td>

	<div class="input-append">
	<input  type='text' name='dates' id='dates' readonly="true" style="width:180px;"/>
	<span class="add-on" ><i class="icon-calendar"  style="cursor:pointer;" id="date"></i></span>
	</div>

	</td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Lead Time</th>
	<td><input type="text" name="item" id="id" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">Lot Qty</th>
	<td><input type="text" name="item" id="id" style="height:15px;"/></td>
</tr>
<tr>
	<th class="table_head" style="background-color:#0BAFCC;">C/Mark</th>
	<td><input type="text" name="item" id="id" style="height:15px;"/></td>
</tr>
</tr>  

</table>

</div>    
</div>



<?php 

echo "
<script type='text/javascript'>
	function setvalue(ctr){
		var obj = ".json_encode($custlist).";

		$('#quot_cust_code').val(obj[ctr].Company_Code);
		$('#quot_custname').val(obj[ctr].Company_Code);
		$('#quot_pay_term_code').val(obj[ctr].payCode);
		$('#quot_pay_term').val(obj[ctr].myDescription);
		$('#quot_currency_code').val(obj[ctr].doc_currency);
		$('#quot_currency').val(obj[ctr].Rate);
		$('#quot_tax_code').val(obj[ctr].Tax_Code);
		$('#quot_tax').val(obj[ctr].inv_rate);

		$('#customer_list').dialog('close');
	}
</script>";
 ?>
<!-- Item List -->









<!-- item_list_display -->

<div id="item_list_display" style="display:none;">      
<div class="modal-body">

<div id="item_listing_with_details">

</div>
</div>      
</div>

<?php 

echo "
<script type='text/javascript'>
	function set_payterm(ctr){
		var obj = ".json_encode($paytermlist).";


		$('#quot_pay_term_code').val(obj[ctr].Code);
		$('#quot_pay_term').val(obj[ctr].myDescription);
;

		$('#payterm_list').dialog('close');
	}
</script>";
 ?>


<!-- Payment term -->








<script type="text/javascript">
 $('#dates').datepicker({dateFormat: 'dd M yy'});

$('#date').click(function(){
	$("#dates").focus();
});

$('#item_select').click(function(){

              var json = JSON.stringify({ 
                          cust_code:$([name=cust_code]).val(),
                          cat_code:$([name=cat_code]).val(),
                          currency:$([name=currency]).val()
                          });

                $.ajax({
                url: '<?php echo SITE_URL;?>quotation_controller/item_listing',
                datatype: 'json',
                type: 'post',
                 data: "data=" + json,
                 success: function(data){
                       
                         	$('#item_listing_with_details').html(data);

                         	$('#item_list_display').dialog({
							open: function(event, ui) {$(this).parent().children().children('.ui-dialog-titlebar-close').show();},
							width:900,
							height:400,
							modal:true,
							show:'clip',
							hide:'clip',
							title:'Item',
							buttons:{
			
									"Cancel":{
									text:'Cancel',
									class:'btn',
									click: function () { //then cancel is press.. stuff to do..
									$(this).dialog('close');

									},//end function for cancel
									}									
							}
							}); 


                        }

                });

});


$('#new_item').live('click',function(){

$('#item_list_details').dialog({
open: function(event, ui) {$(this).parent().children().children('.ui-dialog-titlebar-close').show();},
width:500,
height:700,
modal:true,
show:'clip',
hide:'clip',
title:'Item',
buttons:{
"Cancel":{
text:'Cancel',
class:'btn',
click: function () { //then cancel is press.. stuff to do..
$(this).dialog('close');

},//end function for cancel
}
}
}); 

});





$(document).ready( function() {
        $('#cust_list').dataTable( {
				"sDom": 'T<"clear">lfrtip',
				"sPaginationType": "bootstrap",
				"bLengthChange": false,
				"bInfo": false,
				"aaSorting": [[ 0, "desc" ]],
				"aoColumns"   : [{ "bVisible": false},null,null, null, null,{"sWidth":"40px"}]
        } );
 } );



$(document).ready( function() {
        $('#pay_term_list').dataTable( {
				"sDom": 'T<"clear">lfrtip',
				"sPaginationType": "bootstrap",
				"bLengthChange": false,
				"bInfo": false,
				"aaSorting": [[ 0, "desc" ]],
				"aoColumns"   : [{ "bVisible": false },null,null, null],
        } );
 } );


</script>