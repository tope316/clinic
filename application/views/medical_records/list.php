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
                <div class="brand">Medical Records of <strong><?php echo $row[0]->fullname; ?></strong></div>
              </div>
            </div>
            
            <div class='clear'></div> 
            
            <div class="span12">
            	<a href="index" class="btn-primary btn">Back</a>&nbsp;
            	<a href="mr_dashboard_addnew?ID=<?php echo $reg_id; ?>">
                	<input type="button" class="btn-primary btn" value="New Diagnosis&nbsp;&frasl;&nbsp;Finding">
  				</a>
            </div>
            <div class="clear">&nbsp;</div>
        
            <table id='mr_list_dashboard' class="table table-bordered table-striped">
                <thead>
                     <tr class="table-title2" role="row">
                        <th>#</th>
                        <th>Checkup Date</th>
                        <th>Diagnosis</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
				
		</div>
    </div>
</div>

<script type='text/javascript'>
	
	$(function(){
		
		$('#mr_list_dashboard').dataTable({		
		"sPaginationType": "bootstrap",
		"bAutoWidth": false,
		"bProcessing": true,
		"bDestroy": true,
		"bRetrieve": false,
		"bDeferRender": true,
        "sAjaxSource": "get_mr_data", 
		"fnServerParams": function ( aoData ) {
		 	aoData.push( { "name": "reg_id", "value": "<?php echo $reg_id; ?>" } );
		 },
		 "aaSorting"   : [[0,"asc"]],       
        "fnRowCallback" : function(nRow, nData, index){
 		$('td:eq(3)', nRow).html("<a id='id_doPreview' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/pencil.png'/></a>&nbsp;&nbsp;<a id='do_delete' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/cross.png'/></a>");
			},
        "aoColumns": [
		  { "mDataProp": "ID" , "sTitle": "Record No.", "bSortable" : false},						  
		  { "mDataProp": "checkup_date" , "sTitle": "Checkup Date"},
		  { "mDataProp": "diagnosis" , "sTitle": "Diagnosis"},
		  { "mDataProp": "ID", "sClass": "da-icon-column", "sTitle":"Action", "bSortable" : false}
		],

		});
		
	}); 
	
	$("#mr_list_dashboard").on('click','a#id_doPreview', function(e){
		 var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		 document.location.href = "mr_edit_main?ID="+ encodeURIComponent( id );
		 return false;
	});
	
	$("#mr_list_dashboard").on('click','a#do_delete', function(e){
		// e.preventDefault();
		var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		var name = $(this).parents('tr').find('td:eq(1)').html();
		
		$("#confirmDiv").confirmModal({
			heading: 'Confirm your action',
			body: 'Are you sure you want to delete this row?',
			callback: function () {
				
				$.post('delete_mr?code='+id, function(data){
					if(data == true){
						location.reload();
					}else{
						bootbox.dialog("Cannot delete Record", [{
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