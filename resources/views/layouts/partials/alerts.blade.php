@if (Session::has('info') )
    <div class="alert alert-primary alert-dismissible fade show"
          role="alert">
      {{ Session::get('info') }}
      <button type="button"
              class="close"
              data-dismiss="alert"
              aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>
@endif