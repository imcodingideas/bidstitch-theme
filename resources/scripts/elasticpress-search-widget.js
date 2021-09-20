export default function () {

    window.elasticpressSearchWidget = function () {
        return {
            tab: 'products',
            results: {},
            search: '',
            hide: true,
            getData(searchExpression) {
                let url = new URL(`${bidstitchSettings.themeUrl}/elasticproxy/search.php`)
                const params = {
                    s: searchExpression
                }
                url.search = new URLSearchParams(params).toString()
                fetch(url)
                    .then((r) => r.json())
                    .then(
                        (r) => {
                            // console.log(r);
                            this.results = r;
                        }
                    )
            },
            inputChanged() {
                if (this.search.length) {
                    this.getData(this.search)
                }
                else {
                    this.results = []
                }
            },
            handleSubmit(e) {
                e.preventDefault();

                if (!this.tab) return;
                if (!this.search.length) return;

                let url;
                
                switch(this.tab) {
                    case 'vendors':
                        if (!bidstitchSettings.vendorUrl) return;
                        url = new URL(bidstitchSettings.vendorUrl);

                        url.searchParams.set('dokan_seller_search', this.search);

                        break;
                    case 'products':
                        if (!bidstitchSettings.shopUrl) return;
                        url = new URL(bidstitchSettings.shopUrl);

                        url.searchParams.set('s', this.search);

                        break;
                }

                if (!url) return;
                window.location = url;
            }
        }
    }

}
