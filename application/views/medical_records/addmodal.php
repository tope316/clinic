<!-- Add Modal -->
<div id="addModal" class="modal fade kmod" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Treatment</h4>
      </div>
      <div class="modal-body">
      	<p>Generic:&nbsp;<input type="text" autocomplete="off" class="span4 generic_typeahead" name="generic_desc" id="generic_desc" data-placement='bottom' data-original-title='Warning' data-content='Please specify a Generic Name' /><input type="hidden" name="generic_id" id="generic_id"/>&nbsp;</p>
        <p>Brand:&nbsp;<input type="text" autocomplete="off" class="span4 brand_typeahead" name="brand_desc" id="brand_desc" /><input type="hidden" name="brand_id" id="brand_id"/>&nbsp;</p>
        <p>Preparation:&nbsp;<input type="text" autocomplete="off" class="span4 preparation_typeahead" name="prep_desc" id="prep_desc" /><input type="hidden" name="prep_id" id="prep_id"/>&nbsp;</p>
        <p>Bottle:&nbsp;<input type="text" autocomplete="off" class="span4 bottle_typeahead" name="bottle_desc" id="bottle_desc" /><input type="hidden" name="bottle_id" id="bottle_id"/>&nbsp;</p>
        <p>Tablet:&nbsp;<input type="text" autocomplete="off" class="span4 tablet_typeahead" name="tablet_desc" id="tablet_desc" /><input type="hidden" name="tablet_id" id="tablet_id"/>&nbsp;</p>
        <p>Capsule:&nbsp;<input type="text" autocomplete="off" class="span4 capsule_typeahead" name="capsule_desc" id="capsule_desc" /><input type="hidden" name="capsule_id" id="capsule_id"/>&nbsp;</p>
        <p>Dosage:&nbsp;<input type="text" autocomplete="off" class="span4 dosage_typeahead" name="dosage_desc" id="dosage_desc" /><input type="hidden" name="dosage_id" id="dosage_id"/>&nbsp;</p>
        <p>Frequency:&nbsp;<input type="text" autocomplete="off" class="span4 frequency_typeahead" name="freq_desc" id="freq_desc" /><input type="hidden" name="freq_id" id="freq_id"/>&nbsp;</p>
        <p>Duration:&nbsp;<input type="text" autocomplete="off" class="span4 duration_typeahead" name="duration_desc" id="duration_desc" /><input type="hidden" name="duration_id" id="duration_id"/>&nbsp;</p>
      	<br/><br/>
      </div>
      <div class="modal-footer">
      	<input type="button" class="btn-primary btn" id="addbtn" value="Save" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type='text/javascript'>

