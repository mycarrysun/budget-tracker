@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs card-header-tabs">
							<li class="nav-item">
								<a class="nav-link {{request()->input('view') === 'd30' ? 'active' : ''}}"
								   href="{{route('projection', array_merge(request()->all(), ['view' => 'd30']))}}">30 Days</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{request()->input('view') === 'm3' ? 'active' : ''}}"
								   href="{{route('projection', array_merge( request()->all(),['view' => 'm3']))}}">3 Months</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{request()->input('view') === 'm6' ? 'active' : ''}}"
								   href="{{route('projection', array_merge(request()->all(), ['view' => 'm6'] ))}}">6 Months</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{request()->input('view') === 'm12' ? 'active' : ''}}"
								   href="{{route('projection', array_merge(request()->all(), ['view' => 'm12']))}}">12 Months</a>
							</li>
						</ul>
					</div>

					<form action="{{route('projection')}}"
					      method="GET">

						<div class="card-body">
							<div class="form-group">
								<label for="start-amt">Starting Amount</label>
								<input type="number" id="start-amt"
								       name="start_amt" class="form-control" step="0.01"
								       @if(request()->input('start_amt'))
								       value="{{request()->input('start_amt')}}"
										@endif
								/>
							</div>

							<input type="hidden" name="view" value="{{request()->input('view') ?: 'd30'}}"/>

							<button type="submit" class="btn btn-primary">Refresh</button>
						</div>

					</form>

					<projection-graph></projection-graph>

				</div>
			</div>
		</div>
	</div>
@endsection