<form role="search" class="w-full flex items-center border border-gray-300 bg-white relative px-2" method="get"
  action="{{ esc_url(get_permalink(get_option('page_for_posts'))) }}">
  <label class="flex pr-2 items-center justify-center h-full md:p-2 md:pr-4" for="search_input">
    <img aria-hidden="true" focusable="false" class="flex opacity-60 w-5" src="@asset('images/search.svg')"
      alt="search" />
  </label>
  <input required class="w-full p-0 border-0 focus:ring-0 text-sm md:p-2 md:pl-0 md:text-base" name="s" id="search_input"
    type="search" placeholder="Search for articles" />
</form>
