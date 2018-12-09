@extends('layouts.app')

@section('content')
	<form action="{{route('boards.update', ['board'=>$b->id, 'page'=>$page])}}" method="post">
		@csrf
		@Method('PATCH')
		<label>제목
			<input type="text" name="title" value="{{$board->title}}">
			<span>
				@if($errors->has('title'))
					{{$errors->first('title')}}
				@endif
			</span>
		</label>
		<label>내용
			<textarea name="content">{{$board->content}}</textarea>
			<span>
				@if($errors->has('content'))
					{{$errors->first('content')}}
				@endif
			</span>			
		</label>
		<button class="btn btn-primary" onclick="location.href='{{route('boards.edit', ['page'=>$page])}}'">수정하기</button>
	</form>
	

@endsection