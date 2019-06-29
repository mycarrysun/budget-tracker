@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<div>
							<div>{{$title}}</div>
							@if(request()->has('trash'))
								<a href="{{route($plural.'.index')}}">
									Go Back
								</a>
							@else
								<a href="{{route($plural.'.index', ['trash' => 1])}}">
									View Deleted
								</a>
							@endif
						</div>

						<a href="{{route($plural.'.create')}}" class="btn btn-primary">New</a>
					</div>

					@if(count($items))
						<ul class="list-group list-group-flush">
							@foreach($items as $item)
								<li class="list-group-item">
									<div class="d-flex align-items-center justify-content-between">
										<div>
											<h5>
												<a href="{{route($plural.'.show', $item)}}">{{$item->name}}</a>
											</h5>
											<div>Date: {{Carbon\Carbon::parse($item->starts_at)->format('M d, Y')}}</div>
											<div>Repeats: {{$item->repeat_text}}</div>
										</div>
										<div class="d-flex flex-column align-items-end">
											<h5>{{money_format(MONEY_FORMAT, $item->amount)}}</h5>
											@if($item->deleted_at)
												<form action="{{route($plural.'.restore', $item)}}" method="POST">
													@csrf
													<button onclick="return confirm('Are you sure you want to restore this {{$singular}}?')"
													        type="submit"
													        class="btn btn-info">Restore
													</button>
												</form>
											@else
												<a href="{{route($plural.'.edit', $item)}}"
												   class="btn btn-warning"
												>Edit</a>
											@endif

										</div>
									</div>
								</li>
							@endforeach
						</ul>
					@else
						<div class="card-body">No {{$plural}} found.</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection