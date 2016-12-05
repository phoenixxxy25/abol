<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                <?php if(count($errors) > 0): ?>
                  <div class="alert alert-danger">
                    <ul>
                      <?php foreach($errors->all() as $error): ?>
                        <li><?php echo e($error); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
                <?php if(Request::session()->get('edit_post_error')): ?>
                <h1 class="h1Err"><?php echo e(Session::pull('edit_post_error')); ?></h1>
                <?php endif; ?>
                <?php echo e(Form::model($post, array('route' => array('post.update', $post->id), 'files' => true,  'method' => 'PUT'))); ?>

                    <div class="form-group">
                        <?php echo Form::label('Заголовок'); ?>

                        <?php echo Form::text('title', $post->title, ['class'=>'form-control']); ?>

                    </div>
                    <div class="form-group">
                        <?php echo Form::label('Краткое описание'); ?>

                        <?php echo Form::textarea('excerpt', $post->excerpt, ['class'=>'form-control']); ?>

                    </div>
                    <div class="form-group">
                        <?php echo Form::label('Полное описание'); ?>

                        <?php echo Form::textarea('content', $post->content, ['class'=>'form-control']); ?>

                    </div>
                    <div class="form-group">
                        <?php echo Form::label('Картинки'); ?>

                        <span style="font-size: small">(не больше 10!)</span>
                        <?php echo Form::file('postfiles[]', ['multiple' => 'multiple', 'class'=>'form-control']); ?>

                    </div>
                    <div class="form-group">
                        <h2>УДАЛИТЬ:</h2>
                        <?php foreach($files as $image): ?>
                            <div id="imtodel<?php echo e($image->id); ?>" class="form-group">
                                <div class="checkbox">
                                    <?php echo e(Html::image('/images/'.$image->post_id.'/'.$image->filename, $alt="Photo", $attributes = array('width'=>'160', 'height'=>'80'))); ?>

                                    <label><input type="checkbox" onclick="cbtodel(<?php echo e($image->id); ?>)" id="pic<?php echo e($image->id); ?>" name="pic<?php echo e($image->id); ?>" value="1" > <?php echo e($image->filename); ?></label>
                                    <span id="dlabel<?php echo e($image->id); ?>" class="spanImgToDel">УДАЛИТЬ</span>
                                 </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php echo e(Form::submit('Edit!', array('class' => 'btn btn-primary'))); ?>


                <?php echo e(Form::close()); ?>


                
                </div>
            </div>
        </div>  
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
function cbtodel(id)
{

    console.log('start');
    if($("#pic"+id).prop("checked")){
        $("#imtodel"+id).css('background-color', '#ffcccc');
        $("#imtodel"+id).css('padding', '5px');
        $("#dlabel"+id).css('display', 'inline');
    } 
    else {
        $("#imtodel"+id).css('background-color', 'white');
        $("#imtodel"+id).css('padding', '0');
        $("#dlabel"+id).css('display', 'none');
    }
    console.log('fin');
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>