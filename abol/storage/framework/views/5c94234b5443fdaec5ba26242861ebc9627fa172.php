<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

					<?php if(!Auth::guest()): ?>
					<br><?php echo link_to_route('post.create', 'create new'); ?>

					<?php endif; ?>
						<?php foreach($posts as $post): ?>
							<article>
								<a href="<?php echo e(action('PostController@show',['id'=>$post->id])); ?>"><h2><?php echo e($post->title); ?></h2></a>
								<p>
									<?php echo $post->excerpt; ?>

								</p>
							</article>
						<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>