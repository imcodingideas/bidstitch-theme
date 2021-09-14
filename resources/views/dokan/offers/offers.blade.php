{{-- Dokan Offers Dashboard Template

    Dokan Offers Dahsboard template for Front-end

    @since 1.0.0 --}}

@php do_action('dokan_dashboard_content_before') @endphp

<div class="grid space-y-8">
  @php do_action('dokan_dashboard_content_inside_before') @endphp

  @if ($offers)
    {!! $offers !!}
  @endif

  @php do_action('dokan_dashboard_content_inside_after') @endphp
</div>

@php do_action('dokan_dashboard_content_after') @endphp
