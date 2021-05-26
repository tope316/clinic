<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span12">

            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Personal Numbers</div>
              </div>
            </div>
            
            <?php 
				echo form_open('settings/settings_save');
			?>
            
            	<div class="row-fluid">
                	License No.:&nbsp;<input type="text" class="span9" name="license_no" id="license_no" value="<?php echo $row[0]->license_no; ?>" />
                </div>
                
                <div class="row-fluid">
                	PTR. No.:&nbsp;<input type="text" class="span9" name="ptr_no" id="ptr_no" value="<?php echo $row[0]->ptr_no; ?>" />
                </div>
                
                <div class="row-fluid">
                	S2 No.:&nbsp;<input type="text" class="span9" name="s2_no" id="s2_no" value="<?php echo $row[0]->s2_no; ?>" />
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