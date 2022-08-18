<?= $this->extend("admin/layout/master") ?>

<?= $this->section("style") ?>
<style>
	.action {
		margin-top: 35px;
	}

	a.remove_row {
		font-size: 35px;
	}
	.favor_in_span {
		color:red;
		font-size: 0.875rem;
	}
	
	/* IMAGE STYLES */
	[type=radio] + img {
	  cursor: pointer;
	}

	/* CHECKED STYLES */
	[type=radio]:checked + img {
	  outline: 2px solid #f00;
	}
	input[type="radio"] {
		display: none;
	}
	.add_img {
		text-align: right;
	}
		.radio_img {
		width: 100% !important;
	}
	.radio_img img {
		width: 142px;
		height: 100px;
	}
	.form-group .text-right {
		padding: 10px 0px;
	}
	.model_view img {
		width: 100%;
		height: auto;
		padding-bottom: 20px;
	}
	.model_view span {
		display: flex;
		font-weight: 500;
	}
	.model_view span p {
		padding-left: 10px;
	}
	.model_view span input {
		margin-left: 10px;
		width: 85%;
		border: 1px solid #000;
	}
	.model_view label {
		width: 100%;
	}
	.modal-dialog {
		max-width: 800px;
		margin: 30px auto;
	}
	.text-right {
		text-align: right !important;
		padding: 0px 0px 10px 0px !important;
	}
	.text-right button.btn.btn-primary.mr-2.submit {
		margin: 0px !important;
	}
	.img_show img {
		width: 100px;
		height: 100px;
		margin: 5px 3px;
	}
	
	.hints_file .hints_show_img img {
		width: 100px;
		height: 100px;
	}
	.hints_file .hints_show_img {
		padding: 5px 2px;
	}
	.questions_img_modal.questions_img_show {
		width: 100%;
	}
	.questions_img_modal.questions_img_show img {
		width: 100px;
	}
	.choose_file .img_modal.img_show {
		width: 100% !important;
	}
	.img_show img {
		width: 100%;
		height: 200px;
		margin: 5px 3px;
		object-fit: cover;
	}
	hr.spacer {
	    margin-bottom: 35px;
	}
	.form-group.task-description {
	    margin-bottom: 45px;
	}
	.user_avatar .form-group .input-group-append button {
	    background: #57B657 !important;
	    border-color: #57B657 !important;
	}
	.user_avatar .form-group .input-group-append button:hover{
		background: #005689 !important;
		border-color: #005689 !important;
	}
	.card .card-title{
		margin-bottom: 10px;
	}
	.card .task-tittle{
		margin-bottom: 14px;
	}
	.adventures_gallery_images .radio_img .cross_icon_add {
	    background: #d52929;
	    color: #fff;
	    display: inline-block;
	    padding: 1px 6px;
	    border-radius: 100%;
	    position: absolute;
	    right: -10px;
	    top: -10px;
	    height: 25px;
	    width: 25px;
	    -webkit-text-stroke: 1px #d52929;
	    cursor: pointer;
	}
	.adventures_gallery_images .radio_img label {
	    position: relative;
	}
	.adventures_gallery_images .image_section {
	    flex: auto;
	    max-width: max-content;
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
							<h4 class="card-title"><?=$module?></h4>
						</div>
					</div>
					<?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger errors">
                            <?php foreach ($errors as $field => $error) : ?>
                                <p><?= $error ?></p>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                        <?php echo form_open_multipart('', array('class' => 'forms-sample'), array('s' => 'ok')); ?>
                        <div class="row">
							<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="title">Title<span class="favor_in_span">*</span></label>
                        			<input type="text" class="form-control "  name="title" value="<?php echo $title ?>" id="title" autocomplete="off" />
                        			<?php if(!empty($errors['title'])): ?>
                        				<p class="error"><?= $errors['title']?></p>
                        			<?php endif;?>
                        		</div>
                        	</div>
							<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="director">Director<span class="favor_in_span">*</span></label>
                        			<input type="text" class="form-control "  name="director" value="<?php echo $director ?>" id="director" autocomplete="off" />
                        			<?php if(!empty($errors['director'])): ?>
                        				<p class="error"><?= $errors['director']?></p>
                        			<?php endif;?>
                        		</div>
                        	</div>
							<div class="col-md-4">
                        		<div class="form-group">
                        			<label for="studio">Studio<span class="favor_in_span">*</span></label>
                        			<input type="text" class="form-control "  name="studio" value="<?php echo $studio ?>" id="studio" autocomplete="off" />
                        			<?php if(!empty($errors['studio'])): ?>
                        				<p class="error"><?= $errors['studio']?></p>
                        			<?php endif;?>
                        		</div>
                        	</div>
                        	<div class="col-md-12">
                        		<div class="form-group">
                        			<label for="name">Description</label>
                        			<textarea type="text" rows="4" cols="50" class="form-control editor"  id="description" name="description" value="" id="description" autocomplete="off" /><?php echo $description ?></textarea>
                        			<?php if(!empty($errors['description'])): ?>
                        				<p class="error"><?= $errors['description']?></p>
                        			<?php endif;?>
                        		</div>
                        	</div>
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-12">
										<h5 class="card-title">Image</h5>
									</div>
									<div class="col-md-12 user_avatar choose_file questions" title="Image" section_class="image" >
										<div class="form-group">
											<span class="input-group-append">
												<button class="btn btn-primary"  id="choose_file" data-toggle="modal" data-target="#exampleModalScrollablequestions" type="button"><?php echo lang('Text.challenges.table.label.choose_image') ?></button>
											</span>
											<!-- <label class="img_modal img_show"></label> -->
										</div>
									</div>
									<!-- for selected image show -->
									<div class="col-md-12 adventures_gallery_box image" style="padding: 0px 15px; display:block;">
										<div class="row adventures_gallery_images">
										      <?php
											  if(isset($image) && !empty($image)):
													$image_name = $model->GetSingleValue(MEDIA_TABLE,'name', array('id' => $image));
													$path = FCPATH.'/uploads/'.$image_name;
													if(file_exists($path)): ?>
													<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="image" value="<?=$image?>"><img src="<?=base_url('/uploads/'.$image_name)?>"></label></div></div>
													 <?php
													endif;
											    endif;
											   ?>
										</div> 
										<hr>  
									</div>
								</div>
							</div>
							<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12">
									<h5 class="card-title task-tittle">Video</h5>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="name">Video Url</label>
										<input type="text" class="form-control "  name="video_url" value="<?php echo $video_url ?>" id="video_url" autocomplete="off" />
										<?php if(!empty($errors['video_url'])): ?>
											<p class="error"><?= $errors['video_url']?></p>
										<?php endif;?>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="col-md-12 user_avatar choose_file questions" title="Image" section_class="section_file">
										<div class="form-group">
											<label>File</label>
											<span class="input-group-append">
												<button class="btn btn-primary" id="choose_file" data-toggle="modal" data-target="#exampleModalScrollablequestions" type="button">Choose File</button>
											</span>
											<label class="img_modal img_show"></label>
										</div>
									</div>
									<!-- for selected image show -->
									<div class="col-md-12 adventures_gallery_box section_file" style="padding: 0px 15px; display:block;">
										<div class="row adventures_gallery_images">
											<?php
											if (isset($file) && !empty($file)) :
												$image_name = $model->GetSingleValue(MEDIA_TABLE, 'name', array('id' => $file));
												$original_name = $model->GetSingleValue(MEDIA_TABLE, 'original_name', array('id' => $file));
												$ext = pathinfo($image_name, PATHINFO_EXTENSION);
												$image_extention = ["jpeg","jpg","png","gif"];
												$path = FCPATH . '/uploads/' . $image_name;
												if (file_exists($path)) : 
												     if(in_array($ext, $image_extention)):?>
													<div class="col-lg-2 image_section" title="<?=$image_name?>"  style="padding:5px 15px;">
														<div class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="file" value="<?=$file?>"><img src="<?= base_url('/uploads/' . $image_name) ?>"></label></div>
													</div>
											<?php  else:  ?>
											         <div class="col-lg-2 image_section" title="<?=$original_name?>" style="padding:5px 15px;">
														<div class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="file" value="<?=$file?>"><img src="https://via.placeholder.com/150/?Text=<?=$original_name?>/Ohttps://placeholder.com/"></label><p class="original_name"><?=$original_name?></p></div>
													</div>
											<?php	endif;
											     endif;
											endif;
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
                        </div> 
                        <div class="row">
                        	<div class="col-lg-6">
                        		<a href="<?php echo base_url('admin/'.$mr) ?>">
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

<!-- Modal 2nd 
<div class="modal fade media-modal" id="exampleModalScrollablequestions" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-tabs">
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary show_media_images show_media_images_button active" type="button">Media Gallery</button>
		</div>
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary media_add_image_new show_media_images_button" type="button">Upload</button>
		</div>
	  </div>
      <div class="modal-body" >
        <div class="radio_img checked_image_box" id="media_box">
			<?php 
			   if(isset($media_img) && !empty($media_img)):
				 foreach($media_img as $img):
					$image_id = $model->GetSingleValue(MEDIA_TABLE, 'name', array('id' => $img['id']));
					$path = FCPATH.'/uploads/'.$img['name'];
					if(file_exists($path)):  ?>
						<label class="hints_img_modal img_slt on_checked_image">
							<div class="img-container">
							  <input type="checkbox" class="img_check" name="img_check" id="myCheckbox1" value="<?=$img['id']?>"   style="display:none;"/>
							  <img imgs="<?=$img['id']?>" src="<?php echo base_url('uploads/'.$img['name'])?>">
							</div>
						</label> <?php 
		           endif;
				endforeach;
			endif;
			?>
		</div>
		<div class="row " id="dropzone_box" style="display:none;">
			<div class="col-md-12 user_avatar" >
				<div class="form-group">
					<form action="<?php echo base_url('admin/'.$mr.'/gallery/')?>" id="form" method="post" enctype="multipart/form-data">
						<div class="fallback">
							<div class="dropzone" id="myId" name="files" style="text-align: center"></div>
						</div>
					   <input type="hidden"  name="s" value="okk" >									
					</form>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer" >
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary media_add_image" type="button">Submit</button>
		</div>
      </div>
    </div>
  </div>
</div>-->
<input type="hidden" name="section_id" section_class="" id="section_id" value=""> 
<!-- content-wrapper ends -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>

<script>
Dropzone.autoDiscover = false;
    $("#myId").dropzone({
    url: "<?php echo base_url('admin/'.$mr.'/fileUpload')?>",
    addRemoveLinks : true,
	removeAllFiles:true,
    maxFilesize: 5,
    dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
    dictResponseError: 'Error uploading file!',
    success : function(file, response){
		let  obj = JSON.parse(response);
		let new_file_name = obj.name;
       $('#form').append('<input type="hidden" name="attachment_ids[]" src="'+new_file_name+'" class="attachment_ids" value="'+obj.id+'">');
       file.previewElement.getElementsByClassName("dz-remove")[0].setAttribute("data-id",obj.id);
    }, 
    removedfile: function(file) {
		var id =  file.previewElement.getElementsByClassName("dz-remove")[0].getAttribute("data-id");
		$("input.attachment_ids").each(function(){
					var exist_val = $(this).val();
					if(exist_val==id)
					{
						$(this).remove();
					}
				})
			var _ref;
			//return (ref = file.previewElement.parentElement.parentElement.closest("form#myform")) != null ? ref.remove() : void 0;
			return (ref = file.previewElement) != null ? ref.parentNode.removeChild(file.previewElement) : void 0;
	}
});
function getFileExtension(filename)
{
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
}
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
	} );
	
	$(document).on('click','button[type="submit"]',function(){
		var self = $(this);
		BtnLoading(self);
		self.parents('form').submit();
	})
	
