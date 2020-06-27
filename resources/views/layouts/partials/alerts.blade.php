@if (Session::has('info'))
   <div class="alert alert-primary" role="alert">
     {{ Session::get('info') }}
   </div>
@endif