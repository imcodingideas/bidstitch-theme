import {createApp} from 'vue'
import shippingRatesEditor from './ShippingRatesEditor.vue'

export default function () {
  //Attempt to get the element using document.getElementById
  var element = document.getElementById("shipping-rates-editor");

  //If it isn't "undefined" and it isn't "null", then it exists.
  if (typeof (element) != 'undefined' && element != null) {
    createApp(shippingRatesEditor).mount('#shipping-rates-editor')
  }
}



