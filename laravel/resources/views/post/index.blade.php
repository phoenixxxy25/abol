@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

					@if (!Auth::guest())
					<br>{!! link_to_route('post.create', 'Добавить новое объявление') !!}
					@endif
						@foreach($posts as $post)
							<article>
								<a href="{{action('PostController@show',['id'=>$post->id])}}"><h2>{{ $post->title }}</h2></a>
								<p>
									{!! $post->excerpt !!}
								</p>
							</article>
						@endforeach
                </div>
            </div>
        </div>
    </div>  
</div>
@stop
