<div class="alert {{ $alert_type ?? '' }}" role="alert" style="{{ (isset($grey)) ? 'background-color: #e5e5e5; ' : '' }} margin-bottom: 10px; {{ $repeated ? 'cursor: pointer;' : '' }}"
	@if($repeated && $repeated == true)
		onclick="showHide({{ $id }})"
	@endif
>
    <div class="alert-text" style="font-weight: bold;">
        <i class="fa fa-{{ $icon }}"></i>&nbsp;&nbsp;{{ $title }}
    </div>
</div>