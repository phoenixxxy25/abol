@extends('layouts.app')
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

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
						<h1>Create</h1>
						@if (count($errors) > 0)
						  <div class="alert alert-danger">
						    <ul>
						      @foreach ($errors->all() as $error)
						        <li>{{ $error }}</li>
						      @endforeach
						    </ul>
						  </div>
						@endif
						{!! Form::open(['route' => 'post.store', 'files' => true]) !!}
						    <div class="form-group">
						        {!! Form::label('Заголовок') !!}
						        {!! Form::text('title', null, ['class'=>'form-control']) !!}
						    </div>
						    <div class="form-group">
						        {!! Form::label('Краткое описание') !!}
						        {!! Form::textarea('excerpt', null, ['class'=>'form-control']) !!}
						    </div>
						    <div class="form-group">
						        {!! Form::label('Полное описание') !!}
						        {!! Form::textarea('content', null, ['class'=>'form-control']) !!}
						    </div>
							<div class="form-group">
								{!! Form::label('Тэги') !!}<span>(выберите уже существующие, или напишите через запятую в следующем поле)</span>
							    <div class="multiselect">
							        <div class="selectBox" onclick="showCheckboxes()">
							            <select>
							                <option>Select an option</option>
							            </select>
							            <div class="overSelect"></div>
							        </div>
							        <div id="checkboxes">
										@foreach($tags as $tag)
							            <label for="t{!!$tag->id!!}">
							            	<input type="checkbox" name="t{!!$tag->id!!}" name="t{!!$tag->id!!}"/>{!!$tag->title!!}
						            	</label>
							            @endforeach
							        </div>
							    </div>
							</div>
						    <div class="form-group">
						        {!! Form::label('Новые теги') !!}
						        {!! Form::text('newtags', null, ['class'=>'form-control', 'placeholder'=>'Не обязательно']) !!}
						    </div>
							<div class="form-group">
								{!! Form::label('Картинки') !!}
								{!! Form::file('postfiles[]', ['multiple' => 'multiple', 'class'=>'form-control']) !!}
							</div>
							<div class="form-group">
								{!! Form::submit('Create', ['class'=>'btn btn-primary']) !!}
							</div>
						{!! Form::close() !!}
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
@endsection