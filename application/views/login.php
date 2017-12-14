<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="page_content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login_container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>MIABOS ADMIN</h3>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		
 		<?php /*phpinfo();*/?>
  		<?php echo form_open('authentication'); ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="user_name">Felhasználó</label>
				<input type="text" class="form-control" name="user_name" placeholder="Felhasználó név">
				<span class="text-danger"><?php echo form_error('user_name')?></span>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label for="user_passw">Jelszó</label>
				<input type="password" class="form-control" name="user_passw" placeholder="Jelszó">
				<span class="text-danger"><?php echo form_error('user_passw')?></span>				
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button type="submit" name="user_login" class="btn btn-primary">Belépés</button>
				<br>
				<?php 
				echo '<span class="text-danger">' . $this->session->flashdata('error') .'</span>';
				?>
			</div>
			
		</form>
		</div>
	</div>
</div>