$(document).on('click','.img_modal img',function(e){
	let src = $(this).attr('src');
	let imgs = $(this).attr('imgs');
	$(".img_show").html('<img imgs="'+imgs+'" src="'+src+'">');
	$('#image_id').val(imgs);
	
  });

/* $(document).on('click','.img_click',function(e){
	e.preventDefault();
	var display= $('.modal-dialog').css('display');	
	 $('.close').click();	
	if(display =='block')
	{
		//true cond
		$('.modal-dialog').css('display','none');
	}
	else
	{
		//false cond
		//$('.choose_file').css('display','block');
	}
})
 */
//hints model
$(document).on('click','.add_hints_img',function(e){
	e.preventDefault();
	var display = $('.hints_modal').css('display');	
	if(display =='block')
	{
		//true cond
	//	$('.img_upload').css('display','none');
	}
	else
	{
		//false cond
		$('.hints_modal').css('display','block');
	}
})

$(document).on('click','.add_hints_img',function(e){
	e.preventDefault();
	var display = $('.hints_file').css('display');	
	 $('.close').click();	
	if(display =='block')
	{
		//true cond
		$('.hints_file').css('display','none');
		$('.modal-dialog').css('display','none');
	}
	else
	{
		//false cond
		//$('.choose_file').css('display','block');
	}
})

