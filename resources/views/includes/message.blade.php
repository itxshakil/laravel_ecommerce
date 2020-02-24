@if (session()->has('success'))
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 my-2  rounded relative" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session()->get('success') }}</span>
</div>
@endif
@if (session()->has('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-2 rounded relative" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session()->get('error') }}</span>
</div>
@endif