<section id="listings_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Featured Articles', 'sage') }}</h2>
            </div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-3 md:gap-y-6 md:gap-x-6 lg:grid-cols-3 xl:grid-cols-3">
                @foreach ($articles as $article)
                    <div class="flex flex-col">
                        <a href="{{ $article->link }}" class="relative mb-3 border shadow-lg rounded-lg flex flex-col">
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $article->image_url }}" alt="" class="w-full object-center object-cover">
                            </div>
                            <div class="p-4 bg-white">
                                <span class="text-gray font-light text-sm">{!! $article->category !!}</span>
                                <h3 class="sm:text-xl">{!! $article->title !!}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
