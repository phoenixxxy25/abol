<?php $__env->startSection('content'); ?>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
    <?php if(!Auth::guest()): ?>
    	<?php if(Auth::user()->group > 0 || Auth::user()->login == $post->author ): ?>
<?php echo e(Form::open(array('url' => 'post/' . $post->id, 'class' => 'pull-right'))); ?>

        <?php echo e(Form::hidden('_method', 'DELETE')); ?>

        <?php echo e(Form::submit('Удалить', array('class' => 'btn btn-danger'))); ?>

<?php echo e(Form::close()); ?>

<a class="btn pull-right btn-warning" style="margin-right: 3px;"  href="<?php echo e(action('PostController@edit',['id'=>$post->id])); ?>">Редактировать</a>  
		<?php endif; ?>
	<?php endif; ?>


<h2><?php echo e($post->title); ?></h2>
<small>Дата: <?php echo e($post->updated_at); ?> | Автор: <a href="<?php echo e(action('HomeController@user',['user'=>$post->author])); ?>"><?php echo e($post->author); ?></a></small>
<div class="panel-body">
<?php echo $post->content; ?>

<div class="panel-body">
<?php foreach($images as $image): ?>
        <div>
        	<?php echo e(Html::image('/images/'.$image->post_id.'/'.$image->filename, $alt="Photo", $attributes = array('width'=>'650', 'height'=>'380', 'style'=>'display: inline;'))); ?>

        </div>
<?php endforeach; ?>
</div>
<?php if(!Auth::guest()): ?>
<?php echo Form::open(array('url'=>'post/'. $post->id, 'method'=>'POST', 'id'=>'myform', 
  'action'=>'PostController@storecomment')); ?>


<div class="form-group" >
	<textarea id="meh" class="form-control showbutton"> </textarea> 
</div>
<div id="comm_control" class="form-group buttoncomment">
	<button type="button" class="btn btn-success" id="sendComm" onclick="finsendComm()" >SEND</button>
</div>
<?php echo Form::close(); ?>

<?php endif; ?>
<div id="msg">Комментарии:</div>
<div class="panel-body" id="commentspool">
	<?php foreach($comments as $comment): ?>
		<div class="mycomment" id="mycomm<?php echo $comment->id; ?>">
			
        <?php if(!Auth::guest()): ?>
        	<?php if(Auth::user()->group > 0 || Auth::user()->login == $comment->author): ?>
			<div class="pull-right">
				<button type="button" onclick="editComm(<?php echo $comment->id; ?>)" class="btn btn-warning">редактировать</button> 
				<button type="button" class="btn btn-danger" onclick="delComm(<?php echo $comment->id; ?>)">удалить</button>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(Auth::guest() || Auth::user()->login != $comment->author): ?>
			<a href="<?php echo e(action('HomeController@user',['user'=>$comment->author])); ?>"><h4><?php echo e($comment->author); ?></h4></a>
		<?php else: ?>
			<h4><?php echo e($comment->author); ?></h4>
		<?php endif; ?>
			<p id="comm_text_<?php echo $comment->id; ?>">
				<?php echo $comment->message; ?>

			</p>
		</div>
	<?php endforeach; ?>
</div>

<script src="/js/ajx.jquery.min.js"></script>
<script type="text/javascript">

function finsendComm(){
	var message = $('#meh').val();
	console.log(message);
	var postid = <?php echo e($post->id); ?>;
	$.ajax({
	   type:'POST',
	   url:'<?php echo e($post->id); ?>',
	   data: {mehmess: message, _token: "<?php echo csrf_token()?>"},
	   success:function(data){
	      $("#msg").html(data.msg);
	      	sendmessage(data.comment, data.name, data.cid);
	  		$('#meh').text("");
			$('#meh').val("");
	   		}
	});
}

function delComm(cid){
	$.ajax({
		type:'POST',
		url:'<?php echo e($post->id); ?>/'+cid,
		data: {meh: "ara"},
		success:function(data){
			console.log(data.cid + " nikavo ne prosim!");
			$('#mycomm'+data.cid).remove();
		}
	});
}

function editCommSend(cid){

	var tms = $('#meh').text();
	console.log(tms);
	var message = $('#meh').val();
	$.ajax({
		type:'POST',
		url:'<?php echo e($post->id); ?>/'+cid+'/edit',
		data: {mehmess: message},
		success:function(data){
			$('#comm_text_'+cid).text(data.text);
			cancelEditionComm(cid);
		}
	});
}

function editComm(cid){

	var mem = $('#comm_text_'+cid).text().replace(/\s+/g, ' ');
	$('#meh').text(mem);

	$('#meh').val(mem);
	$('#sendComm').remove();
	$('#comm_control').html('<button id="canceleditcomm'+cid+'" onclick="cancelEditionComm('+cid+')" type="button" class="btn btn-danger">OTMEHA</button><button id="editcomm'+cid+'" onclick="editCommSend('+cid+')" type="button" onclick="" class="btn btn-success">EDIT</button>');

	// $.ajax({
	// 	type:'POST',
	// 	url:'<?php echo e($post->id); ?>/'+cid+'/edit',
	// 	data: {mehmess: message},
	// 	success:function(data){
	// 		console.log(data.cid + " nikavo ne prosim!");
	// 	}
	// });
}


function cancelEditionComm(cid)
{
	$('#meh').text("");
	$('#meh').val("");
	$('#editcomm'+cid).remove();
	$('#canceleditcomm'+cid).remove();

	$('#comm_control').html('<button type="button" class="btn btn-success" id="sendComm" onclick="finsendComm()" >SEND</button>');
}

function sendmessage( text, user, cid) {
	var tag = '<div class="mycomment" id="mycomm'+cid+'"><div class="pull-right"><button type="button" onclick="editComm('+cid+')" class="btn btn-warning">редактировать</button><button type="button" class="btn btn-danger" onclick="delComm('+cid+')">удалить</button></div><h3>'+user+'</h3><p id="comm_text_'+cid+'">'+text+'</p></div>';
	$('#commentspool').prepend(tag);
}
</script>

                </div>
	            </div>
	        </div>
	    </div>  
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>