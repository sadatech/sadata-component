<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Test</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{ Form::open() }}

				@foreach ($fields as $field)
					@if (is_array($field))
						{!! $field['field'] !!}
					@else
						{!! $field !!}
					@endif
				@endforeach

				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success submit-button" onclick="submitAjax_{{ $id }}($(this))" data-method="POST" data-table="">Submit</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function showModalForm(param, data = null) {
		var modal = $(param.target),
			method = param.hasOwnProperty('method') ? param.method : 'POST';

		modal.find('#modalTitle').text(param.title)
		modal.find('form').attr('action', param.action);
		modal.find('.submit-button').attr('data-method', method)

		if (param.hasOwnProperty('table')) {
			modal.find('.submit-button').attr('data-table', param.table)
		}

		if (data) {
			$.each(data, function(index, val) {
				$('[name="'+ index +'"]').val(val);
			});

			@foreach ($fields as $field)
				@if (is_array($field) && $field['type'] == 'select2')
					try {
						setSelect2IfPatchModal($('{{ $field['selector'] }}'), data.{{ $field['dataId'] }}, data.{!! $field['dataLabel'] !!})
					} catch (e) {
						console.log(e.message)
					}
				@endif
			@endforeach
		}

		modal.modal('show')
	}

	function submitAjax_{{ $id }}(me) {
		var modal = me.parents('.modal'),
			form = modal.find('form'),
			data = form.serialize()

		$.ajax({
			url: form.attr('action'),
			type: me.attr('data-method'),
			data: form.serialize(),
		})
		.always(function() {
			me.addClass('m-loader m-loader--light m-loader--right disabled')
		})
		.done(function(res) {
			setTimeout(function() {
				me.removeClass('m-loader m-loader--light m-loader--right disabled')

				form.trigger('reset')
				modal.modal('hide');
				toastr.success(res.msg, 'Success');

				dataTableFilter_{{ $tableTarget }}()
			}, 500)
		})
		.fail(function(xhr, textStatus, errorThrown) {
			setTimeout(function() {
				me.removeClass('m-loader m-loader--light m-loader--right disabled')

				var res = $.parseJSON(xhr.responseText)
				validationError = res.validation;

				toastr.error(res.msg, 'Failed!')

				$.each(validationError, function(index, val) {
					var inputField = form.find('[name="'+ index +'"]')

					formGroup = inputField.parents('.form-group')

					formGroup.addClass('has-danger')
					formGroup.find('.error-container').html('<div class="form-control-feedback"> '+ val +' </div>');
				});
			}, 500)
		})
	}

	$('#{{ $id }}').on('hidden.bs.modal', function () {
		resetForm($(this).find('form'), {!! json_encode($fields) !!})
	})
</script>