<!---for delete --->
<div id="confirmDiv" class="modal hide fade">
	<div id="confirmContainer" class="modal">
		<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3></h3>
		</div>
	<div class="modal-body">Hello world!</div>
    <!-- dialog buttons -->
    <div class="modal-footer">
	<a id="confirmYesBtn" class="btn btn-primary" href="#">Confirm</a>
	<a class="btn" data-dismiss="modal" href="#">Close</a>
	</div>
 </div>
</div>

<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span10">
				    	
            <p>&nbsp;</p>
            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Registration - Listing</div>
              </div>
            </div>
            
            <div class='clear'></div> 
            
            <div class="span12">
            	<a href="registration_dashboard_addnew">
                	<input type="button" class="btn-primary btn" value="New Registration">
  				</a>
            </div>
            <div class="clear">&nbsp;</div>
        
            <table id='registration_dashboard' class="table table-bordered table-striped">
                <thead>
                     <tr class="table-title2" role="row">
                        <th>#</th>
                        <th>Name</th>
                        <th>Birth Date</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
				
		</div>
    </div>
</div>

<script type='text/javascript'>
	
	$(function(){
		
		$('#registration_dashboard').dataTable({		
		"sPaginationType": "bootstrap",
		"bAutoWidth": false,
		"bProcessing": true,
		"bDestroy": true,
		"bRetrieve": false,
		"bDeferRender": true,
        "sAjaxSource": "get_registration_data", 
		//"aaSorting"   : [[1,"desc"]],
		 "aaSorting"   : [[0,"asc"]],       
        "fnRowCallback" : function(nRow, nData, index){
 		$('td:eq(3)', nRow).html("<a id='id_doPreview' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/pencil.png'/></a>&nbsp;&nbsp;<a id='do_delete' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/cross.png'/></a>");
			},
        "aoColumns": [
		  { "mDataProp": "ID" , "sTitle": "ID No.", "bSortable" : false},
		  { "mDataProp": "fullname" , "sTitle": "Name"},						  
		  { "mDataProp": "birthdate" , "sTitle": "Date of Birth"},
		  { "mDataProp": "ID", "sClass": "da-icon-column", "sTitle":"Action", "bSortable" : false}
		],

		});
		
	}); 
	
	$("#registration_dashboard").on('click','a#id_doPreview', function(e){
		 var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		 document.location.href = "registration_edit_main?ID="+ encodeURIComponent( id );
		 return false;
	});
	
	$("#registration_dashboard").on('click','a#do_delete', function(e){
		// e.preventDefault();
		var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		var name = $(this).parents('tr').find('td:eq(1)').html();
		
		$("#confirmDiv").confirmModal({
			heading: 'Confirm your action',
			body: 'Are you sure you want to delete this row?',
			callback: function () {
				
				$.post('delete_registration?code='+id, function(data){
					if(data == true){
						location.reload();
					}else{
						bootbox.dialog("Cannot delete Registration", [{
						"label" : "OK!",
						"class" : "btn", // or primary, or danger, or nothing at all
						"callback": function() {
						console.log("great success");
						}
						}], {"header" : "Warning"});
					}
			
				});
		   
			}
		   });

		return false;
		 
	});
	
</script>