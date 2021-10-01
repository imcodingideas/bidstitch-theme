@if ($receiver_user_id)
  <li class="dokan-right">
    <x-user-chat-button receiver="{{ $receiver_user_id }}" class="dokan-btn dokan-btn-theme dokan-btn-sm" />
  </li>
@endif
