<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span12">

            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">New Diagnosis&nbsp;&frasl;&nbsp;Finding</div>
              </div>
            </div>
            
            <?php echo form_open('medical_records/mr_add_save');?>
            
            	<div class="row-fluid">
                	Name:&nbsp;<input type="text" autocomplete="off" class="span8 typeahead" name="fullname" id="fullname" data-placement='bottom' data-original-title='Warning' data-content='Please specify a name' value="<?php if (!empty($row[0]->fullname)) echo $row[0]->fullname; ?>" />&nbsp;
                    Date:&nbsp;<input type="text" class="span2 datepicker" name="checkup_date" id="checkup_date" data-placement='bottom' data-original-title='Warning' data-content='Please specify a date'/>
                    <input type="hidden" name="reg_id" id="reg_id" value="<?php if (!empty($row[0]->ID)) echo $row[0]->ID; ?>"/>
                </div>
                
                <div class="row-fluid">
                	Findings&nbsp;&frasl;&nbsp;P.E.:&nbsp;<textarea name="findings" id="findings" class="span9" rows="5"></textarea>
                </div>
                
                <div class="row-fluid">
                	Diagnosis:&nbsp;<textarea name="diagnosis" id="diagnosis" class="span9" rows="5"></textarea>
                </div>
                
                <div class="control-group mygroup_buttons">
				   <?php $submit = array('type' => 'submit', 'class' => 'btn-primary btn', 'value' => 'Save', 'id' =>'btn_save');?>
                   <?php echo form_submit($submit); ?>
                   <input type="button" class="btn-primary btn" id="btn_back" value="Back" onclick="window.location='<?php if (!empty($row[0]->ID)) echo 'mr_main?ID='.$row[0]->ID; else echo 'index'; ?>';"></input>
                   <input type="reset" class="btn-primary btn" id="btn_clear" value="Clear"></input>
                </div><!--/. end button Group -->
            
			<?php echo form_close(); ?>
				
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




</script>