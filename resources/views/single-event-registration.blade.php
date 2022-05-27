<div class="bg-center bg-cover bg-no-repeat" @if ($bg_image) style="background-image:url({{ $bg_image }})" @endif>
    <div class="min-h-screen flex justify-center items-center" style="background:radial-gradient(circle, rgba(26,26,26,1) 0%, rgba(26,26,26,0.5) 100%)">
        <div class="flex flex-col justify-center items-center w-full sm:max-w-xl sm:mx-auto p-4 pt-6 sm:p-0 sm:pt-4 space-y-8 text-gray-100">
            <div class="w-full space-y-6">
                <div class="flex flex-col justify-center items-center space-y-4">
                    <img class="w-9/12" src="{{ $main_logo }}">

                    @foreach ($other_logos as $logo)
                        <img class="w-full sm:w-9/12" src="{{ $logo }}">
                    @endforeach
                </div>
            </div>

            @if ($content)
                <div>
                    {!! $content !!}
                </div>
            @endif

            <div class="w-full pb-12 event-registration-form">
                {!! $form !!}
            </div>
        </div>
    </div>
</div>
