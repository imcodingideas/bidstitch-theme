<div class="fixed top-0 left-0 w-full h-full shadow-lg z-50 flex items-center justify-center p-4"
  x-bind:class="{ hidden: !modalOpen, block: modalOpen }" x-cloak>
  <div class="bg-black bg-opacity-50 h-full w-full absolute top-0 left-0" @click="handleModalClose()"></div>

  <div class="w-full max-w-md grid relative">
    <div class="p-4 bg-white">
      <div>
        <div x-show="status === 'success'" x-transition="">
          <x-alert type="success" class="text-center flex justify-center mb-4">
            <span x-text="statusMessage"></span>
          </x-alert>
        </div>
        <div x-show="status === 'error'" x-transition="">
          <x-alert type="error" class="text-center flex justify-center mb-4">
            <span x-text="statusMessage"></span>
          </x-alert>
        </div>
      </div>
      <h3 class="text-xl font-extrabold tracking-tight text-gray-900 md:text-2xl text-center mb-4">
        {{ _e('Send New Offer', 'sage') }}</h3>
      <form method="post" @submit="handleSubmit($event)" class="grid space-y-3">
        <div class="grid space-y-3 text-left">
          <x-form-group>
            <x-form-label required for="offer_price">
              {!! sprintf(__('Offer Amount (USD)', 'sage'), get_woocommerce_currency_symbol()) !!}</x-form-label>
            <x-form-input required x-bind:disabled="status === 'loading'" x-ref="field-offer_price" type="number"
              name="offer_price" id="offer_price" maxlength="15" x-on:keydown="handleInput($event)" />
          </x-form-group>

          <x-form-group>
            <x-form-label for="offer_notes">{{ _e('Offer Notes', 'sage') }}</x-form-label>
            <textarea
              class="text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black"
              x-ref="field-offer_notes" name="offer_notes" id="offer_notes" maxlength="250"
              x-on:keydown="handleInput($event)" x-bind:disabled="status === 'loading'"></textarea>
          </x-form-group>
        </div>

        <div class="hidden">
          <input type="hidden" x-ref="field-nonce" id="_bidstitch-offer-form-submit" name="_bidstitch-offer-form-submit" value="{{ esc_attr(wp_create_nonce('bidstitch-offer-form-submit')) }}"/>
          <input type="hidden" x-ref="field-offer_product_id" id="offer_product_id" name="offer_product_id" />
          <input type="hidden" x-ref="field-offer_id" id="offer_id" name="offer_id" />
          <input type="hidden" x-ref="field-offer_action" id="offer_action" name="offer_action" />
        </div>

        <input x-bind:disabled="status === 'loading'"
          class="btn btn--md btn--black w-full justify-center cursor-pointer" type="submit" name="save_button"
          id="save_button" x-bind:value="status === 'loading' ? 'Loading' : 'Send Offer'" />
      </form>
    </div>
  </div>
</div>
