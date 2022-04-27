export default function () {
    window.shopifyExportData = function () {
        return {
            productId: null,
            exported: null,
            exporting: false,

            init(productId, exported) {
                this.productId = productId;
                this.exported = exported;
            },

            exportProduct() {
                if (this.exporting) {
                    return;
                }

                let confirmMessage = this.exported ? 'This product has already been exported to Shopify. Export again?' : 'Export this product to Shopify?'

                if (!confirm(confirmMessage)) {
                    return;
                }

                this.exporting = true;

                const url = bidstitchSettings.ajaxUrl;
                const formData = new FormData();
                formData.append('action', 'shopify_export');
                formData.append('product_id', this.productId);

                fetch(url, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    this.exported = response.ok;
                    this.exporting = false;
                })
                .catch(err => {
                    console.log('Shopify export AJAX error');
                    alert('There was an error exporting your product, please try again later');
                    this.exporting = false;
                });
            },
        }
    }
}
