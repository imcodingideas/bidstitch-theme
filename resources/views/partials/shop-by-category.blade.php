{{-- old: ss-shop-by-category --}}
<section class="shop-by-category py-12" id="new_home_category_button">
  <div class="container mx-auto">
    <div class="wrapper-section">
      <div class="inner-section">
        <div class="wrap-shop-by-category">
          <ul class="flex flex-col justify-center md:flex-row md:space-x-4 md:space-y-0 mx-auto space-y-4">
            @if ($categories)
              @foreach ($categories as $category)
                <li class="item">
                  <a class="btn btn-white px-8 py-1 " href="{{ $category['link'] }}">
                    <span class="category-name">
                      {{ $category['name'] }}
                      {{ $category['string_category'] }}
                    </span>
                  </a>
                </li>
              @endforeach
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>


