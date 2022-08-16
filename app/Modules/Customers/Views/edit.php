<?= $this->extend("admin/layout/master") ?>

<?= $this->section("style") ?>
<style>
	.action {
		margin-top: 35px;
	}

	a.remove_row {
		font-size: 35px;
	}

	.existing_user_avatar img {
		display: block;
	}

	.existing_banner_avatar img {
		display: block;
	}

	.favor_in_span {
		color: red;
		font-size: 0.875rem;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title"><?= $module ?></h4>
						</div>
					</div>
					<!--<?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger errors">
                            <?php foreach ($errors as $field => $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>-->
                        <?php echo form_open_multipart('', array('class' => 'forms-sample'), array('s' => 'ok')); ?>
                        <div class="row">
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="name"><?php echo lang('Text.customer.table.label.name') ?><span class="favor_in_span">*</span></label>
                        			<input type="text" class="form-control" name="name" value="<?= $name ?>" id="name" autocomplete="off" />
                        			<?php if (!empty($errors['name'])) : ?>
                        				<p class="error"><?= $errors['name'] ?></p>
                        			<?php endif; ?>
                        		</div>
                        	</div>
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="exampleInputEmail3"><?php echo lang('Text.customer.table.label.email') ?><span class="favor_in_span">*</span></label>
                        			<input type="email" class="form-control" name="email" value="<?= $email ?>" id="exampleInputEmail3" autocomplete="off" />
                        			<?php if (!empty($errors['email'])) : ?>
                        				<p class="error"><?= $errors['email'] ?></p>
                        			<?php endif; ?>
                        		</div>
                        	</div>
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="password"><?php echo lang('Text.customer.table.label.password') ?></label>
                        			<input type="password" class="form-control" name="password" value="" id="password" autocomplete="off" />
                        			<i type="checkbox" onclick="myFunction()" id="eye" class="mdi mdi-eye-off"></i>
                        			<?php if (!empty($errors['password'])) : ?>
                        				<p class="error"><?= $errors['password'] ?></p>
                        			<?php endif; ?>
                        		</div>
                        	</div>
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="phone"><?php echo lang('Text.customer.table.label.phone') ?></label>
                        			<input type="text" class="form-control" name="phone" value="<?= $phone ?>" id="phone" autocomplete="off" />
                        			<?php if (!empty($errors['phone'])) : ?>
                        				<p class="error"><?= $errors['phone'] ?></p>
                        			<?php endif; ?>
                        		</div>
                        	</div>
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label><?php echo lang('Text.customer.table.label.select_gender') ?></label>
                        			<select class="form-control" name="gender" >
                        				<option value="">--<?php echo lang('Text.common.select') ?>--</option>
                        				<?php 
                        				$gender_arr = gender(); 
                        				foreach($gender_arr as $key => $val):
                        					$selected="";
                        					if($key==$gender):
                        						$selected="selected";
                        					endif;
                        					echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                        				endforeach;
                        				?>
                        			</select>
                        		</div>
                        	</div>
                        	<div class="col-md-4">
                        		<div class="form-group">
                        			<label><?php echo lang('Text.customer.table.label.dob') ?></label>
                        			<input class="form-control" name="dob" id="datepicker" value="<?php echo date('d-m-Y',$dob) ?>" >
                        			<i class="mdi mdi-calendar" id="show-date-picker"></i>
                        		</div>
                        	</div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-6">
                        		<a href="<?php echo base_url('admin/' . $mr) ?>">
                        			<button type="button" class="btn btn-primary btn-icon-text btn-sm">
                        				<i class="mdi mdi-arrow-left" style="font-size: 11px;"></i><span><?php echo lang('Text.common.back') ?></span>
                        			</button>
                        		</a>
                        	</div>
                        	<div class="col-md-6 text-right">
                        		<button type="submit" class="btn btn-primary mr-2"><?php echo lang('Text.common.submit') ?></button>
                        	</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script>
	$(document).on('change', 'select', function(e) {
		$(this).next("p.error").remove();
	});
	$(document).on('focus', 'input', function(e) {
		$(this).next("p.error").remove();
	});
	$(document).on('change', 'input', function(e) {
		$(this).next("p.error").remove();
	});

	//profile picture
	$(document).on('change', '.user_avatar .file-upload-default', function(e) {
		var self = $(this);
		var data = new FormData();
		data.append('file', e.target.files[0]);
		$.ajax({
			url: "<?php echo base_url('admin/upload') ?>",
			type: "POST",
			data: data,
			enctype: 'multipart/form-data',
			processData: false, // tell jQuery not to process the data
			contentType: false // tell jQuery not to set contentType
		}).done(function(insert_id) {
			console.log(insert_id);
			self.parents('.user_avatar').find('.file').val(insert_id);
		});
		return false;
	});
	//hide show password
	function myFunction() {
		$('#eye').removeClass('mdi mdi-eye-off');
		$('#eye').removeClass('mdi mdi-eye');
		var x = document.getElementById("password");
		if (x.type === "password") {
			$('#eye').addClass('mdi mdi-eye');
			x.type = "text";
		} else {
			$('#eye').addClass('mdi mdi-eye-off');
			x.type = "password";
		}
	}
	$( function() {
		var current_year = new Date().getFullYear();
		$( "#datepicker" ).datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			yearRange: "1930:"+(current_year-10),

		});

		$(document).on('click','#show-date-picker',function(){

			$('#datepicker').datepicker('show')
		});
	} );
</script>
<?= $this->endSection() ?>