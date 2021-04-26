<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> --}}

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="/css/normalize.css"> --}}
        {{-- <link rel="stylesheet" href="/css/materialize.css"> --}}
        <link rel="stylesheet" href="/css/bootstrap.css">


    </head>
    <body>
        @yield('body', "Oops! There's nothing here.")

@if ($errors->any())
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Errors</strong>
            {{-- <small class="text-muted">just now</small> --}}
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="d-flex">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
    </body>
    {{-- <script src="/js/materialize.js"></script> --}}
    <script src="/js/bootstrap.js"></script>
    <script language="javascript">
let toastOptions = {
    animation: true,
    // autohide: false,
};
let toastElList = [].slice.call(document.querySelectorAll('.toast'));
let toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, toastOptions);
});
document.addEventListener("DOMContentLoaded", function(event) {
    toastList.forEach(function(toast) {
        toast.show();
    });
});
    </script>
</html>
