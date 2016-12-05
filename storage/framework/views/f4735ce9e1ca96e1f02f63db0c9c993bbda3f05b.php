<style type="text/css">

@media  screen and (min-width: 768px) {
    #adv-search {
        width: 600px;
        margin: 0 auto;
    }

}



</style>



<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(url('/search/result')); ?>" class="form-horizontal" role="form">
                	<div class="input-group" id="adv-search">
		                <input type="text" class="form-control" id="searchval" name="searchobj" placeholder="Поиск" />
		                <div class="input-group-btn">
		                    <div class="btn-group" role="group">
		                            <select style="width: 160px" class="form-control" id="selectSearch">
                                        <option value="0" selected>фильтры</option>
                                        <option value="1">автор</option>
                                        <option value="2">контент</option>
                                        <option value="3">адрес</option>
                                        <option value="4">тэги</option>
                                        <option value="5">текст объявления</option>
                                    </select>
                            </div>
                    	<input type="button" onclick="searchPost()" class="btn btn-primary" value="Поиск"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </form>
            </div>
        </div>

<div class="panel-body">
<h1 id="msg"><?php echo e($pimp); ?></h1>

</div>
<div id="resultpool" class="panel-body">
		<?php foreach($result as $post): ?>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">

function searchPost(){
	var filter = $('#selectSearch').val();

	var searchval = $('#searchval').val();
	console.log(filter);
	$.ajax({
	   type:'POST',
	   url:'/search/result',
	   data: {searchval: searchval, filter: filter, _token: "<?php echo csrf_token()?>"},
	   success:function(data){
	      $("#msg").html(data.msg);
	      if(data.sresult != null){
		    	$.each(data.sresult, function(index, value) {
	    			getSrchResultItem(value.id, value.title, value.content);
	    			console.log(value.content);
				}); 
	  		}
   		}
	});
}

function getSrchResultItem(id, title, text)
{
			var tag =	'<article><a href="http://laravel:808/post/'+id+'"><h2>'+title+'</h2></a><p>'+text+'</p></article>';
			$('#resultpool').append(tag);
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>