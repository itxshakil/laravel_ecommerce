@if (Auth::guard('web')->check())
<h4 class="text-lg text-center text-gray-800">You are logged in as User!</h4>
@else
<h4 class="text-lg text-center text-red-800">You are logged out as User!</h4>
@endif
@if (Auth::guard('admin')->check())
<h4 class="text-lg text-center text-gray-800">You are logged in as Admin!</h4>
@else
<h4 class="text-lg text-center text-red-800">You are logged out as Admin!</h4>
@endif