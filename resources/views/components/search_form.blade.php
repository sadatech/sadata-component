@section('search-form')
	<?php $id = $id ?? 'searchForm' ?>
	{{ Form::open(['method' => 'get', 'id' => $id]) }}
		<div class="row">
			@foreach ($fields ?? [] as $row)
				<div class="{{ is_array($row) ? ($row['class'] ?? 'col') : 'col' }}">
					{!! is_array($row) ? $row['field'] : $row !!}
				</div>
			@endforeach
			<div class="col">
				<div class="row">
					<div class="col-md-12"><label class="col-form-label"> &nbsp; </label></div>
					<div class="col-md-12">
						<div class="btn-group">
							<button type="button" class="btn m-btn--square btn-primary" onclick="submitForm_{{ $id }}()"><i class="fa fa-search"></i> Search</button>
							<button type="button" class="btn m-btn--square btn-danger" onclick='resetForm($("#{{ $id }}"), {!! json_encode($fields) !!}); $(this).siblings(".btn-primary").click()'><i class="fa fa-times"></i> Reset</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}

<script type="text/javascript">
	function submitForm_{{ $id }}(){
		var form = $('#{{ $id }}'),
			url = "{{ $url }}";

		dtOptions_{{ $tableTarget }}.ajax.url = url + '?' + form.serialize();
		dataTableFilter_{{ $tableTarget }}();
	}
</script>

@stop