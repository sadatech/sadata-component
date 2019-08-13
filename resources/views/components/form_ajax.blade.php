@php

$id = $formOptions['id'];
$formOpen = isset($model)
			? Form::model($model, $formOptions)
			: Form::open($formOptions);
@endphp



{{ $formOpen }}

{{ $slot }}

{{ Form::close() }}



@push('additional-js')
	<script type="text/javascript">
		function submitAjax_{{ $id }}() {
			var form = $({{ $id }}),
				data = form.serialize()

			$.ajax({
				url: form.attr('action'),
				type: "{{ $formOptions['method'] }}",
				data: data,
			})
			.always(function() {
				console.log('submitting...');
			})
			.done(function(res) {
				setTimeout(function() {
					console.log('done')
					if (!(typeof res.redirect === 'undefined')) {
						var param = $.param({type: res.type, title: res.title, msg: res.msg});
						window.location.replace(res.redirect + '?' + param);
					} else{
						callAlert(res)
					}
				}, 500)
			})
			.fail(function(xhr, textStatus, errorThrown) {
				setTimeout(function() {
					console.log('fail');

					var res = $.parseJSON(xhr.responseText)
					validationError = res.validation;

					callAlert(res)

					$.each(validationError, function(index, val) {
						var inputField = form.find('[name="'+ index +'"]')

						formGroup = inputField.parents('.form-group')

						formGroup.addClass('has-danger')
						formGroup.find('.error-container').html('<div class="form-control-feedback"> '+ val +' </div>');
					});
				}, 500)
			})
		}
	</script>
@endpush