$(document).on('click','.hints_img_modal img',function(e){
	let src = $(this).attr('src');
	let imgs = $(this).attr('imgs');
	//$(".hints_show_img").html('<img imgs="'+imgs+'" src="'+src+'">');
	$('#attachment_id').val(imgs);
	
  });


//model 2nd //

$(document).on('click','.add_questions',function(e){
	e.preventDefault();
	var display= $('.questions_modal').css('display');	
	if(display =='block')
	{
		//true cond
	//	$('.img_upload').css('display','none');
	}
	else
	{
		//false cond
		$('.questions_modal').css('display','block');
	}
})

$(document).on('click','.add_questions',function(e){
	e.preventDefault();
	alert('asdd');
	var display= $('.questions').css('display');	
	 $('.close').click();	
	if(display =='block')
	{
		//true cond
		$('.questions').css('display','none');
		$('.modal-dialog').css('display','none');
	}
	else
	{
		//false cond
		//$('.choose_file').css('display','block');
	}
})

$(document).on('click','.questions_img_modal img',function(e){
	let src = $(this).attr('src');
	let imgs = $(this).attr('imgs');
	let image_section = $("#section_id").val();
	$('.'+image_section).append('<img imgs="'+imgs+'" src="'+src+'">');
	$('#questions_id').val(imgs);
	
  });

