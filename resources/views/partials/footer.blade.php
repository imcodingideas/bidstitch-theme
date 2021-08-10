<footer class="bg-black py-4">
  <div class="container mx-auto px-6">
    <div class="flex flex-wrap space-y-6 md:flex-nowrap md:items-center md:space-y-0">
      @if (has_nav_menu('footer_navigation'))
        <div class="flex w-full justify-center md:items-center md:space-x-6 md:mr-6 md:w-auto md:justify-start">
          @include('partials.footer-navigation')
        </div>
      @endif
      <div class="flex w-full justify-center md:items-center md:space-x-6 md:mr-6 md:w-auto md:justify-start md:ml-auto">
        @include('partials.footer-icons')
      </div>
      <div class="flex w-full justify-center md:items-center md:space-x-6 md:mr-6 md:w-auto md:justify-start md:mr-0">
        <span class="text-white text-sm uppercase">{{ $siteName }} © {{ date('Y') }}</span>
      </div>
    </div>
  </div>
</footer>
