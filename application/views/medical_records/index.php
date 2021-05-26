<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span10">
				    	
            <p>&nbsp;</p>
            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Please choose a patient to view the Medical Records</div>
              </div>
            </div>
            
            <div class='clear'></div> 
            
            <div class="span12">
            	<a href="mr_dashboard_addnew">
                	<input type="button" class="btn-primary btn" value="New Diagnosis&nbsp;&frasl;&nbsp;Finding">
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
 		$('td:eq(3)', nRow).html("<a id='id_doPreview' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/application_form_edit.png'/></a>");
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
		 document.location.href = "mr_main?ID="+ encodeURIComponent( id );
		 return false;
	});
	
</script>