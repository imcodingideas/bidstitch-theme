<div x-data="{ modalOpen: true }">
    <div class="bg-center bg-cover bg-no-repeat" @if ($bg_image) style="background-image:url({{ $bg_image }})" @endif>
        <div class="h-screen flex justify-center items-center" style="background:radial-gradient(circle, rgba(26,26,26,0.9) 0%, rgba(26,26,26,0.35) 100%)">
            <div class="w-full sm:max-w-xl p-4 sm:p-0 font-event tracking-wide text-white text-center">
                <div class="flex justify-evenly items-center space-x-4">
                    <hr class="border-white flex-grow">
                    <div class="uppercase text-lg sm:text-2xl">{{ $date }}</div>
                    <hr class="border-white flex-grow">
                </div>
                <div class="mb-4">{{ $location }}</div>
                <h1 class="uppercase text-5xl sm:text-8xl leading-none header-logo">{{ $title }}</h1>
                <div class="mt-4 mb-6 sm:text-xl">{!! $description !!}</div>
                <button x-on:click.prevent="modalOpen = true" class="w-full sm:w-auto sm:px-8 py-4 bg-white text-black font-bold tracking-wider">Register Now</button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="modalOpen">
        <div class="fixed z-40 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay, show/hide based on modal state. -->
                <div x-on:click="modalOpen = false" class="fixed inset-0 bg-black bg-opacity-60 transition-opacity cursor-pointer" aria-hidden="true"></div>
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!-- Modal panel, show/hide based on modal state. -->
                <div class="inline-block align-bottom bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                    <div class="flex justify-between items-center bg-gray-100 p-4">
                        <h2 class="text-lg sm:text-2xl">Registration</h2>
                        <button x-on:click="modalOpen = false" class="text-4xl">&#x2715;</button>
                    </div>

                    <div class="px-4 py-6 event-registration-form">
                        {!! $form !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>