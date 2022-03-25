<div class="bg-center bg-cover bg-no-repeat" @if ($bg_image) style="background-image:url({{ $bg_image }})" @endif>
    <div class="min-h-screen flex justify-center items-center" style="background:radial-gradient(circle, rgba(26,26,26,0.6) 0%, rgba(26,26,26,0.25) 100%)">
        <div class="flex flex-col justify-center items-center w-full sm:max-w-xl sm:mx-auto p-4 pt-6 sm:p-0 sm:pt-4 space-y-8 text-gray-100">
            @if ($main_logo || $other_logos)
                <div class="w-full space-y-6">
                    @if ($main_logo)
                        <div class="flex justify-center">
                            <img class="w-auto max-h-36" src="{{ $main_logo }}">
                        </div>
                    @endif

                    @if ($other_logos)
                        <div class="w-full flex justify-between sm:justify-around items-center">
                            @foreach ($other_logos as $logo)
                                <img style="max-width: @if ($loop->first || $loop->last) 5rem @else 8rem @endif" class="h-auto" src="{{ $logo }}">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <p class="px-4 leading-none text-3xl text-center tracking-wide header-logo">{{ $title }}</p>

            @if ($content)
                <div>
                    {!! $content !!}
                </div>
            @endif

            <div class="w-full event-registration-form">
                {!! $form !!}
            </div>

            <p class="text-center text-xs text-gray-300">Your details will be used for contact tracing in accordance with local health guidelines &amp; will not be shared with any third parties.</p>
        </div>
    </div>
</div>
