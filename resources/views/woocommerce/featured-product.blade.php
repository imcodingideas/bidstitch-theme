<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
      <symbol id="icon-star-empty" viewBox="0 0 32 32">
        <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798zM16 23.547l-6.983 3.671 1.334-7.776-5.65-5.507 7.808-1.134 3.492-7.075 3.492 7.075 7.807 1.134-5.65 5.507 1.334 7.776-6.983-3.671z"></path>
      </symbol>
      <symbol id="icon-star-full" viewBox="0 0 32 32">
        <path d="M32 12.408l-11.056-1.607-4.944-10.018-4.944 10.018-11.056 1.607 8 7.798-1.889 11.011 9.889-5.199 9.889 5.199-1.889-11.011 8-7.798z"></path>
      </symbol>
    </defs>
</svg>

<div class="flex flex-col sm:flex-row w-full sm:w-auto justify-center sm:justify-start items-center sm:space-x-4 bg-gray-100 px-4 py-2">
  <p class="text-sm font-bold">Feature this product</p>
    <div x-data="featuredProducts()" x-init="init({{ $product_id }}, {{ $featured }})" class="flex justify-center items-center space-x-2">
      <svg x-on:click="toggleFeatured" class="inline-block cursor-pointer w-8 h-8 fill-current" :class="featured ? 'text-black' : 'text-gray-500'"><use x-bind:href="featured ? '#icon-star-full' : '#icon-star-empty'"></use></svg>
    </div>
</div>
