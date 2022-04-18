<section id="listings_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Listings of the Week', 'sage') }}</h2>
            </div>
            <div class="flex space-x-4">
                @for ($i = 0; $i < 6; $i++)
                    <div class="flex flex-col">
                        <a href="{{ esc_url($category->link) }}" class="relative  mb-3">
                            <img src="https://bidstitchprod.s3.amazonaws.com/uploads/2021/07/il_fullxfull.3166335615_cew1-220x220.jpg" alt="" class="w-full h-full object-center object-cover border shadow-lg rounded-lg">
                        </a>
                        <a href="#" class="mb-2 font-light"><p class="text-sm font-light text-newgray">beasyvintage</p></a>
                        <a href="#" class="mb-2"><p class="relative text-base capitalize">90 Miami Dolphins Puffer</p></a>
                        <p class="font-bold">$70.00</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>