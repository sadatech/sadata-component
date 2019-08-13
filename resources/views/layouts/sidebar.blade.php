<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			{{-- <li class="m-menu__item " aria-haspopup="true">
				<a href="../../index.html" class="m-menu__link ">
					<i class="m-menu__link-icon flaticon-line-graph"> </i> 
					<span class="m-menu__link-title"> 
						<span class="m-menu__link-wrap"> 
							<span class="m-menu__link-text">Dashboard</span> 
							<span class="m-menu__link-badge"><span class="m-badge m-badge--danger">2</span></span>
						</span>
					</span>
				</a>
			</li> --}}

			@foreach (auth()->user()->getMenu() as $list)
				@isset ($list['section'])
					<li class="m-menu__section ">
						<h4 class="m-menu__section-text">{{ $list['section'] }}</h4>
						<i class="m-menu__section-icon flaticon-more-v2"></i>
					</li>
				@endisset

				@foreach ($list['menu'] as $menu)
					@if (isset($menu['sub-menu']))
						<li class="m-menu__item  m-menu__item--submenu {{ request()->segment(1) == $menu['url'] ? 'm-menu__item--open m-menu__item--expanded' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
							<a href="javascript:;" class="m-menu__link m-menu__toggle">
								<i class="m-menu__link-icon {{ $menu['icon'] }}"></i> <span class="m-menu__link-text">{{ $menu['label'] }}</span> <i class="m-menu__ver-arrow la la-angle-right"></i>
							</a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">{{ $menu['label'] }}</span></span></li>
									@foreach ($menu['sub-menu'] as $submenu)
										<li class="m-menu__item {{ url()->current() == $submenu['url'] ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
											<a href="{{ $submenu['url'] }}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{{ $submenu['label'] }}</span>
											</a>
										</li>
									@endforeach
								</ul>
							</div>
						</li>
					@else
						<li class="m-menu__item" aria-haspopup="true">
							<a href="{{ $menu['url'] }}" class="m-menu__link ">
								<i class="m-menu__link-icon {{ $menu['icon'] }}"> </i> 
								<span class="m-menu__link-title"> 
									<span class="m-menu__link-wrap"> 
										<span class="m-menu__link-text">{{ $menu['label'] }}</span> 
									</span>
								</span>
							</a>
						</li>
					@endif
				@endforeach
			@endforeach

			{{-- <li class="m-menu__section ">
				<h4 class="m-menu__section-text">Master Data</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon flaticon-layers"></i> <span class="m-menu__link-text">Product(s)</span> <i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Base</span></span></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/base/state.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">State Colors</span></a></li>
					</ul>
				</div>
			</li>

			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-web"></i><span class="m-menu__link-text">Buttons</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Buttons</span></span></li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Button Base</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/base/default.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Default
									Style</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/base/square.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Square
									Style</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/base/pill.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Pill Style</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/base/air.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Air Style</span></a></li>
								</ul>
							</div>
						</li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/group.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Button Group</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/dropdown.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Button Dropdown</span></a></li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Button Icon</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/icon/lineawesome.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Lineawesome
									Icons</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/icon/fontawesome.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Fontawesome
									Icons</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../components/buttons/icon/flaticon.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Flaticon
									Icons</span></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</li>
			<li class="m-menu__item  m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-1"></i><span class="m-menu__link-text">Portlets</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Portlets</span></span></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/base.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Base Portlets</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/advanced.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Advanced
						Portlets</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/creative.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Creative
						Portlets</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/tabbed.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tabbed Portlets</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/draggable.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Draggable
						Portlets</span></a></li>
						<li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="../../components/portlets/tools.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Portlet
						Tools</span></a></li>
						<li class="m-menu__item " aria-haspopup="true"><a href="../../components/portlets/sticky-head.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sticky Head</span></a></li>
					</ul>
				</div>
			</li>
			<li class="m-menu__section ">
				<h4 class="m-menu__section-text">CRUD</h4>
				<i class="m-menu__section-icon flaticon-more-v2"></i>
			</li>
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-interface-7"></i><span class="m-menu__link-text">Forms & Controls</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
				<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">Forms & Controls</span></span></li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Form Controls</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/controls/base.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Base Inputs</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/controls/checkbox-radio.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Checkbox
									& Radio</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/controls/input-group.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Input
									Groups</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/controls/switch.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Switch</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/controls/option.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Mega Options</span></a></li>
								</ul>
							</div>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Form Widgets</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-datepicker.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Datepicker</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-datetimepicker.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Datetimepicker</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-timepicker.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Timepicker</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-daterangepicker.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Daterangepicker</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-touchspin.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Touchspin</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-maxlength.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Maxlength</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-switch.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Switch</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-multipleselectsplitter.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Multiple
									Select Splitter</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-select.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Bootstrap
									Select</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/select2.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Select2</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/typeahead.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Typeahead</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/nouislider.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">noUiSlider</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/form-repeater.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Form
									Repeater</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/ion-range-slider.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Ion
									Range Slider</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/input-mask.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Input Masks</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/summernote.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Summernote
									WYSIWYG</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/bootstrap-markdown.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Markdown
									Editor</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/autosize.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Autosize</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/clipboard.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Clipboard</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/dropzone.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Dropzone</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/widgets/recaptcha.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Google
									reCaptcha</span></a></li>
								</ul>
							</div>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Form Layouts</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/layouts/default-forms.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Default
									Forms</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/layouts/multi-column-forms.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Multi
									Column Forms</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/layouts/action-bars.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Basic
									Action Bars</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/layouts/sticky-action-bar.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sticky
									Action Bar</span></a></li>
								</ul>
							</div>
						</li>
						<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">Form Validation</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
							<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
								<ul class="m-menu__subnav">
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/validation/states.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Validation
									States</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/validation/form-controls.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Form
									Controls</span></a></li>
									<li class="m-menu__item " aria-haspopup="true"><a href="../../crud/forms/validation/form-widgets.html" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Form
									Widgets</span></a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</li> --}}
		</ul>
	</div>

	<!-- END: Aside Menu -->
</div>