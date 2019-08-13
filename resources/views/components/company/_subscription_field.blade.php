@php

$editable = $editable ?? true;

@endphp

@component('components.accordion', ['id' => 'subscribe_section', 'title' => 'Subscription ' . ($editable ? 'Setting' : 'Info'), 'icon' => 'flaticon-notepad'])
	<div class="row">
		<div class="col-md-3"> <strong>Subscribe Type</strong> </div>
		<div class="col-md-3">
			{{ 
				Form::select2Input('subscribe_type', $company->subscribe_type ?? old('subscribe_type'), App\Models\Main\Company::subscribeTypeList(), [
					'useLabel' => false,
					'pluginOptions' => [
						'minimumResultsForSearch' => -1
					],
					'elOptions' => array_merge($editable ? [] : [
						'disabled' => 'disabled'
					])
				]) 
			}}
		</div>
		<div class="col-md-6">
			{{ 
				Form::select2Input('subscribe_period', $company->subscribe_period ?? old('subscribe_period'), ['PER MONTH' => 'Per Month', 'PER YEAR' => 'Per Year'], [
					'useLabel' => false,
					'pluginOptions' => [
						'minimumResultsForSearch' => -1
					],
					'elOptions' => array_merge($editable ? [] : [
						'disabled' => 'disabled'
					])
				]) 
			}}
		</div>
	</div>

	{{ 
		Form::textInput('subscribe_price', currency_format($company->subscribe_price), [
			'elOptions' => array_merge($editable ? [] : [
				'disabled' => 'disabled'
			])
		]) 
	}}

	{{ 
		Form::textInput('bill_date', $company->bill_date ?? old('bill_date'), [
			'addons' => ['position' => 'left', 'text' => '', 'class' => 'input-group-text bill_addons'],
			'elOptions' => array_merge($editable ? [] : [
				'disabled' => 'disabled'
			])
		])
	}}
@endcomponent

@push('additional-js')
	<script type="text/javascript">
		$(document).ready(function() {
			checkSubscriptionType()

			$('#subscribe_price').keypress(function(){
				$(this).number( true , 0, ',', '.')
			})

			$('#select2-subscribe_period').change(function(event) {
				checkSubscriptionType()
			});

			$('#bill_date').datepicker({
				format: 'yyyy-mm-d',
				todayBtn: 'linked'
			})

			function checkSubscriptionType() {
				var period = $('#select2-subscribe_period').val()

				if (period == 'PER YEAR') {
					$('.bill_addons').text('Every Year');
				} else {
					$('.bill_addons').text('Every Month');
				}
			}
		});
	</script>
@endpush
