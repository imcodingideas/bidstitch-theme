<footer class="bg-black py-4">
  <div class="container mx-auto px-6">
    <div class="flex flex-wrap space-y-6 md:flex-nowrap md:items-center md:space-y-0">
      @if (has_nav_menu('footer_navigation'))
        <div class="footer__col">
          @include('partials.footer-navigation')
        </div>
      @endif
      <div class="footer__col md:ml-auto">
        @include('partials.footer-icons')
      </div>
      <div class="footer__col">
        @include('partials.footer-copyright')
      </div>
    </div>
  </div>
</footer>
