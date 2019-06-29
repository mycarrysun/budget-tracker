@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						@if(isset($item))
							<span>Editing: {{$item->name}}</span>
							<form action="{{route($plural.'.destroy', $item)}}" method="POST">
								@method('DELETE')
								@csrf
								<button onclick="return confirm('Are you sure you want to delete this {{$singular}}?')"
								        type="submit"
								        class="btn btn-danger">Delete
								</button>
							</form>
						@else
							<span>New {{$singular}}</span>
						@endif
					</div>

					<form @if(isset($item))
					      action="{{route($plural.'.update', $item)}}"
					      @else
					      action="{{route($plural.'.store')}}"
					      @endif
					      method="POST">
						@method(isset($item) ? 'PUT' : 'POST')
						@csrf

						<div class="card-body">
							<div class="form-group">
								<label for="transaction-name">Name</label>
								<input id="transaction-name" name="name"
								       class="form-control"
								       @if(isset($item))
								       value="{{$item->name}}"
										@endif
								/>
							</div>

							<div class="form-group">
								<label for="transaction-amount">Amount</label>
								<input id="transaction-amount" name="amount"
								       class="form-control" min="0" step="0.01"
								       @if(isset($item))
								       value="{{$item->amount}}"
										@endif
								/>
							</div>

							<div class="form-group">
								<label for="transaction-starts_at">Date</label>
								<input id="transaction-starts_at" name="starts_at"
								       class="form-control" type="date"
								       @if(isset($item))
								       value="{{$item->starts_at}}"
										@endif
								/>
							</div>

							<div class="form-check">
								<input id="transaction-repeat" name="repeat"
								       class="form-check-input" type="checkbox"
								       @if(isset($item) && $item->repeat)
								       checked
								       @endif
								       onchange="toggleInterval(this)"
								>
								<label for="transaction-repeat" class="form-check-label">
									Repeat?
								</label>
							</div>

							<div class="interval-container"
							     @if(!isset($item) || !$item->repeat)
							     style="display:none"
									@endif
							>
								<div class="form-group">
									<label for="transaction-interval_type">Frequency</label>
									<select id="transaction-interval_type" name="interval_type"
									        class="form-control">
										@foreach((new App\Expense)->intervalOptions() as $option)
											<option value="{{$option['value']}}"
											        @if(isset($item) && $item->interval_type === $option['value'])
											        selected
													@endif
											>{{$option['label']}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label for="transaction-interval_value">Repeats when?</label>
									<input id="transaction-interval_value" name="interval_value"
									       class="form-control"
									       @if(isset($item))
									       value="{{$item->interval_value}}"
											@endif
									/>
								</div>
							</div>

						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
      function toggleInterval(el) {
        let cont = document.querySelector('.interval-container')
        cont.style.display = el.checked ? '' : 'none'
      }
	</script>
@endsection