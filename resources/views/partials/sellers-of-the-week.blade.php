<section id="sellers_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Sellers of the Week', 'sage') }}</h2>
            </div>
            <div class="grid grid-cols-1 gap-x-4 gap-y-6 md:gap-y-6 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-3">
                @foreach ($vendors as $vendor)
                    <div class="flex flex-col border shadow-lg rounded-lg bg-white">
                        <div class="p-4 bg-gray-100 border">
                            <p class="text-sm"><a href="{{ $vendor->link }}" class="font-light text-newgray">{{ $vendor->name }}</a></p>
                        </div>
                        <div class="flex space-x-4 p-4">
                            @foreach ($vendor->products as $product)
                                <div class="flex flex-col">
                                    <a href="{{ $product->link }}" class="relative mb-3 aspect-w-1 aspect-h-1">
                                        <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-center object-cover border shadow-lg rounded-lg">
                                    </a>
                                    <p class="relative mb-2 text-base capitalize"><a href="{{ $product->link }}">{!! $product->title !!}</a></p>
                                    <p class="font-bold">{!! $product->price !!}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
