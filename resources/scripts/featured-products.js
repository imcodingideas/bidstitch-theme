export default function() {
  window.featuredProducts = function() {
      return {
          productId: null,
          featured: null,

          init(productId, featured) {
              this.productId = productId;
              this.featured = featured;
          },

          toggleFeatured() {
              this.featured = !this.featured;

              fetch('/wp-json/bidstitch/v1/feature-product', {
                  method: 'POST',
                  headers: {
                      'X-WP-Nonce': bidstitchFeaturedSettings.nonce,
                      'Content-Type': 'application/json; charset=utf-8',
                  },
                  body: JSON.stringify({
                      product_id: this.productId,
                      featured: this.featured,
                  }),
              }).catch(err => {
                  console.log('AJAX error');
                  alert('There was an error, please try again later');
              });
          },
      }
  }
}
