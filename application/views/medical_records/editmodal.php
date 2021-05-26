<!-- Edit Modal -->
<div id="editModal" class="modal fade kmod" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Treatment</h4>
      </div>
      <div class="modal-body">
      	<p>Generic:&nbsp;<input type="text" autocomplete="off" class="span4 generic_typeahead" name="xgeneric_desc" id="xgeneric_desc" data-placement='bottom' data-original-title='Warning' data-content='Please specify a Generic Name' /><input type="hidden" name="xgeneric_id" id="xgeneric_id"/>&nbsp;</p>
        <p>Brand:&nbsp;<input type="text" autocomplete="off" class="span4 brand_typeahead" name="xbrand_desc" id="xbrand_desc" /><input type="hidden" name="xbrand_id" id="xbrand_id"/>&nbsp;</p>
        <p>Preparation:&nbsp;<input type="text" autocomplete="off" class="span4 preparation_typeahead" name="xprep_desc" id="xprep_desc" /><input type="hidden" name="xprep_id" id="xprep_id"/>&nbsp;</p>
        <p>Bottle:&nbsp;<input type="text" autocomplete="off" class="span4 bottle_typeahead" name="xbottle_desc" id="xbottle_desc" /><input type="hidden" name="xbottle_id" id="xbottle_id"/>&nbsp;</p>
        <p>Tablet:&nbsp;<input type="text" autocomplete="off" class="span4 tablet_typeahead" name="xtablet_desc" id="xtablet_desc" /><input type="hidden" name="xtablet_id" id="xtablet_id"/>&nbsp;</p>
        <p>Capsule:&nbsp;<input type="text" autocomplete="off" class="span4 capsule_typeahead" name="xcapsule_desc" id="xcapsule_desc" /><input type="hidden" name="xcapsule_id" id="xcapsule_id"/>&nbsp;</p>
        <p>Dosage:&nbsp;<input type="text" autocomplete="off" class="span4 dosage_typeahead" name="xdosage_desc" id="xdosage_desc" /><input type="hidden" name="xdosage_id" id="xdosage_id"/>&nbsp;</p>
        <p>Frequency:&nbsp;<input type="text" autocomplete="off" class="span4 frequency_typeahead" name="xfreq_desc" id="xfreq_desc" /><input type="hidden" name="xfreq_id" id="xfreq_id"/>&nbsp;</p>
        <p>Duration:&nbsp;<input type="text" autocomplete="off" class="span4 duration_typeahead" name="xduration_desc" id="xduration_desc" /><input type="hidden" name="xduration_id" id="xduration_id"/>&nbsp;</p>
      	<br/><br/>
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="treatment_id" id="treatment_id"/>
        <input type="hidden" name="mr_id" id="mr_id"/>
      	<input type="button" class="btn-primary btn" id="editbtn" value="Save" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type='text/javascript'>

$(function() {
	
	// Saving - Edit Mode
	$("#editbtn").click(function(){
		var xtreatment_id = $("#treatment_id").val();
		var xmr_id = $("#mr_id").val();
		var xgeneric_desc = $("#xgeneric_desc").val();
		var xgeneric_id = $("#xgeneric_id").val();
		var xbrand_desc = $("#xbrand_desc").val();
		var xbrand_id = $("#xbrand_id").val();
		var xprep_desc = $("#xprep_desc").val();
		var xprep_id = $("#xprep_id").val();
		var xbottle_desc = $("#xbottle_desc").val();
		var xbottle_id = $("#xbottle_id").val();
		var xtablet_desc = $("#xtablet_desc").val();
		var xtablet_id = $("#xtablet_id").val();
		var xcapsule_desc = $("#xcapsule_desc").val();
		var xcapsule_id = $("#xcapsule_id").val();
		var xdosage_desc = $("#xdosage_desc").val();
		var xdosage_id = $("#xdosage_id").val();
		var xfreq_desc = $("#xfreq_desc").val();
		var xfreq_id = $("#xfreq_id").val();
		var xduration_desc = $("#xduration_desc").val();
		var xduration_id = $("#xduration_id").val();
		
		if(xgeneric_desc == ""){	
			$('#xgeneric_desc').popover('show');
			$('#xgeneric_desc').focus();
			return false;
		} else {
			
			$.post('edit_treatment', 
				{
					treatment_id: xtreatment_id, mr_id: xmr_id
					, generic_desc: xgeneric_desc, generic_id: xgeneric_id
					, brand_desc: xbrand_desc, brand_id: xbrand_id
					, prep_desc: xprep_desc, prep_id: xbrand_id
					, bottle_desc: xbottle_desc, bottle_id: xbottle_id
					, tablet_desc: xtablet_desc, tablet_id: xtablet_id
					, capsule_desc: xcapsule_desc, capsule_id: xcapsule_id
					, dosage_desc: xdosage_desc, dosage_id: xdosage_id
					, freq_desc: xfreq_desc, freq_id: xfreq_id
					, duration_desc: xduration_desc, duration_id: xduration_id
				}, 
				function(data){
					if(data == true){
						$('#mydashboard').DataTable().ajax.reload();
						$("#editModal").modal("toggle");
					}else{
						bootbox.dialog("Cannot EDIT record", [{
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
	
});

</script>