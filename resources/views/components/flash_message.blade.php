@if (session()->has('message'))
    <div  x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed-top">
        <p class="text-center text-danger">
            {{ session('message') }}
        </p>
    </div>
@endif
