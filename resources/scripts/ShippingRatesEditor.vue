<template>
  <div class="bidstitchtools-shipping-rates-editor">
    <div v-show="loading" class="bidstitchtools-shipping-rates-editor__loading">
      loading...
      <!-- TODO: this path isn't working <img src="images/loading.gif" alt="loading" /> -->
    </div>
    <div
      class="bidstitchtools-shipping-rates-editor__zones"
      v-if="zones.length"
    >
      <div
        class="bidstitchtools-shipping-rates-editor__zone"
        v-for="zone in zones"
        :key="zone.id"
      >
        <div class="bidstitchtools-shipping-rates-editor__name">
          {{ zone.zone_name }}
        </div>
        <div
          key="bidstitchtools-shipping-rates-editor__shippings"
          v-if="zone.shipping_methods.length"
        >
          <div
            class="bidstitchtools-shipping-rates-editor__shipping"
            v-for="shipping_method in zone.shipping_methods"
            :key="shipping_method.id"
          >
            <input
              @input="debounceUpdateRate(zone, shipping_method, $event)"
              type="number"
              :value="shipping_method.settings.cost"
              :disabled="loading"
              v-show="shipping_method.enabled == 'yes'"
              class="bidstitchtools-shipping-rates-editor__input-text"
            />

            <label class="switch">
              <input
                @input="toggleChanged(zone, shipping_method)"
                type="checkbox"
                class="toogle-checkbox"
                :checked="shipping_method.enabled == 'yes'"
                :disabled="loading"
              /><span class="slider round"></span>
            </label>
          </div>
        </div>
        <!-- no methods -->
        <div v-else>
          <label class="switch">
            <input
              @input="addRate(zone)"
              type="checkbox"
              class="toogle-checkbox"
              :disabled="loading"
            /><span class="slider round"></span>
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "App",
  data() {
    return {
      // eslint-disable-next-line
      settings: bidstitchtools_settings,
      zones: [],
      updateTimer: null,
      loading: true,
    };
  },
  mounted() {
    this.getZones();
  },
  methods: {
    async getZones() {
      this.loading = true;
      let data = new FormData();
      data.append("action", "dokan-get-shipping-zone");
      data.append("nonce", this.settings.nonce);
      const response = await axios.post(this.settings.ajaxUrl, data);
      const zones = Object.values(response.data.data).map((z) => {
        const shipping_methods = Object.values(z.shipping_methods).filter(
          (z) => z.id == "flat_rate"
        );
        const zone_name = z.id == 0 ? "Other" : z.zone_name;
        return {
          id: z.id,
          zone_name: zone_name,
          shipping_methods: shipping_methods,
        };
      });
      this.zones = zones;
      this.loading = false;
    },
    async getZoneDetails(zone) {
      // this is required so rates are persisted correctly in database
      let formData = new FormData();
      formData.append("action", "dokan-get-shipping-zone");
      formData.append("nonce", this.settings.nonce);
      formData.append("zoneID", zone.id);
      const res = await axios.post(this.settings.ajaxUrl, formData);
      const data = res.data.data.data;
      return {
        code: data.zone_locations[0].code,
        name: data.zone_name,
      };
    },
    async saveZone(zone) {
      // get details
      const currentZone = await this.getZoneDetails(zone);

      // save zone
      let data = new FormData();
      data.append("action", "dokan-save-zone-settings");
      data.append("nonce", this.settings.nonce);
      data.append("zoneID", zone.id);
      data.append("country[0][code]", currentZone.code);
      data.append("country[0][name]", currentZone.name);
      data.append("postcode", "");
      await axios.post(this.settings.ajaxUrl, data);
    },
    async addRate(zone) {
      this.loading = true;
      // rate data
      let rateData = new FormData();
      rateData.append("action", "dokan-add-shipping-method");
      rateData.append("nonce", this.settings.nonce);
      rateData.append("method", "flat_rate");
      rateData.append("zoneID", zone.id);
      rateData.append("settings[title]", "Flat Rate");
      rateData.append("settings[cost]", "0");
      rateData.append("settings[description]", "flat rate");
      rateData.append("settings[tax_status]", "none");
      await axios.post(this.settings.ajaxUrl, rateData);
      await this.saveZone(zone);
      await this.getZones();
    },
    toggleChanged(zone, shipping_method) {
      const toggleValue = shipping_method.enabled == "yes" ? "false" : "true";
      this.toggleRate(zone, shipping_method, toggleValue);
    },
    async toggleRate(zone, shipping_method, toggleValue) {
      this.loading = true;
      let data = new FormData();
      data.append("action", "dokan-toggle-shipping-method-enabled");
      data.append("nonce", this.settings.nonce);
      data.append("zoneID", zone.id);
      data.append("instance_id", shipping_method.instance_id);
      data.append("checked", toggleValue);
      await axios.post(this.settings.ajaxUrl, data);
      await this.saveZone(zone);
      await this.getZones();
    },
    debounceUpdateRate(zone, shipping_method, event) {
      const cost = event.target.value;
      // set value
      shipping_method.settings.cost = cost;
      // automatically update when typing
      clearTimeout(this.updateTimer);
      this.updateTimer = setTimeout(() => {
        this.updateRate(zone, shipping_method, cost);
      }, 750);
    },
    async updateRate(zone, shipping_method, cost) {
      this.loading = true;
      let data = new FormData();
      data.append("action", "dokan-update-shipping-method-settings");
      data.append("nonce", this.settings.nonce);
      data.append("zoneID", zone.id);
      data.append("data[instance_id]", shipping_method.instance_id);
      data.append("data[method_id]", "flat_rate");
      data.append("data[settings][cost]", cost);
      data.append("data[settings][title]", "Flat Rate");
      data.append("data[settings][description]", "");
      data.append("data[settings][tax_status]", "none");
      data.append("data[settings][calculation_type]", "class");
      data.append("data[is_tax_status]", "no");
      await axios.post(this.settings.ajaxUrl, data);
      await this.saveZone(zone);
      await this.getZones();
    },
  },
};
</script>
<style>
.bidstitchtools-shipping-rates-editor {
  border: 1px solid #eee;
  padding: 16px;
  position: relative;
  min-height: 100px;
}
.bidstitchtools-shipping-rates-editor__zones {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  grid-gap: 0 3rem;
  padding-bottom: 32px;
  position: relative;
}
.bidstitchtools-shipping-rates-editor__zone {
  display: flex;
  align-items: center;
  border-bottom: 1px solid #ccc;
  padding: 32px 0;
}
.bidstitchtools-shipping-rates-editor__name {
  flex-grow: 1;
  font-weight: bold;
}
.bidstitchtools-shipping-rates-editor__shipping {
  display: flex;
  align-items: center;
}
.bidstitchtools-shipping-rates-editor__shipping .switch {
  margin-bottom: 0;
}

.bidstitchtools-shipping-rates-editor__input-text {
  height: 30px !important;
  width: 80px !important;
  text-align: center;
  margin-bottom: 0;
  margin-right: 20px;
  padding-right: 0 !important;
}
.bidstitchtools-shipping-rates-editor__loading {
  position: absolute;
  left: 0;
  right: 0;
  background: #ffffffc4;
  z-index: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  bottom: 0;
  top: 0;
}
</style>


