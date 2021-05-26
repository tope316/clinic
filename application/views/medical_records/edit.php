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
			   
		<div class="span12">

            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Update Patient Record</div>
              </div>
            </div>
            
            <?php 
				echo form_open('medical_records/mr_edit_save');
			?>
            
            	<div class="row-fluid">
                	Name:&nbsp;<input type="text" autocomplete="off" class="span8 typeahead" name="fullname" id="fullname" data-placement='bottom' data-original-title='Warning' data-content='Please specify a name' value="<?php echo $row[0]->fullname; ?>" />&nbsp;
                    Date:&nbsp;<input type="text" class="span2 datepicker" name="checkup_date" id="checkup_date" data-placement='bottom' data-original-title='Warning' data-content='Please specify a date' value="<?php echo $row[0]->checkup_date; ?>" />
                    <input type="hidden" name="reg_id" id="reg_id" value="<?php echo $row[0]->reg_id; ?>"/>
                    <input type="hidden" name="ID" id="ID" value="<?php echo $row[0]->ID; ?>"/>
                </div>
                
                <div class="row-fluid">
                	Findings&nbsp;&frasl;&nbsp;P.E.:&nbsp;<textarea name="findings" id="findings" class="span9" rows="5"><?php echo $row[0]->findings; ?></textarea>
                </div>
                
                <div class="row-fluid">
                	Diagnosis:&nbsp;<textarea name="diagnosis" id="diagnosis" class="span9" rows="5"><?php echo $row[0]->diagnosis; ?></textarea>
                </div>
                
                <div class="control-group mygroup_buttons">
				   <?php $submit = array('type' => 'submit', 'class' => 'btn-primary btn', 'value' => 'Save', 'id' =>'btn_save');?>
                   <?php echo form_submit($submit); ?>
                   <input type="button" class="btn-primary btn" id="btn_back" value="Back" onclick="window.location='mr_main?ID=<?php echo $row[0]->reg_id; ?>';"></input>
                   <input type="reset" class="btn-primary btn" id="btn_clear" value="Clear"></input>
                   <!--<a href="mr_print?ID=<?php echo $row[0]->ID; ?>" target="_blank" class="btn-primary btn">Print</a>-->
                   <input type="button" class="btn-primary btn" id="btn_print" value="Print" onclick="printme(<?php echo $row[0]->ID; ?>);"></input>
                </div><!--/. end button Group -->
            
			<?php echo form_close(); ?>
            
            <hr />
            <div class="span12">
                <input type="button" class="btn-primary btn" value="New Treatment" data-toggle="modal" data-target="#addModal" onclick="hideditmodal();">
            </div>
            <div class="clear">&nbsp;</div>
        
            <table id='mydashboard' class="table table-bordered table-striped">
                <thead>
                     <tr class="table-title2" role="row">
                        <th>#</th>
                        <th>Generic</th>
                        <th>Brand</th>
                        <th>Dosage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
				
		</div>
    </div>
</div>

<script type='text/javascript'>

$(function() {
	$('.datepicker').datepicker();
	
	$('#btn_save').click(function(){
			
		var fullname = $('#fullname').val();
		var checkup_date = $('#checkup_date').val();
		
		if(fullname == ""){	
			$('#fullname').popover('show');
			$('#fullname').focus();
			return false;
		} else if(checkup_date == ""){	
			$('#checkup_date').popover('show');
			return false;
		} else{
			return true;
		}
		
	});
	
	var substringMatcher = function(strs) {
	  return function findMatches(q, cb) {
		var matches, substringRegex;
		// an array that will be populated with substring matches
		matches = [];
		// regex used to determine if a string contains the substring `q`
		substrRegex = new RegExp(q, 'i');
		// iterate through the pool of strings and for any string that
		// contains the substring `q`, add it to the `matches` array
		$.each(strs, function(i, str) {
		  if (substrRegex.test(str['value'])) {
			// the typeahead jQuery plugin expects suggestions to a
			// JavaScript object, refer to typeahead docs for more info
			matches.push(str);
		  }
		});
		cb(matches);
	  };
	};
		
	var patients = [
		<?php
			$is_first = true;
			foreach($patients as $patient) {
				if ($is_first) {
					echo '{"value": '.'"'.$patient->fullname.'", ' . '"id": '.'"'.$patient->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$patient->fullname.'", ' . '"id": '.'"'.$patient->ID.'"}';
			}
		?>
	];
	
	$('.typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'patients',
	  displayKey: 'value',
	  source: substringMatcher(patients)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=reg_id]').val(datum.id);
	});
	
});

var randomnumber;
function myrandom_num() {
  var currentDate = new Date();
  var day = currentDate.getDate();
  var month = currentDate.getMonth();
  var year = currentDate.getFullYear();
  
  var currentTime = new Date();
  var hours = currentTime.getHours();
  var minutes = currentTime.getMinutes();
  var seconds = currentTime.getSeconds();
  var mseconds = currentTime.getMilliseconds();
  
  var x = day+''+month+''+year+'-'+hours+''+minutes+''+seconds+''+mseconds;
  
  return x;
}

function printme(mykey) {
	randomnumber = myrandom_num();
	
    var reportFile = 'rx.rpt'; 
	var serviceExe = '<?php echo MAIN_URL.'service.exe/'; ?>';
	var serviceParam = 'report?session='+randomnumber+'&promptex-mr_id='+mykey;
		
	mylink = serviceExe+serviceParam+'&report='+reportFile+'&PromptOnRefresh=0&init=actx:connect';
	//alert(mylink);
	window.open(mylink,"","channelmode,scrollbars");
}

