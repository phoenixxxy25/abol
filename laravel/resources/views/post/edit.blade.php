@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                @if(Request::session()->get('edit_post_error'))
                <h1 class="h1Err">{{Session::pull('edit_post_error')}}</h1>
                @endif
                {{ Form::model($post, array('route' => array('post.update', $post->id), 'files' => true,  'method' => 'PUT')) }}
                    <div class="form-group">
                        {!! Form::label('Заголовок') !!}
                        {!! Form::text('title', $post->title, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Краткое описание') !!}
                        {!! Form::textarea('excerpt', $post->excerpt, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Полное описание') !!}
                        {!! Form::textarea('content', $post->content, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Картинки') !!}
                        <span style="font-size: small">(не больше 10!)</span>
                        {!! Form::file('postfiles[]', ['multiple' => 'multiple', 'class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <h2>УДАЛИТЬ:</h2>
                        @foreach($files as $image)
                            <div id="imtodel{{$image->id}}" class="form-group">
                                <div class="checkbox">
                                    {{Html::image('/images/'.$image->post_id.'/'.$image->filename, $alt="Photo", $attributes = array('width'=>'160', 'height'=>'80')) }}
                                    <label><input type="checkbox" onclick="cbtodel({{$image->id}})" id="pic{{$image->id}}" name="pic{{$image->id}}" value="1" > {{$image->filename}}</label>
                                    <span id="dlabel{{$image->id}}" class="spanImgToDel">УДАЛИТЬ</span>
                                 </div>
                            </div>
                        @endforeach
                    </div>
                    {{ Form::submit('Edit!', array('class' => 'btn btn-primary')) }}

                {{ Form::close() }}

                
                </div>
            </div>
        </div>  
    </div>
</div>

<script src="/js/jquery-1.10.2.min.js" ></script>
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
@endsection