//for multiple dropzone  and single dropzone add class 
$(document).on('click','.questions',function(){
	var myDropzone = Dropzone.forElement("#myId");
     myDropzone.removeAllFiles(true); 
	let section_id = $(this).attr('section_id');
	let section_class = $(this).attr('section_class');
	$("#section_id").val(section_id);
	$("#section_id").attr('section_class',section_class);
	let title = $(this).attr('title');
	$("#exampleModalScrollableTitle").html(title);
	$(this).addClass("section_box");
});
//for multiple dropzone add active class and css
$(document).on('click','.on_checked_image',function(e){
	    let checked_value = $(this).find("input").prop("checked");
		let section_class = $("#section_id").attr('section_class');
		//for single image select 
		if(section_class == 'section_file' || section_class == 'image'){
			if(checked_value == false){
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").removeAttr('checked');
				$(".img_check").css('display','none');
				$(".on_checked_image").removeClass('on_checked_image_box');
			}
			else{
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").prop('checked', true);
				$(this).find(".img_check").css('display','block');
				$(this).addClass('on_checked_image_box');
			}
		}
		//for multiple image select 
		else{
			    if(checked_value == false){
					//$(".img_check").prop('checked', false);
					$(this).find(".img_check").removeAttr('checked');
					$(this).find(".img_check").css('display','none');
					$(this).removeClass('on_checked_image_box');
				}
				else{
					//$(".img_check").prop('checked', false);
					$(this).find(".img_check").prop('checked', true);
					$(this).find(".img_check").css('display','block');
					$(this).addClass('on_checked_image_box');
				}
		}
	});


  //for media gallery and dropzone
  $(document).on('click','.media_add_image',function(e){
	      let section_class  = $("#section_id").attr('section_class');
	      let section_id  = $("#section_id").val();
		  	//for single image select 
		     if(section_class == 'section_file' || section_class == 'image'){
				 let checked_value = $('.img_check:checked').val();
				 let checked = $('.img_check:checked').prop("checked");
				 let key = "";
				 //for background
				 if(section_class == 'image'){
					key = "image";
				 }
				 if(section_class == 'section_file'){
					key = "file";
				 }
				 if(section_class == 'section_hints_2'){
					key = "hints[image_id][1]";
				 }
				 if(checked == true){
					 let image = $('.img_check:checked').next('img').attr('src');
					 let original_name = $('.img_check:checked').next('img').attr('original_name');
					 let fillename = getFileExtension(image);
					 const array = ["jpeg","jpg","png","gif"];
					 const isInArray = array.includes(fillename);
					//for image file valid
					 if(section_class == 'image'){
						 if(isInArray == false){
							swal("Only jpg/jpeg and png files are allowed!", {
								icon: "warning",
							}); 
							return false;
						 }
					 }
					 if(isInArray == true){
					 $('.'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+checked_value+'"><img src="'+image+'"></label></div></div>');
					 }
					 else{
						  $('.'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" title="'+original_name+'" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+checked_value+'"><img src="https://via.placeholder.com/150/?Text='+original_name+'/Ohttps://placeholder.com/"></label></div></div>');
						  
					  }
				 }else{
					 let value = parseInt($('.attachment_ids').last().val());
					 if(value > 0){
					 let image_url = '<?php echo base_url('uploads');?>/';
					 let image = image_url+$('.attachment_ids').last().attr('src'); 
					 let original_name = $('.attachment_ids').last().attr('src'); 
					 let fillename = getFileExtension(image);
					 const array = ["jpeg","jpg","png","gif"];
					 const isInArray = array.includes(fillename);
					 const videoarray = ["mp4","3gp"];
					 const videoisInArray = videoarray.includes(fillename);
					 //for image file valid
					 if(section_class == 'image'){
						 if(isInArray == false){
							swal("Only jpg/jpeg and png files are allowed!", {
								icon: "warning",
							}); 
							return false;
						 }
					 }
                    if(isInArray == true){
					     $('.'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" title="'+original_name+'" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+value+'"><img src="'+image+'"></label></div></div>');
					  }else{
						  $('.'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" title="'+original_name+'" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+value+'"><img src="https://via.placeholder.com/150/?Text='+original_name+'/Ohttps://placeholder.com/"></label></div></div>');
						  
					  }
					 }
				 }
			 }
			 else{
				   $('.img_check:checked').each(function () {
						var id = $(this).val();
						let image = $(this).next('img').attr('src');
						let fillename = getFileExtension(image);
						 const array = ["jpeg","jpg","png","gif"];
						 const isInArray = array.includes(fillename);
						 if(isInArray == true){
						  $('.'+section_class+' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions['+section_id+'][image_ids][]" value="'+id+'"><img src="'+image+'"></label></div></div>');
						 }
						$(this).prop("checked", false);
					});
					$('.attachment_ids').each(function () {
						var id = $(this).val();
						let image_url = '<?php echo base_url('uploads');?>/';
						let image = image_url+$(this).attr('src');
						let fillename = getFileExtension(image);
						const array = ["jpeg","jpg","png","gif"];
						const isInArray = array.includes(fillename);
						if(isInArray == true){
						$('.'+section_class+' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions['+section_id+'][image_ids][]" value="'+id+'"><img src="'+image+'"></label></div></div>');
						}
					}); 
			 }
			//let img_count = $('.image_ids').length;
			//if(img_count > 0){
			//	$('.update_button').css('display','block');
			//}
			$('.adventures_gallery_box').attr('style','display:block;');
			    var myDropzone = Dropzone.forElement("#myId");
                myDropzone.removeAllFiles(true); 
				$(".img_check").css('display','none');
				$(".img_check").prop("checked", false);
				$(".on_checked_image").removeClass('on_checked_image_box');
				$('.attachment_ids').remove();
				$('.close').click();
   });
   
$(document).on('click','.media_add_image_new',function(e){
	$(this).addClass('active');
    // for remove class and checked value
	$(".img_check").prop("checked", false);
	$(".img_check").css('display','none');
	$(".on_checked_image").removeClass('on_checked_image_box');
	$(".show_media_images").removeClass('active');
	$('#media_box').css('display','none');
	$('#dropzone_box').css('display','block');
})
$(document).on('click','.show_media_images',function(e){
	$(this).addClass('active');
	$(".media_add_image_new").removeClass('active');
	$('#media_box').css('display','block');
	$('#dropzone_box').css('display','none');
});
	//on click remove image
	$(document).on('click', '.cross_icon_add', function(e) {
		e.preventDefault();
		$(this).parents(".image_section").remove();
	});
</script>
<?= $this->endSection() ?>