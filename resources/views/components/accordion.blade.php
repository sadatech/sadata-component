<?php $collapsed = $collapsed ?? false ?>

<div class="m-accordion m-accordion--default" id="m_accordion_{{ $id }}" role="tablist">
	<!--begin::Item-->
	<div class="m-accordion__item">
		<div class="m-accordion__item-head {{ $collapsed ? 'collapsed' : '' }}" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_{{ $id }}" aria-expanded="{{ $collapsed ? 'false' : 'true' }}">
			<span class="m-accordion__item-icon"><i class="{{ $icon ?? 'fa fa-sign-in-alt' }}"></i></span>
			<span class="m-accordion__item-title">{{ $title ?? 'Info' }}</span>
			<span class="m-accordion__item-mode"></span>
		</div>
		<div class="m-accordion__item-body collapse {{ $collapsed ? '' : 'show' }}" id="m_accordion_1_item_{{ $id }}" role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_{{ $id }}" style="">
			<div class="m-accordion__item-content">
				{{ $slot }}
			</div>
		</div>
	</div>
	<!--end::Item-->
</div>