@extends('layouts.app')

@section('content')
<table class="table table-striped">
	<tr>
		<th>제목</th>
		<th>작성자</th>
		<th>조회수</th>
	</tr>
@foreach($msgs as $msg)
	<tr>
		<td>
			<a href="{{route('boards.show', ['board'=>$msg->id, 'page'=>$page])}}" >
				{{$msg->title}}
			</a>
		</td>
		<td>{{$msg->user->name}}</td>
		<td>{{$msg->hits}}</td>
	</tr>
@endforeach
</table>
<input type="button" value="글쓰기" onclick="location.href='{{route('boards.create')}}'" class="btn btn-danger">
{{$msgs->links()}}
@endsection