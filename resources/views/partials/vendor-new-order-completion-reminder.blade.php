{{-- Visual reminder for vendors to mark orders complete once shipped. --}}
@if (!$completed)
  <div style="margin-bottom:1rem; border:1px solid #6D6; background-color:#AFA; color:#222; padding:1rem; text-align:center">
    <strong>REMEMBER:</strong> Set this order's status to "complete" once you have shipped the item. You can do this from the "Sold Listings" page in your vendor menu.
  </div>
@endif
