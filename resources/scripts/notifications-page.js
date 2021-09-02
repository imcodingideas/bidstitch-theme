import Alpine from 'alpinejs'
export default function () {

    window.notificationsPageData = function () {
        return {
            pages: null,
            page: 1,
            perPage: 5,
            tab: 1,
            notifications: [],
            loadMoreLoading: false,
            isLoading: true,
            init() {
                this.getData();
            },
            getData() {
                const formData = new FormData();
                formData.append('action', 'notifications_get');
                formData.append('perPage', this.perPage);
                formData.append('page', this.page);
                fetch(bidstitchSettings.ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                    .then((r) => r.json())
                    .then(
                        (r) => {
                            this.pages = r.pages
                            this.notifications = this.notifications.concat(r.data)
                            this.loadMoreLoading = false;
                            this.isLoading = false;
                        }
                    )
            },
            loadMore() {
                this.loadMoreLoading = true;
                this.getData()
                this.page++
            },
        }
    }

    Alpine.start();
}
