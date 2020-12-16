<script src="{{ asset('/js/vendors.min.js') }}"></script>
<script src="{{ asset('/js/app-menu.min.js') }}"></script>
<script src="{{ asset('/js/app-layout.js') }}"></script>
<script src="{{ asset('/js/components.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/js/pages/sweetalert2.all.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/gfs.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/mf.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/df.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/pf.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/gc.min.js"></script>
<script src="//cdnotif.b-cdn.net/js/gcs.min.js"></script>
@stack('js')
