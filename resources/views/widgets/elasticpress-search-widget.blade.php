<div x-data="elasticpressSearchWidget()" class="">

  <form role="search" class="w-full h-full flex items-center lg:border" method="get" action="{{ esc_url(home_url('/')) }}">
    <label class="flex pr-4 items-center justify-center h-full lg:p-2" for="elasticpress-search-widget__label">
      <img aria-hidden="true" focusable="false" class="flex opacity-60 w-5" src="@asset('images/search.svg')" alt="search" />
    </label>
    <div class="relative w-full">

      <input x-model="search" @input.debounce.150ms="inputChanged" @click.away="hide=true" @click="hide=false" autocomplete="off" class="w-full p-0 border-0 focus:ring-0 lg:p-2 lg:pl-0 lg:w-80" name="s" class="" type="search" placeholder="Search for items or sellers" />

      <div class="absolute bg-white px-2 rounded shadow-lg top-full w-full z-10" :class="{ 'hidden': hide }">
        <ul class="flex flex-col space-y-2 relative">

          {{-- products --}}
          <template x-if="results.products && results.products.length > 0">
            <li class="border-b flex font-bold justify-between mb-1 pb-1 text-blue-800 uppercase">
              <div class="tracking-wide text-sm">products</div>
            </li>
          </template>

          <template x-if="results.products && results.products.length > 0">
            <template x-for="product in results.products">
              <li class="border-b flex justify-between mb-1 pb-1">
                <a :href="product.url" class="flex items-center justify-between text-sm tracking-wide w-full">
                  <div x-text="product.title"></div>
                  <div class="font-bold" x-text="product.price"></div>
                </a>
              </li>
            </template>
          </template>

          {{-- vendors --}}
          <template x-if="results.vendors && results.vendors.length > 0">
            <li class="border-b flex font-bold justify-between mb-1 pb-1 text-blue-800 uppercase">
              <div class="tracking-wide text-sm">vendors</div>
            </li>
          </template>

          <template x-if="results.vendors && results.vendors.length > 0">
            <template x-for="vendor in results.vendors">
              <li class="border-b flex justify-between mb-1 pb-1">
                <a :href="`${bidstitchSettings.siteUrl}/store/${vendor.url}`" x-text="vendor.title" class="tracking-wide text-sm"></a>
              </li>
            </template>
          </template>
        </ul>
      </div>
    </div>

  </form>

</div>
