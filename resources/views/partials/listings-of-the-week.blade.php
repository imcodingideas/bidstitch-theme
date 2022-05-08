<section id="listings_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Listings of the Week', 'sage') }}</h2>
            </div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-6 md:gap-y-6 md:gap-x-6 lg:grid-cols-6 xl:grid-cols-6">
                @foreach ($products as $product)
                    <div class="flex flex-col">
                        <a href="{{ $product->link }}" class="relative mb-3">
                            <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-center object-cover border shadow-lg rounded-lg">
                        </a>
                        <p class="text-sm font-light text-newgray mb-2"><a href="{{ $product->vendor_link }}" class="font-light">{!! $product->vendor !!}</a></p>
                        <p class="relative text-base capitalize mb-2"><a href="{{ $product->link }}">{!! $product->title !!}</a></p>
                        <p class="font-bold">{!! $product->price !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
