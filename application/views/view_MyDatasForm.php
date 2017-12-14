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

	<?php 
		echo form_open('mydatas/updatedatas');
		echo '<div class="margin-default-bt"><input type="submit" name="update" class="btn btn-primary" value="Módosít"></div>';
	?>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($companydatas)) ? $companydatas['id']:''); ?>"/>
		<span><strong>Alapadatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="company_name">Név</label>
			<input type="text" class="form-control" name="company_name" value="<?php echo set_value('company_name',(isset($companydatas)) ? $companydatas['nev'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('company_name')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_vatnumber">Adószám</label>
			<input type="text" class="form-control" name="company_vatnumber" value="<?php echo set_value('company_vatnumber',(isset($companydatas)) ? $companydatas['adoszam'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('company_vatnumber')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_euvatnumber">Közösségi adószám</label>
			<input type="text" class="form-control" name="company_euvatnumber" value="<?php echo set_value('company_euvatnumber', (isset($companydatas)) ? $companydatas['kozadoszam'] : '' ); ?>" >
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_groupvatnumber">Csoportos adószám</label>
			<input type="text" class="form-control" name="company_groupvatnumber" value="<?php echo set_value('company_groupvatnumber', (isset($companydatas)) ? $companydatas['csopadoszam'] : '' ); ?>">
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_email">E-mail</label>
			<input type="text" class="form-control" name="company_email" value="<?php echo set_value('company_email', (isset($companydatas)) ? $companydatas['email'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('company_email')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_otheremail">Számlaközpont HASH kód</label>
			<input type="text" class="form-control" name="company_apikey" value="<?php echo set_value('company_apikey', (isset($companydatas)) ? $companydatas['apikey'] : '' ); ?>">
		</div>
		<div class="col-lg-12 col-md-8 input-align">
			<label for="company_regdate">Regisztráció dátuma</label>
	  		<input type="text" class="form-control" id="datepicker" name="company_regdate" value="<?php echo set_value('company_regdate', (isset($companydatas)) ? $companydatas['reg_datum'] : '' ); ?>">
	  	</div>
	</div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
		<span><strong>Címadatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_zipcode">Irányítószám</label>
			<input type="text" class="form-control" name="company_zipcode" value="<?php echo set_value('company_zipcode', (isset($companydatas)) ? $companydatas['cim_irszam'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('company_zipcode')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_city">Település</label>
			<input type="text" class="form-control" name="company_city" value="<?php echo set_value('company_city', (isset($companydatas)) ? $companydatas['cim_telepules'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('company_city')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_street">Közterület neve</label>
			<input type="text" class="form-control" name="company_street" value="<?php echo set_value('company_street', (isset($companydatas)) ? $companydatas['cim_kozternev'] : ''); ?>">
			<span class="text-danger"><?php echo form_error('company_street')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_streettype">Közterület jellege <i>(pl. utca)</i></label>
			<input type="text" class="form-control" name="company_streettype" value="<?php echo set_value('company_streettype', (isset($companydatas)) ? $companydatas['cim_kozterjelleg'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('company_streettype')?></span>
		</div>		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_housenumber">Házszám</label>
			<input type="text" class="form-control" name="company_housenumber" value="<?php echo set_value('company_housenumber', (isset($companydatas)) ? $companydatas['cim_hazszam'] : '' ); ?>">
			<span class="text-danger"><?php echo form_error('company_housenumber')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_otheraddress">Egyéb címadat</label>
			<input type="text" class="form-control" name="company_otheraddress" value="<?php echo set_value('company_otheraddress', (isset($companydatas)) ? $companydatas['cim_egyeb'] : '' ); ?>">
		</div>		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_country">Ország</label>
			<input type="text" class="form-control" name="company_country" value="<?php echo set_value('company_country', (isset($companydatas)) ? $companydatas['cim_orszag'] : '' ); ?>">
		</div>
	</div>
	</form>

</div>

</body>
</html>
