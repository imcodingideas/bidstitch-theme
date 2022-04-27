export default function () {
    window.shopifyExportData = function () {
        return {
            productId: null,
            exported: null,

            init(productId, exported) {
                this.productId = productId;
                this.exported = exported;
            },

            exportProduct() {
                let confirmMessage = this.exported ? 'This product has already been exported to Shopify. Export again?' : 'Export this product to Shopify?'

                if (!confirm(confirmMessage)) {
                    return;
                }

                // TODO: pass fqdn
                const formData = new FormData();
                formData.append('action', 'shopify_export');
                formData.append('product_id', this.productId);

                fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                // TODO: set this.exported = true
                .then(data => console.log(data))
                .catch(err => {
                    console.log('Shopify export AJAX error');
                    alert('There was an error exporting your product, please try again later');
                });
            },
        }
    }
}
