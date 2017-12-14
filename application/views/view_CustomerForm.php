<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<script type="text/javascript">
	
$( function() {
    $( "#datepicker" ).datepicker();
  } );
	  
  </script>
<div class="page_content">

	<?php if ($action == 1) {
		echo form_open('customers/customerinsert');
		echo '<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>';		
	}else{
		echo form_open('customers/updatecustomer');
		echo '<div class="margin-default-bt"><input type="submit" name="update" class="btn btn-primary" value="Módosít"></div>';
	}?>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<div class="margin-default-bt"><input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($customerdata)) ? $customerdata['id']:''); ?>"/></div>
		<span><strong>Alapadatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_name">Név</label>
			<input type="text" class="form-control" name="customer_name" value="<?php echo set_value('customer_name',(isset($customerdata)) ? $customerdata['cegnev']:''); ?>" >
			<span class="text-danger"><?php echo form_error('customer_name')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_vatnumber">Adószám</label>
			<input type="text" class="form-control" name="customer_vatnumber" value="<?php echo set_value('customer_vatnumber',(isset($customerdata)) ? $customerdata['adoszam'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('customer_vatnumber')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_euvatnumber">Közösségi adószám</label>
			<input type="text" class="form-control" name="customer_euvatnumber" value="<?php echo set_value('customer_euvatnumber', (isset($customerdata)) ? $customerdata['kozadoszam'] : '' ); ?>" >
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_groupvatnumber">Csoportos adószám</label>
			<input type="text" class="form-control" name="customer_groupvatnumber" value="<?php echo set_value('customer_groupvatnumber', (isset($customerdata)) ? $customerdata['csopadoszam'] : '' ); ?>">
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_email">E-mail</label>
			<input type="text" class="form-control" name="customer_email" value="<?php echo set_value('customer_email', (isset($customerdata)) ? $customerdata['email'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('customer_email')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_otheremail">További e-mail cimek</label>
			<input type="text" class="form-control" name="customer_otheremail" value="<?php echo set_value('customer_otheremail', (isset($customerdata)) ? $customerdata['email_tovabbiak'] : '' ); ?>">
		</div>
		<div class="col-lg-12 col-md-8 input-align">
			<label for="customer_regdate">Regisztráció dátuma</label>
	  		<input type="text" class="form-control" id="datepicker" name="customer_regdate" value="<?php echo set_value('customer_regdate', (isset($customerdata)) ? $customerdata['reg_datum'] : '' ); ?>">
	  	</div>
	</div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
		<span><strong>Címadatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_zipcode">Irányítószám</label>
			<input type="text" class="form-control" name="customer_zipcode" value="<?php echo set_value('customer_zipcode', (isset($customerdata)) ? $customerdata['cim_irszam'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('customer_zipcode')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_city">Település</label>
			<input type="text" class="form-control" name="customer_city" value="<?php echo set_value('customer_city', (isset($customerdata)) ? $customerdata['cim_telepules'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('customer_city')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_street">Közterület neve</label>
			<input type="text" class="form-control" name="customer_street" value="<?php echo set_value('customer_street', (isset($customerdata)) ? $customerdata['cim_kozternev'] : ''); ?>">
			<span class="text-danger"><?php echo form_error('customer_street')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_streettype">Közterület jellege <i>(pl. utca)</i></label>
			<input type="text" class="form-control" name="customer_streettype" value="<?php echo set_value('customer_streettype', (isset($customerdata)) ? $customerdata['cim_kozterjelleg'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('customer_streettype')?></span>
		</div>		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_housenumber">Házszám</label>
			<input type="text" class="form-control" name="customer_housenumber" value="<?php echo set_value('customer_housenumber', (isset($customerdata)) ? $customerdata['cim_hazszam'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('customer_housenumber')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_otheraddress">Egyéb címadat</label>
			<input type="text" class="form-control" name="customer_otheraddress" value="<?php echo set_value('customer_otheraddress', (isset($customerdata)) ? $customerdata['cim_egyeb'] : '' ); ?>">
		</div>		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_country">Ország</label>
			<input type="text" class="form-control" name="customer_country" value="<?php echo set_value('customer_country', (isset($customerdata)) ? $customerdata['cim_orszag'] : '' ); ?>">
		</div>
			<input type="hidden" class="form-control" name="customer_fulladdress" value="<?php echo set_value('customer_zipcode'); ?>">
	</div>
	</form>

</div>

</body>
</html>