$(function() {
	
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
		
	var bottles = [
		<?php
			$is_first = true;
			foreach($bottles as $bottle) {
				if ($is_first) {
					echo '{"value": '.'"'.$bottle->description.'", ' . '"id": '.'"'.$bottle->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$bottle->description.'", ' . '"id": '.'"'.$bottle->ID.'"}';
			}
		?>
	];
	
	var generics = [
		<?php
			$is_first = true;
			foreach($generics as $generic) {
				if ($is_first) {
					echo '{"value": '.'"'.$generic->description.'", ' . '"id": '.'"'.$generic->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$generic->description.'", ' . '"id": '.'"'.$generic->ID.'"}';
			}
		?>
	];
	
	var brands = [
		<?php
			$is_first = true;
			foreach($brands as $brand) {
				if ($is_first) {
					echo '{"value": '.'"'.$brand->description.'", ' . '"id": '.'"'.$brand->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$brand->description.'", ' . '"id": '.'"'.$brand->ID.'"}';
			}
		?>
	];
	
	var preparations = [
		<?php
			$is_first = true;
			foreach($preparations as $preparation) {
				if ($is_first) {
					echo '{"value": '.'"'.$preparation->description.'", ' . '"id": '.'"'.$preparation->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$preparation->description.'", ' . '"id": '.'"'.$preparation->ID.'"}';
			}
		?>
	];
	
	var tablets = [
		<?php
			$is_first = true;
			foreach($tablets as $tablet) {
				if ($is_first) {
					echo '{"value": '.'"'.$tablet->description.'", ' . '"id": '.'"'.$tablet->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$tablet->description.'", ' . '"id": '.'"'.$tablet->ID.'"}';
			}
		?>
	];
	
	var capsules = [
		<?php
			$is_first = true;
			foreach($capsules as $capsule) {
				if ($is_first) {
					echo '{"value": '.'"'.$capsule->description.'", ' . '"id": '.'"'.$capsule->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$capsule->description.'", ' . '"id": '.'"'.$capsule->ID.'"}';
			}
		?>
	];
	
	var dosages = [
		<?php
			$is_first = true;
			foreach($dosages as $dosage) {
				if ($is_first) {
					echo '{"value": '.'"'.$dosage->description.'", ' . '"id": '.'"'.$dosage->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$dosage->description.'", ' . '"id": '.'"'.$dosage->ID.'"}';
			}
		?>
	];
	
	var freqs = [
		<?php
			$is_first = true;
			foreach($freqs as $freq) {
				if ($is_first) {
					echo '{"value": '.'"'.$freq->description.'", ' . '"id": '.'"'.$freq->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$freq->description.'", ' . '"id": '.'"'.$freq->ID.'"}';
			}
		?>
	];
	
	var durations = [
		<?php
			$is_first = true;
			foreach($durations as $duration) {
				if ($is_first) {
					echo '{"value": '.'"'.$duration->description.'", ' . '"id": '.'"'.$duration->ID.'"}';
					$is_first = false;
				} else
					echo ', {"value": '.'"'.$duration->description.'", ' . '"id": '.'"'.$duration->ID.'"}';
			}
		?>
	];
	
	$('.bottle_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'bottles',
	  displayKey: 'value',
	  source: substringMatcher(bottles)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=bottle_id]').val(datum.id);
	});
	
	$('.generic_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'bottles',
	  displayKey: 'value',
	  source: substringMatcher(generics)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=generic_id]').val(datum.id);
	});
	
	$('.brand_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'brands',
	  displayKey: 'value',
	  source: substringMatcher(brands)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=brand_id]').val(datum.id);
	});
	
	$('.preparation_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'preparations',
	  displayKey: 'value',
	  source: substringMatcher(preparations)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=prep_id]').val(datum.id);
	});
	
	$('.tablet_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'tablets',
	  displayKey: 'value',
	  source: substringMatcher(tablets)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=tablet_id]').val(datum.id);
	});
	
	$('.capsule_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'capsules',
	  displayKey: 'value',
	  source: substringMatcher(capsules)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=capsule_id]').val(datum.id);
	});
	
	$('.dosage_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'dosages',
	  displayKey: 'value',
	  source: substringMatcher(dosages)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=dosage_id]').val(datum.id);
	});
	
	$('.frequency_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'freqs',
	  displayKey: 'value',
	  source: substringMatcher(freqs)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=freq_id]').val(datum.id);
	});
	
	$('.duration_typeahead').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},{
	  name: 'durations',
	  displayKey: 'value',
	  source: substringMatcher(durations)
	}).on('typeahead:selected', function (object, datum) {
	
		// Datum containg value, tokens, and custom properties
		$('input[name=duration_id]').val(datum.id);
	});
	
	// Saving
	$("#addbtn").click(function(){
		var xmr_id = $("#ID").val();
		var xgeneric_desc = $("#generic_desc").val();
		var xgeneric_id = $("#generic_id").val();
		var xbrand_desc = $("#brand_desc").val();
		var xbrand_id = $("#brand_id").val();
		var xprep_desc = $("#prep_desc").val();
		var xprep_id = $("#prep_id").val();
		var xbottle_desc = $("#bottle_desc").val();
		var xbottle_id = $("#bottle_id").val();
		var xtablet_desc = $("#tablet_desc").val();
		var xtablet_id = $("#tablet_id").val();
		var xcapsule_desc = $("#capsule_desc").val();
		var xcapsule_id = $("#capsule_id").val();
		var xdosage_desc = $("#dosage_desc").val();
		var xdosage_id = $("#dosage_id").val();
		var xfreq_desc = $("#freq_desc").val();
		var xfreq_id = $("#freq_id").val();
		var xduration_desc = $("#duration_desc").val();
		var xduration_id = $("#duration_id").val();
		
		if(xgeneric_desc == ""){	
			$('#generic_desc').popover('show');
			$('#generic_desc').focus();
			return false;
		} else {
			
			$.post('add_treatment', 
				{
					mr_id: xmr_id, generic_desc: xgeneric_desc, generic_id: xgeneric_id
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
						//location.reload();
						$('#mydashboard').DataTable().ajax.reload();
						$("#addModal").modal("toggle");
					}else{
						bootbox.dialog("Cannot ADD record", [{
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