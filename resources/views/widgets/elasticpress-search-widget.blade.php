<div x-data="elasticpressSearchWidget()" class="w-full h-full">

  <form x-on:submit.prevent role="search" class="relative w-full h-full grid" method="get" action="{{ esc_url(home_url('/')) }}" @click.away="hide=true">
    <div class="relative w-full h-full flex items-center lg:border">
      <label class="flex pr-4 items-center justify-center h-full lg:p-2" for="elasticpress-search-widget__label">
        <img aria-hidden="true" focusable="false" class="flex opacity-60 w-5" src="@asset('images/search.svg')" alt="search"/>
      </label>
      <input @click="hide=false" x-model="search" @input.debounce.150ms="inputChanged" autocomplete="off" class="w-full p-0 border-0 focus:ring-0 lg:p-2 lg:pl-0" name="s" class="" type="search" placeholder="Search for items or sellers" />
    </div>
    <div class="absolute left-0 top-full w-full z-10 bg-white border mt-px lg:mt-0 lg:border-t-0" x-show="!hide">
        {{-- Navigation --}}
        <nav class="relative z-0 flex divide-x divide-gray-200" aria-label="Tabs">
          <button type="button" @click.prevent="tab = 'products'" :class="{ 'text-gray-900': tab === 'products' }" class="text-gray-500 group relative min-w-0 flex-1 overflow-hidden bg-gray-50 py-4 px-4 text-sm font-medium text-center focus:z-10 focus:outline-none">
            <span>{{ _e('Products', 'sage') }}</span>
            <span aria-hidden="true" :class="{ 'bg-black': tab === 'products' }" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
          </button>
    
          <button type="button" @click.prevent="tab = 'vendors'" :class="{ 'text-gray-900': tab === 'vendors' }" class="text-gray-500 group relative min-w-0 flex-1 overflow-hidden bg-gray-50 py-4 px-4 text-sm font-medium text-center focus:z-10 focus:outline-none">
            <span>{{ _e('Vendors', 'sage') }}</span>
            <span aria-hidden="true" :class="{ 'bg-black': tab === 'vendors' }" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
          </button>
        </nav>
        
        <div class="flex flex-col relative bg-white max-h-80 overflow-y-auto">
          {{-- products --}}
          <ul class="divide-y divide-gray-200" x-show="tab === 'products'">
            <template x-if="results.products && results.products.length > 0">
              <template x-for="product in results.products">
                <li class="flex justify-between">
                  <a :href="product.url" class="flex items-center justify-between text-sm tracking-wide w-full sm p-2">
                    <div x-text="product.title"></div>
                    <div class="font-bold" x-text="product.price"></div>
                  </a>
                </li>
              </template>
            </template>

            <template x-if="!results.products || (results.products && results.products.length === 0)">
              <li class="flex justify-between">
                <p class="tracking-wide text-sm p-2">{{ _e('No products found', 'sage') }}</p>
              </li>
            </template>
          </ul>

          {{-- vendors --}}
          <ul class="divide-y divide-gray-200" x-show="tab === 'vendors'">
            <template x-if="results.vendors && results.vendors.length > 0">
              <template x-for="vendor in results.vendors">
                <li class="flex justify-between">
                  <a :href="`${bidstitchSettings.siteUrl}/store/${vendor.url}`" x-text="vendor.title" class="tracking-wide text-sm p-2"></a>
                </li>
              </template>
            </template>
  
            <template x-if="!results.vendors || (results.vendors && results.vendors.length === 0)">
              <li class="flex justify-between">
                <p class="tracking-wide text-sm sm p-2">{{ _e('No vendors found', 'sage') }}</p>
              </li>
            </template>
          </ul>
        </div>
    </div>
  </form>
</div>
