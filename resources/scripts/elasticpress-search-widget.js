export default function () {

    window.elasticpressSearchWidget = function () {
        return {
            results: [],
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
                            this.results = r
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
            }
        }
    }

}