function hideditmodal() {
	$("#editModal").hide();
	$("#addModal").show();
	
	// Reset modal fields to blank
	$("#xgeneric_id").val(0);
	$("#xgeneric_desc").val('');
	$("#xbrand_id").val(0);
	$("#xbrand_desc").val('');
	$("#xprep_id").val(0);
	$("#xprep_desc").val('');
	$("#xbottle_id").val(0);
	$("#xbottle_desc").val('');
	$("#xtablet_id").val(0);
	$("#xtablet_desc").val('');
	$("#xcapsule_id").val(0);
	$("#xcapsule_desc").val('');
	$("#xdosage_id").val(0);
	$("#xdosage_desc").val('');
	$("#xfreq_id").val(0);
	$("#xfreq_desc").val('');
	$("#xduration_id").val(0);
	$("#xduration_desc").val('');
}

</script>


<script type='text/javascript'>
	
	$(function(){
		
		$('#mydashboard').dataTable({		
		"sPaginationType": "bootstrap",
		"bAutoWidth": false,
		"bProcessing": true,
		"bDestroy": true,
		"bRetrieve": false,
		"bDeferRender": true,
        "sAjaxSource": "get_treatment?ID=<?php echo $row[0]->ID; ?>", 
		 "aaSorting"   : [[0,"asc"]],       
        "fnRowCallback" : function(nRow, nData, index){
 		$('td:eq(4)', nRow).html("<a id='id_doPreview' href='#' data-toggle='modal' data-target='#editModal'><img src='<?php echo PUBLIC_URL; ?>/img/pencil.png'/></a>&nbsp;&nbsp;<a id='do_delete' href='#'><img src='<?php echo PUBLIC_URL; ?>/img/cross.png'/></a>");
			},
        "aoColumns": [
		  { "mDataProp": "ID" , "sTitle": "ID No.", "bSortable" : false},
		  { "mDataProp": "generic_desc" , "sTitle": "Generic"},
		  { "mDataProp": "brand_desc" , "sTitle": "Brand"},
		  { "mDataProp": "dosage_desc" , "sTitle": "Dosage"},
		  { "mDataProp": "ID", "sClass": "da-icon-column", "sTitle":"Action", "bSortable" : false}
		],

		});
		
		$("#addModal").hide();
		$("#editModal").hide();
		
	}); 
	
	$("#mydashboard").on('click','a#id_doPreview', function(e){
		$("#addModal").hide();
		$("#editModal").show();
		var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		//document.location.href = "edit_main?ID="+ encodeURIComponent( id );
		$.post('get_mr_treatment?code='+id, function(data){
			var response = $.parseJSON(data);
			var res = response[0];
			var myid = res['ID'];
			var mr_id = res['mr_id'];
			var generic_id = res['generic_id'];
			var generic_desc = res['generic_desc'];
			var brand_id = res['brand_id'];
			var brand_desc = res['brand_desc'];
			var prep_id = res['prep_id'];
			var prep_desc = res['prep_desc'];
			var bottle_id = res['bottle_id'];
			var bottle_desc = res['bottle_desc'];
			var tablet_id = res['tablet_id'];
			var tablet_desc = res['tablet_desc'];
			var capsule_id = res['capsule_id'];
			var capsule_desc = res['capsule_desc'];
			var dosage_id = res['dosage_id'];
			var dosage_desc = res['dosage_desc'];
			var freq_id = res['freq_id'];
			var freq_desc = res['freq_desc'];
			var dur_id = res['dur_id'];
			var dur_desc = res['dur_desc'];
			if(data){
				$("#editModal").modal("toggle");
				$("#treatment_id").val(myid);
				$("#mr_id").val(mr_id);
				$("#xgeneric_id").val(generic_id);
				$("#xgeneric_desc").val(generic_desc);
				$("#xbrand_id").val(brand_id);
				$("#xbrand_desc").val(brand_desc);
				$("#xprep_id").val(prep_id);
				$("#xprep_desc").val(prep_desc);
				$("#xbottle_id").val(bottle_id);
				$("#xbottle_desc").val(bottle_desc);
				$("#xtablet_id").val(tablet_id);
				$("#xtablet_desc").val(tablet_desc);
				$("#xcapsule_id").val(capsule_id);
				$("#xcapsule_desc").val(capsule_desc);
				$("#xdosage_id").val(dosage_id);
				$("#xdosage_desc").val(dosage_desc);
				$("#xfreq_id").val(freq_id);
				$("#xfreq_desc").val(freq_desc);
				$("#xduration_id").val(dur_id);
				$("#xduration_desc").val(dur_desc);
			}else{
				bootbox.dialog("Cannot fetch Record", [{
				"label" : "OK!",
				"class" : "btn", // or primary, or danger, or nothing at all
				"callback": function() {
				console.log("great success");
				}
				}], {"header" : "Warning"});
			}
		
		});
		return false;
	});
	
	$("#mydashboard").on('click','a#do_delete', function(e){
		var id = $(this).parents( 'tr' ).find('td:eq(0)').html();
		
		$("#confirmDiv").confirmModal({
			heading: 'Confirm your action',
			body: 'Are you sure you want to delete this row?',
			callback: function () {
				
				$.post('delete_treatment?code='+id, function(data){
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