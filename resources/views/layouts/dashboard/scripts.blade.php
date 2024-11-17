<script src={{ asset('asset/vendor/libs/jquery/jquery.js') }}></script>
<script src={{ asset('asset/vendor/libs/popper/popper.js') }}></script>
<script src={{ asset('asset/vendor/js/bootstrap.js') }}></script>
<script src={{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}></script>

<script src={{ asset('asset/vendor/js/menu.js') }}></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src={{ asset('asset/vendor/libs/apex-charts/apexcharts.js') }}></script>

<!-- Main JS -->
<script src={{ asset('asset/js/main.js') }}></script>
<!-- Page JS -->
<script src={{ asset('asset/js/dashboards-analytics.js') }}></script>
<script src={{asset("asset\\fontawesome\js\all.js")}}></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Toastr CSS and JS -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
<!-- Include jQuery and Toastr -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $('#imageInput').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

@if (Session::has('success'))
<script>
    toastr.success("{{ Session::get('success') }}");
</script>
@endif
@if (Session::has('error'))
<script>
    toastr.error("{{ Session::get('error') }}");
</script>
@endif


<!-- Include Dropzone JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js"></script>

<script type="text/javascript">
    Dropzone.options.imageUpload = {
        maxFilesize: 2, // MB
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        success: function(file, response) {
            console.log(response);
        }
    };
</script>

@yield('scripts-dashboard')
