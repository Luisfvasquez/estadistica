<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}        
<script src="{{ asset('js/income.js') }}"></script>  
<script src="{{ asset('js/analyte.js') }}"></script>  

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Errores durante la importación',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    @endif
</script>     

    </flux:main>
</x-layouts.app.sidebar>
