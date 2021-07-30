<footer class="content-info bg-gray-800 text-gray-400" aria-labelledby="footer-heading">
  <h2 id="footer-heading" class="sr-only">Footer</h2>
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 md:justify-between">

      <div class="">
        @if (is_active_sidebar('sidebar-footer-1'))
          @php dynamic_sidebar('sidebar-footer-1') @endphp
        @endif
      </div>

      <div class="">
        @if (is_active_sidebar('sidebar-footer-2'))
          @php dynamic_sidebar('sidebar-footer-2') @endphp
        @endif
      </div>

      <div class="">
        @if (is_active_sidebar('sidebar-footer-3'))
          @php dynamic_sidebar('sidebar-footer-3') @endphp
        @endif
      </div>
        
    </div>
  </div>
</footer>
