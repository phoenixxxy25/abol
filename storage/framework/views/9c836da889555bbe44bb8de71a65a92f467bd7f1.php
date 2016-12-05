<style>
    .multiselect {
        width: 200px;
    }
    .selectBox {
        position: relative;
    }
    .selectBox select {
        width: 100%;
        font-weight: bold;
    }
    .overSelect {
        position: absolute;
        left: 0; right: 0; top: 0; bottom: 0;
    }
    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }
    #checkboxes label {
        display: block;
    }
    #checkboxes label:hover {
        background-color: #1e90ff;
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
						<h1>Create</h1>
						<?php if(count($errors) > 0): ?>
						  <div class="alert alert-danger">
						    <ul>
						      <?php foreach($errors->all() as $error): ?>
						        <li><?php echo e($error); ?></li>
						      <?php endforeach; ?>
						    </ul>
						  </div>
						<?php endif; ?>
	                	<?php if(Request::session()->get('create_post_error')): ?>
		                	<h1 class="h1Err"><?php echo e(Session::pull('create_post_error')); ?></h1>
		                <?php endif; ?>
						<?php echo Form::open(['route' => 'post.store', 'files' => true]); ?>

						    <div class="form-group">
						        <?php echo Form::label('Заголовок'); ?>

						        <?php echo Form::text('title', null, ['class'=>'form-control']); ?>

						    </div>
						    <div class="form-group">
						        <?php echo Form::label('Краткое описание'); ?>

						        <?php echo Form::textarea('excerpt', null, ['class'=>'form-control']); ?>

						    </div>
						    <div class="form-group">
						        <?php echo Form::label('Полное описание'); ?>

						        <?php echo Form::textarea('content', null, ['class'=>'form-control']); ?>

						    </div>
							<div class="form-group">
								<?php echo Form::label('Тэги'); ?><span>(выберите уже существующие, или напишите через запятую в следующем поле)</span>
							    <div class="multiselect">
							        <div class="selectBox" onclick="showCheckboxes()">
							            <select>
							                <option>Select an option</option>
							            </select>
							            <div class="overSelect"></div>
							        </div>
							        <div id="checkboxes">
										<?php foreach($tags as $tag): ?>
							            <label for="t<?php echo $tag->id; ?>">
							            	<input type="checkbox" name="t<?php echo $tag->id; ?>" name="t<?php echo $tag->id; ?>"/><?php echo $tag->title; ?>

						            	</label>
							            <?php endforeach; ?>
							        </div>
							    </div>
							</div>
						    <div class="form-group">
						        <?php echo Form::label('Новые теги'); ?>

						        <?php echo Form::text('newtags', null, ['class'=>'form-control', 'placeholder'=>'Не обязательно']); ?>

						    </div>
							<div class="form-group">
								<?php echo Form::label('Картинки'); ?>

								<?php echo Form::file('postfiles[]', ['multiple' => 'multiple', 'class'=>'form-control']); ?>

							</div>
							<div class="form-group">
								<?php echo Form::submit('Create', ['class'=>'btn btn-primary']); ?>

							</div>
						<?php echo Form::close(); ?>

		            </div>
		        </div>
		    </div>
		</div>  
	</div>
<script>
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>