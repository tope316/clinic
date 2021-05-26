<div class="container-fluid">

	<div class="row-fluid">
			   
		<div class="span12">

            <!--- table label --->
                    
            <div class="navbar">
              <div class="navbar-inner">
                <div class="brand">Registration - New</div>
              </div>
            </div>
            
            <?php echo form_open('registration/registration_add_save'); ?>
            
            	<div class="row-fluid">
                	Name:&nbsp;<input type="text" class="span6" name="fullname" id="fullname" data-placement='bottom' data-original-title='Warning' data-content='Please specify a name' />&nbsp;
                    Birth Date:&nbsp;<input type="text" class="span3 datepicker" name="birthdate" id="birthdate"/>&nbsp;
                    Sex:&nbsp;<input type="text" class="span1" name="sex" id="sex"/>&nbsp;
                </div>
                
                <div class="row-fluid">
                	Tel. No.:&nbsp;<input type="text" class="span2" name="phone" id="phone"/>&nbsp;
                    Cell No.:&nbsp;<input type="text" class="span2" name="mobile" id="mobile"/>&nbsp;
                    Father's Name:&nbsp;<input type="text" class="span2" name="fathers_name" id="fathers_name"/>&nbsp;
                    Mother's Name:&nbsp;<input type="text" class="span2" name="mothers_name" id="mothers_name"/>&nbsp;
                </div>
                
                <div class="row-fluid">
                	Address:&nbsp;<input type="text" class="span11" name="address" id="address"/>&nbsp;
                </div>
                
                <div class="row-fluid">
                    <h5>BIRTH HISTORY:</h5>
                </div>
                
                <div class="row-fluid">
                	Type of Delivery:&nbsp;<input type="text" class="span3" name="delivery" id="delivery"/>&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    BW:&nbsp;<input type="text" class="span1" name="bw" id="bw"/>&nbsp;
                    BL:&nbsp;<input type="text" class="span1" name="bl" id="bl"/>&nbsp;
                    HC:&nbsp;<input type="text" class="span1" name="hc" id="hc"/>&nbsp;
                    Hosp.:&nbsp;<input type="text" class="span3" name="hosp" id="hosp"/>&nbsp;
                </div>
                
                <div class="row-fluid">
                	Immediate Newborn Period:&nbsp;<input type="text" class="span9" name="newborn_period" id="newborn_period"/>&nbsp;
                </div>
                
                <div class="row-fluid line-bottom">
                    <h5>IMMUNIZATIONS</h5>
                </div>
                
                <div class="row-fluid line-bottom myrow2">
                    <div class="span3 center">VACCINES</div>
                    <div class="span3 center">DATE</div>
                    <div class="span3 center">VACCINES</div>
                    <div class="span3 center">DATE</div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">BCG</div>
                    <div class="span3 broken-bottom">&nbsp;&nbsp;&nbsp;<input type="text" class="datepicker span10" name="bcg_date_1" id="bcg_date_1"/></div>
                    <div class="span3">Influenza</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="influenza_date_1" id="influenza_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">Hepatitis B</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="hepa_b_date_1" id="hepa_b_date_1"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="influenza_date_2" id="influenza_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="hepa_b_date_2" id="hepa_b_date_2"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="influenza_date_3" id="influenza_date_3"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="hepa_b_date_3" id="hepa_b_date_3"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">4&nbsp;<input type="text" class="datepicker span10" name="influenza_date_4" id="influenza_date_4"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3"><p align="right">booster&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
                    <div class="span3">4&nbsp;<input type="text" class="datepicker span10" name="hepa_b_date_4" id="hepa_b_date_4"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">5&nbsp;<input type="text" class="datepicker span10" name="influenza_date_5" id="influenza_date_5"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">6&nbsp;<input type="text" class="datepicker span10" name="influenza_date_6" id="influenza_date_6"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">DPT</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="dpt_date_1" id="dpt_date_1"/></div>
                    <div class="span3">Varicella</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="varicella_date_1" id="varicella_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="dpt_date_2" id="dpt_date_2"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">2&nbsp;<input type="text" class="datepicker span10" name="varicella_date_2" id="varicella_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="dpt_date_3" id="dpt_date_3"/></div>
                    <div class="span3">Hepatitis A</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="hepa_a_date_1" id="hepa_a_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3"><p align="right">booster&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
                    <div class="span3">4&nbsp;<input type="text" class="datepicker span10" name="dpt_date_4" id="dpt_date_4"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="hepa_a_date_2" id="hepa_a_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">5&nbsp;<input type="text" class="datepicker span10" name="dpt_date_5" id="dpt_date_5"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">3&nbsp;<input type="text" class="datepicker span10" name="hepa_a_date_3" id="hepa_a_date_3"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">OPV / IPV</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="opv_date_1" id="opv_date_1"/></div>
                    <div class="span3">PCV7 / PCV10</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="pcv_date_1" id="pcv_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="opv_date_2" id="opv_date_2"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="pcv_date_2" id="pcv_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="opv_date_3" id="opv_date_3"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="pcv_date_3" id="pcv_date_3"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3"><p align="right">booster&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
                    <div class="span3">4&nbsp;<input type="text" class="datepicker span10" name="opv_date_4" id="opv_date_4"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">4&nbsp;<input type="text" class="datepicker span10" name="pcv_date_4" id="pcv_date_4"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">5&nbsp;<input type="text" class="datepicker span10" name="opv_date_5" id="opv_date_5"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">Hib</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="hib_date_1" id="hib_date_1"/></div>
                    <div class="span3">Pneumococcal</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="pneumo_date_1" id="pneumo_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="hib_date_2" id="hib_date_2"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">2&nbsp;<input type="text" class="datepicker span10" name="pneumo_date_2" id="pneumo_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">3&nbsp;<input type="text" class="datepicker span10" name="hib_date_3" id="hib_date_3"/></div>
                    <div class="span3">MMR</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="mmr_date_1" id="mmr_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom"><p align="right">booster&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
                    <div class="span3 broken-bottom">4&nbsp;<input type="text" class="datepicker span10" name="hib_date_4" id="hib_date_3"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">2&nbsp;<input type="text" class="datepicker span10" name="mmr_date_2" id="mmr_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">Measle</div>
                    <div class="span3 broken-bottom">&nbsp;&nbsp;&nbsp;<input type="text" class="datepicker span10" name="measle_date_1" id="measle_date_1"/></div>
                    <div class="span3 broken-bottom">Meningococcal A &amp; C</div>
                    <div class="span3 broken-bottom">&nbsp;&nbsp;&nbsp;<input type="text" class="datepicker span10" name="meningo_date_1" id="meningo_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">Rotavirus</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="rota_date_1" id="rota_date_1"/></div>
                    <div class="span3">HPV</div>
                    <div class="span3">1&nbsp;<input type="text" class="datepicker span10" name="hpv_date_1" id="hpv_date_1"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="rota_date_2" id="rota_date_2"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">2&nbsp;<input type="text" class="datepicker span10" name="hpv_date_2" id="hpv_date_2"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">3&nbsp;<input type="text" class="datepicker span10" name="rota_date_3"/></div>
                    <div class="span3 broken-bottom">&nbsp;</div>
                    <div class="span3 broken-bottom">3&nbsp;<input type="text" class="datepicker span10" name="hpv_date_3" id="hpv_date_3"/></div>
                </div>
                
                <div class="row-fluid myrow">
                	<div class="span3 broken-bottom">Typhoid Fever</div>
                    <div class="span3 broken-bottom">&nbsp;&nbsp;&nbsp;<input type="text" class="datepicker span10" name="typhoid_date_1" id="typhoid_date_1"/></div>
                    <div class="span3">&nbsp;</div>
                    <div class="span3">&nbsp;</div>
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
	$('.datepicker').datepicker();
	
	$('#btn_save').click(function(){
			
		var fullname = $('#fullname').val();			
		
		if(fullname == ""){	
			$('#fullname').popover('show');
			$('#fullname').focus();
			return false;
		} else{
			return true;
		}
		
		
	});
});

</script>