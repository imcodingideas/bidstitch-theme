<section id="listings_of_the_week">
    <div class="container py-8">
        <div class="grid space-y-4">
            <div class="flex space-x-4 justify-between items-center">
                <h2 class="">{{ _e('Featured Articles', 'sage') }}</h2>
            </div>
            <div class="flex space-x-4">
                @foreach ($articles as $article)
                    <div class="flex flex-col">
                        <a href="{{ $article->link }}" class="relative mb-3 border shadow-lg rounded-lg flex flex-col">
                            <img src="{{ $article->image_url }}" alt="" class="w-full h-full object-center object-cover">
                            <div class="p-4 bg-white">
                                <span class="text-gray font-light text-sm">{!! $article->category !!}</span>
                                <h3 class="text-xl">{!! $article->title !!}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
