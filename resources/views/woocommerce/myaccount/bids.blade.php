<div class="grid space-y-8">
  <div class="grid space-y-8">
    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ _e('Sent Bids', 'sage') }}</h1>
    @if ($bids)
      <div class="prose">
        <table>
          <thead>
            <tr>
              <th>{{ _e('Date', 'sage') }}</th>
              <th>{{ _e('Bid', 'sage') }}</th>
              <th>{{ _e('Product', 'sage') }}</th>
            </tr>
          </thead>
          @foreach ($bids as $bid)
            <tr>
              <td>{{ $bid->date }}</td>
              <td>{!! wc_price($bid->amount) !!}</td>
              <td>
                <a href="{{ esc_url($bid->product_link) }}">{{ $bid->product_name }}</a>
              </td>
            </tr>
          @endforeach
        </table>
      </div>
      @if ($pagination)
        <div class="pagination-wrap">
          <ul class="pagination mt-0 mb-0">
            @foreach ($pagination as $link)
              <li>{!! $link !!}</li>
            @endforeach
          </ul>
        </div>
      @endif
  </div>
@else
  <p>{{ _e('You have not bid on any items.', 'sage') }}</p>
  @endif
</div>
</div>
