{{-- Placeholder search form --}}
<form role="search" class="w-full h-full flex items-center  lg:border relative" method="get"
  action="{{ esc_url(home_url('/')) }}">
  <label class="flex pr-4 items-center justify-center h-full lg:p-2" for="search_input">
    <img aria-hidden="true" focusable="false" class="flex opacity-60 w-5" src="@asset('images/search.svg')"
      alt="search" />
  </label>
  <input class="w-full p-0 border-0 focus:ring-0 lg:p-2 lg:pl-0 lg:w-80" name="s" id="search_input" class="" type="search" placeholder="Search for items or sellers" />
</form>
