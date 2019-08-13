{{ Form::open(['id' => "fb_filter_$target"]) }}
	<ul class="m-portlet__nav">
		<li class="m-portlet__nav-item">
			{{ 
				Form::dateInput('start_date', null, [
					'useLabel' => false,
					'elOptions' => [
						'placeholder' => 'Start Date',
						'style' => 'margin-bottom:-1rem',
						'id' => "fb_filter_start_date_$target"
					],
					'pluginOptions' => [
						'format' => 'yyyy-mm',
						'viewMode' => 'months',
						'minViewMode' => 'months',
						'orientation' => 'bottom left'
					]
				])
			}}
		</li>
		<li class="m-portlet__nav-item">
			{{ 
				Form::dateInput('to_date', null, [
					'useLabel' => false,
					'elOptions' => [
						'placeholder' => 'To Date',
						'style' => 'margin-bottom:-1rem',
						'id' => "fb_filter_end_date_$target"
					],
					'pluginOptions' => [
						'format' => 'yyyy-mm',
						'viewMode' => 'months',
						'minViewMode' => 'months',
						'orientation' => 'bottom left'
					]
				])
			}}
		</li>
		<li class="m-portlet__nav-item">
			<button class="m-portlet__nav-link btn btn-success m-btn m-btn--air">
				<i class="fa fa-filter fa-fw"></i> Filter
			</button>
		</li>
	</ul>
{{ Form::close() }}

@push('additional-js')
	<script type="text/javascript">
		$('#{{ "fb_filter_$target" }}').submit(function(e){
			e.preventDefault();

			var submitButton = $(this).find('button');
			submitButton.addClass('m-loader m-loader--light m-loader--left disabled')
						.find('i').attr('class', '');

			setTimeout(function() {
				submitButton.removeClass('m-loader m-loader--light m-loader--left disabled')
							.find('i').attr('class', 'fa fa-filter fa-fw');
			}, 500);

			setChart("{{ $target }}", "{{ $url ?? '' }}", $(this).serialize())
		})


	</script>
@endpush