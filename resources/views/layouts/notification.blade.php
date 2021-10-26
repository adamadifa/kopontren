@if ($message = Session::get('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-9 text-white">
    <i data-feather="check" class="w-6 h-6 mr-2"></i>
    {{$message}} <i data-feather="x" class="w-4 h-4 ml-auto"></i>
</div>

@endif
@if ($message = Session::get('failed'))

@endif

@if ($message = Session::get('warning'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-12 text-white"> <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i> Awesome alert with icon <i data-feather="x" class="w-4 h-4 ml-auto"></i> </div>
@endif
