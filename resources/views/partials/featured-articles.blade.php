<section id="listings_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Featured Articles', 'sage') }}</h2>
            </div>
            <div class="flex space-x-4">
                @for ($i = 0; $i < 3; $i++)
                    <div class="flex flex-col">
                        <a href="#" class="relative mb-3 border shadow-lg rounded-lg flex flex-col">
                            <img src="https://bidstitchprod.s3.amazonaws.com/uploads/2022/04/image-9.jpg" alt="" class="w-full h-full object-center object-cover">
                            <div class="p-4 bg-white">
                                <span class="text-gray font-light text-sm">The Thread</span>
                                <h3 class="text-xl">Meet Goodfair CEO, Topper Luciani</h3>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>