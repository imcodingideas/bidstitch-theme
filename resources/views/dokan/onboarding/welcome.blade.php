<div class="space-y-4 grid">
  <h1>{{ _e('Welcome to the BidStitch seller program!', 'sage') }}</h1>
  <p>
    {{ _e('Thank you for choosing BidStitch to power your online store! This quick setup wizard will help you configure the basic settings.', 'sage') }}
  </p>
  <p>
    {{ _e('No time right now? If you don’t want to go through the wizard, you can skip and return to the Store!', 'sage') }}
  </p>
  <div class="flex space-x-4 items-center">
    <a href="{{ esc_url_raw($next_step_link) }}" class="btn btn--black btn--md">{{ _e('Let\'s Go!', 'sage') }}</a>
    <a href="{{ esc_url($dashboard_link) }}" class="btn btn--white btn--md">{{ _e('Not right now', 'sage') }}</a>
  </div>
</div>
