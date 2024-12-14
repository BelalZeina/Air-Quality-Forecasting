<title>Dashboard - shop|@yield('header__title')</title>

<meta name="description" content="" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href={{ asset('asset/img/favicon/favicon.ico') }} />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url("/") }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@200..1000&family=Inter:wght@100..900&family=Manrope:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
    rel="stylesheet">
<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('asset/vendor/fonts/boxicons.css') }}" />
@php
    $lang = config('app.locale');
@endphp

<!-- Core CSS -->
<link rel="stylesheet"
    href="{{ $lang == 'ar' ? asset('asset/vendor/css/core.ar.css') : asset('asset/vendor/css/core.css') }}" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<link rel="stylesheet" href={{ asset('asset/vendor/css/theme-default.css') }}
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('asset/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href={{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} />

<link rel="stylesheet" href={{ asset('asset/vendor/libs/apex-charts/apex-charts.css') }} />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<!-- Page CSS -->
<!-- Add these in your <head> section -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
    .image-preview {
        /* display: none; */
        width: 300px;
        height: auto;
        margin-top: 10px;
    }
</style>
<!-- toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- Helpers -->
<script src={{ asset('asset/vendor/js/helpers.js') }}></script>
<link rel="stylesheet" href={{ asset("asset\\fontawesome\css\all.css") }}>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src={{ asset('asset/js/config.js') }}></script>
@livewireStyles
