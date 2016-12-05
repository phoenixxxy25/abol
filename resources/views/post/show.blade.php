@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
    @if (!Auth::guest())
    	@if (Auth::user()->group > 0 || Auth::user()->login == $post->author )
{{ Form::open(array('url' => 'post/' . $post->id, 'class' => 'pull-right')) }}
        {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
{{ Form::close() }}
<a class="btn pull-right btn-warning" style="margin-right: 3px;"  href="{{action('PostController@edit',['id'=>$post->id])}}">Редактировать</a>  
		@endif
	@endif


<h2>{{$post->title}}</h2>
<small>Дата: {{$post->updated_at}} | Автор: <a href="{{action('HomeController@user',['user'=>$post->author])}}">{{$post->author}}</a></small>
<div class="panel-body">
{!!$post->content!!}
<div class="panel-body">
@foreach($images as $image)
        <div>
        	{{Html::image('/images/'.$image->post_id.'/'.$image->filename, $alt="Photo", $attributes = array('width'=>'650', 'height'=>'380', 'style'=>'display: inline;')) }}
        </div>
@endforeach
</div>
@if (!Auth::guest())
{!! Form::open(array('url'=>'post/'. $post->id, 'method'=>'POST', 'id'=>'myform', 
  'action'=>'PostController@storecomment')) !!}

<div class="form-group" >
	<textarea id="meh" class="form-control showbutton"> </textarea> 
</div>
<div id="comm_control" class="form-group buttoncomment">
	<button type="button" class="btn btn-success" id="sendComm" onclick="finsendComm()" >SEND</button>
</div>
{!! Form::close() !!}
@endif
<div id="msg">Комментарии:</div>
<div class="panel-body" id="commentspool">
	@foreach($comments as $comment)
		<div class="mycomment" id="mycomm{!! $comment->id !!}">
			
        @if (!Auth::guest())
        	@if (Auth::user()->group > 0 || Auth::user()->login == $comment->author)
			<div class="pull-right">
				<button type="button" onclick="editComm({!! $comment->id !!})" class="btn btn-warning">редактировать</button> 
				<button type="button" class="btn btn-danger" onclick="delComm({!! $comment->id !!})">удалить</button>
			</div>
			@endif
		@endif
		@if (Auth::guest() || Auth::user()->login != $comment->author)
			<a href="{{action('HomeController@user',['user'=>$comment->author])}}"><h4>{{ $comment->author }}</h4></a>
		@else
			<h4>{{ $comment->author }}</h4>
		@endif
			<p id="comm_text_{!! $comment->id !!}">
				{!! $comment->message !!}
			</p>
		</div>
	@endforeach
</div>

<script src="/js/ajx.jquery.min.js"></script>
<script type="text/javascript">

function finsendComm(){
	var message = $('#meh').val();
	console.log(message);
	var postid = {{$post->id}};
	$.ajax({
	   type:'POST',
	   url:'{{$post->id}}',
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
		url:'{{$post->id}}/'+cid,
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
		url:'{{$post->id}}/'+cid+'/edit',
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
	// 	url:'{{$post->id}}/'+cid+'/edit',
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

@stop