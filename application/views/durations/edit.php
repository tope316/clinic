<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span12">

            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Duration - Edit</div>
              </div>
            </div>
            
            <?php echo form_open('durations/edit_save'); ?>
            
            	<input name="ID" type="hidden" value="<?php echo $row[0]->ID;?>" />
            	<div class="row-fluid">
                	Description:&nbsp;<input type="text" class="span11" name="description" id="description" value="<?php echo $row[0]->description;?>" data-placement='top' data-original-title='Warning' data-content='Please specify a description' />&nbsp;
                </div>
                
                <div class="control-group mygroup_buttons">
				   <?php $submit = array('type' => 'submit', 'class' => 'btn-primary btn', 'value' => 'Save', 'id' =>'btn_save');?>
                   <?php echo form_submit($submit); ?>
                   <input type="button" class="btn-primary btn" id="btn_back" value="Back" onclick="window.location='index';"></input>
                   <input type="reset" class="btn-primary btn" id="btn_clear" value="Clear"></input>
                </div><!--/. end button Group -->
            
			<?php echo form_close(); ?>
				
		</div>
    </div>
</div>

<script type='text/javascript'>

$(function() {
	
	$('#btn_save').click(function(){
			
		var description = $('#description').val();			
		
		if(description == ""){	
			$('#description').popover('show');
			return false;
		} else{
			return true;
		}
		
		
	});
});

</script>