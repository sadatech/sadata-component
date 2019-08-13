<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>SADATA {{ isset($title) ? ' | ' . $title : '' }}</title>

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	<meta name="description" content="Portlet tools examples">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<style type="text/css">
		.addon-right-side{
			border-top-left-radius: 0 !important;
			border-bottom-left-radius: 0 !important;
		}

		.addon-left-side{
			border-top-right-radius: 0 !important;
			border-bottom-right-radius: 0 !important;
		}

		.select2 {
			width: 100% !important;
		}

		.cell-nowrap {
			white-space: nowrap;
		}

		.DTFC_Cloned{
			background-color: #fff !important;
		}

		.dataTables_wrapper .DTFC_LeftWrapper .dataTable {
			margin: 0 !important;
		}

		.datepicker {
	      z-index: 1600 !important; /* has to be larger than 1050 */
	    }

	</style>

	<!--end::Web font -->

	<!--begin:: Global Mandatory Vendors -->
	<link href="{{ asset('assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
	<!--end:: Global Mandatory Vendors -->

	<!--begin:: Global Optional Vendors -->
	<link href="{{ asset('assets/vendors/tether/dist/css/tether.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/nouislider/distribute/nouislider.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/owl.carousel/dist/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/owl.carousel/dist/assets/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/ion-rangeslider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/jstree/dist/themes/default/style.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/chartist/dist/chartist.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/vendors/flaticon/css/flaticon.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/vendors/metronic/css/styles.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/vendors/fontawesome5/css/all.min.css') }}" rel="stylesheet" type="text/css" />
	<!--end:: Global Optional Vendors -->

	<!--begin::Global Theme Styles -->
	<link href="{{ asset('assets/theme/demo/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />

	<!--RTL version:<link href="{{ asset('assets/theme/demo/base/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />-->
	<!--end::Global Theme Styles -->

	<link rel="shortcut icon" href="{{ asset('assets/theme/demo/media/img/logo/favicon.ico') }}" />

	@stack('additional-css')

	<script src="{{ asset('assets/vendors/jquery/dist/jquery.js')}}" type="text/javascript"></script>
	
	{{-- @yield('fb-select2-resource') --}}
	@yield('fb-resource')
    @yield('datatable-resource')    
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">
		<!-- BEGIN: Header -->
		<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
			<div class="m-container m-container--fluid m-container--full-height">
				<div class="m-stack m-stack--ver m-stack--desktop">
					<!-- BEGIN: Brand -->
					<div class="m-stack__item m-brand  m-brand--skin-dark ">
						<div class="m-stack m-stack--ver m-stack--general">
							<div class="m-stack__item m-stack__item--middle m-brand__logo">
								<a href="../../index.html" class="m-brand__logo-wrapper">
									<img alt="" src="{{ asset('assets/theme/demo/media/img/logo/logo_default_dark.png') }}" />
								</a>
							</div>
							<div class="m-stack__item m-stack__item--middle m-brand__tools">
								<!-- BEGIN: Left Aside Minimize Toggle -->
								<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
									<span></span>
								</a>
								<!-- END -->

								<!-- BEGIN: Responsive Aside Left Menu Toggler -->
								<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
									<span></span>
								</a>
								<!-- END -->

								<!-- BEGIN: Responsive Header Menu Toggler -->
								<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
									<span></span>
								</a>
								<!-- END -->

								<!-- BEGIN: Topbar Toggler -->
								<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
									<i class="flaticon-more"></i>
								</a>
								<!-- BEGIN: Topbar Toggler -->
							</div>
						</div>
					</div>
					<!-- END: Brand -->

					@include('layouts.topbar')
				</div>
			</div>
		</header>
		<!-- END: Header -->

		<!-- begin::Body -->
		<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
			<!-- BEGIN: Left Aside -->
			@include('layouts.sidebar')
			<!-- END: Left Aside -->

			<div class="m-grid__item m-grid__item--fluid m-wrapper">
				<!-- BEGIN: Subheader -->
				@include('layouts.breadcrumb')
				<!-- END: Subheader -->

				<div class="m-content">
					@if ($multiPortlet ?? false)
						@yield('content')
					@else
						<!--begin::Portlet-->
						@if ($withSearch ?? false)
							<div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm m-portlet--collapsed" m-portlet="true" id="m_portlet_tools_1">
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="fa fa-search"></i>
											</span>
											<h3 class="m-portlet__head-text">
												{{ ($title ?? '') . ' Advance Search'}}
											</h3>
										</div>
									</div>
									<div class="m-portlet__head-tools">
										<ul class="m-portlet__nav">
											<li class="m-portlet__nav-item">
												<a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<div class="m-portlet__body">
									@yield('search-form')
								</div>
							</div>
						@endif


						<div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_1">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="{{ $icon ?? ''}}"></i>
										</span>
										<h3 class="m-portlet__head-text">
											{{ $title ?? ''}}
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											<a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
										</li>
										<li class="m-portlet__nav-item">
											<a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
										</li>
										<li class="m-portlet__nav-item">
											<a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="m-portlet__body">
								@yield('content')
							</div>
						</div>
						<!--end::Portlet-->
					@endif
				</div>
			</div>
		</div>
		<!-- end:: Body -->

		<!-- begin::Footer -->
		@include('layouts.footer')
		<!-- end::Footer -->

	</div>
	<!-- end:: Page -->

	<!-- begin::Quick Sidebar -->
	@include('layouts.quick_sidebar')
	<!-- end::Quick Sidebar -->

	<!-- begin::Scroll Top -->
	<div id="m_scroll_top" class="m-scroll-top">
		<i class="la la-arrow-up"></i>
	</div>

	<!-- end::Scroll Top -->

	<!-- begin::Quick Nav -->
	@isset ($stickyButton)
		<ul class="m-nav-sticky" style="margin-top: 30px; width: 50px !important">
			@foreach ($stickyButton as $btn)
				@php
					$btn['elOptions'] = array_merge([
						'style' => 'cursor: pointer'
					], $btn['elOptions'] ?? []);
					$elProp = FormBuilderHelper::arrayToHtmlAttribute($btn['elOptions'])
				@endphp
				<li class="m-nav-sticky__item" data-toggle="m-tooltip" title="{{ $btn['label'] }}" data-placement="left">
					<a {!! $elProp !!}><i class="{{ $btn['icon'] }}" style="font-size: 2.14rem !important"></i></a>
				</li>
			@endforeach
		</ul>
	@endisset
	<!-- begin::Quick Nav -->

	{{-- Delete Form --}}
	<form action="#" method="POST" id="deleteForm">
		<input type="hidden" name="_method" value="DELETE">
		@csrf
	</form>

	<!--begin:: Global Mandatory Vendors -->
	<script src="{{ asset('assets/vendors/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/moment/min/moment.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/tooltip.js/dist/umd/tooltip.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/wnumb/wNumb.js')}}" type="text/javascript"></script>
	<!--end:: Global Mandatory Vendors -->

	<!--begin:: Global Optional Vendors -->
	<script src="{{ asset('assets/vendors/jquery.repeater/src/lib.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jquery.repeater/src/jquery.input.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jquery.repeater/src/repeater.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jquery-form/dist/jquery.form.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/block-ui/jquery.blockUI.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/bootstrap-timepicker.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/bootstrap-daterangepicker.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-maxlength/src/bootstrap-maxlength.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-switch/dist/js/bootstrap-switch.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/bootstrap-switch.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/select2/dist/js/select2.full.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/typeahead.js/dist/typeahead.bundle.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/handlebars/dist/handlebars.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/inputmask/dist/jquery.inputmask.bundle.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/inputmask/dist/inputmask/inputmask.date.extensions.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/inputmask/dist/inputmask/inputmask.numeric.extensions.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/inputmask/dist/inputmask/inputmask.phone.extensions.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/nouislider/distribute/nouislider.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/owl.carousel/dist/owl.carousel.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/autosize/dist/autosize.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/clipboard/dist/clipboard.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/ion-rangeslider/js/ion.rangeSlider.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/dropzone/dist/dropzone.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/summernote/dist/summernote.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/markdown/lib/markdown.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/bootstrap-markdown.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jquery-validation/dist/jquery.validate.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jquery-validation/dist/additional-methods.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/forms/jquery-validation.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/bootstrap-notify/bootstrap-notify.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/base/bootstrap-notify.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/toastr/build/toastr.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/jstree/dist/jstree.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/raphael/raphael.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/morris.js/morris.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/chartist/dist/chartist.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/chart.js/dist/Chart.bundle.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/charts/chart.init.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/vendors/jquery-idletimer/idle-timer.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/waypoints/lib/jquery.waypoints.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/counterup/jquery.counterup.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/es6-promise-polyfill/promise.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/sweetalert2/dist/sweetalert2.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendors/js/framework/components/plugins/base/sweetalert2.init.js')}}" type="text/javascript"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
	<!--end:: Global Optional Vendors -->

	<!--begin::Global Theme Bundle -->
	<script src="{{ asset('assets/theme/demo/base/scripts.bundle.js') }}" type="text/javascript"></script>
	<!--end::Global Theme Bundle -->

	<!--begin::Page Scripts -->
	{{-- <script src="{{ asset('assets/theme/demo/custom/components/portlets/tools.js') }}" type="text/javascript"></script> --}}
	<!--end::Page Scripts -->

	<script type="text/javascript">

		$(document).ready(function() {
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": true,
				"positionClass": "toast-bottom-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "slideDown",
				"hideMethod": "slideUp"
			};

			@if (session('alert'))
				var alert = {!! json_encode(session('alert')) !!}
				toastr.{{ session('alert')['type'] }}(alert.msg, alert.title);
			@endif

			console.log(getUrlParameter('msg'));
			if (getUrlParameter('msg') != undefined) {
				callAlert({
					msg: getUrlParameter('msg'),
					type: getUrlParameter('type'),
					title: getUrlParameter('title'),
				})
			}

			$('.m-datatables').on('init.dt', function() {
				mApp.initTooltips();
			});
		});

		$.ajaxSetup({
		    headers: {
		        'Accept': 'application/json',
		        'Authorization': "Bearer {{ session('token') }}",
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		function deleteForm(action, me = null){
			$.ajax({
				url: action,
				type: 'DELETE',
			})
			.done(function(res) {
				callAlert(res);
				me.parents('tr').remove();
			})
			.fail(function(xhr, textStatus, errorThrown) {
				console.log(xhr.responseText);
				res = $.parseJSON(xhr.responseText);
				callAlert(res)
			})
		}

		function callAlert(alert){
			alert.type = typeof alert.type === 'undefined' || alert.type == '' ? 'success' : alert.type;
			alert.title = typeof alert.title === 'undefined' || alert.title == '' ? 'Success!' : alert.title;
			alert.msg = typeof alert.msg === 'undefined' || alert.msg == '' ? 'Request successfully executed.' : alert.msg;
			console.log(alert)

			if (alert.type == 'success') return toastr.success(alert.msg, alert.title)
			if (alert.type == 'error') return toastr.error(alert.msg, alert.title)
			if (alert.type == 'warning') return toastr.warning(alert.msg, alert.title)
			if (alert.type == 'info') return toastr.warning(alert.msg, alert.title)
		}

		function resetForm(form, fields = []) {
			form.trigger('reset').trigger('change');
			form.find('.has-danger').removeClass('has-danger');
			form.find('.error-container').html('');

			$.each(fields, function(index, val) {
				if (val.hasOwnProperty('type')){
					switch(val.type){
						case 'select2' :
							$(val.selector).val('').trigger('change');
							break;
						case 'defaultYear' :
							$(val.selector).val(moment().format('YYYY')).datepicker('update');
							break;
						case 'defaultMonth' :
							$(val.selector).val(moment().format('YYYY-MM')).datepicker('update');
							break;
						case 'defaultDate' :
							$(val.selector).val(moment().format('YYYY-MM-DD')).datepicker('update');
							break;
					}
				}
			});
		}

		function showHide(id){
			var elDiv = $('#'+id);
			if(elDiv.css('display') == 'none'){
				elDiv.removeAttr('style');
			}else{
				elDiv.css('display', 'none');
			}
		}

		function loader(target, type = null, message = 'Please wait...') {
			if (type == null || type == 'block') {
				mApp.block(target, {
	                overlayColor: "#000000",
	                type: "loader",
	                state: "success",
	                message: message
	            })
			}

			if (type == null) {
				setTimeout(function() {
		            mApp.unblock(target)
		        }, 500)
			} 

			if(type == 'unblock') {
				mApp.unblock(target)
			}
		}

		var getUrlParameter = function getUrlParameter(sParam) {
		    var sPageURL = window.location.search.substring(1),
		        sURLVariables = sPageURL.split('&'),
		        sParameterName,
		        i;

		    for (i = 0; i < sURLVariables.length; i++) {
		        sParameterName = sURLVariables[i].split('=');

		        if (sParameterName[0] === sParam) {
		            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		        }
		    }
		};

	</script>

	@yield('additional-js')

	@stack('additional-js')
</body>
<!-- end::Body -->

</html>