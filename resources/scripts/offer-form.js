export default function () {
    window.offerForm = function () {
        return {
            modalOpen: false,
            status: 'idle',
            statusMessage: '',
            error: false,
            handleInitialMount() {
                const urlParams = new URLSearchParams(window.location.search);

                const offerButtonParam = urlParams.get('aewcobtn');
                const offerIdParam = urlParams.get('offer-pid');

                if (!offerButtonParam) return;
                if (!offerIdParam) return;

                const target = this.$refs['action_init'];

                this.handleModalOpen({ target });
            },
            handleModalOpen(e) {
                // get data attributes
                const defaultData = e.target.dataset;
                if (!defaultData) return;

                const {
                    offer_price,
                    offer_id,
                    offer_action,
                    offer_product_id,
                } = defaultData

                // check if has offer action
                if (!offer_action) return;

                // set field values
                this.$refs['field-offer_id'].value = offer_id ? offer_id : '';
                this.$refs['field-offer_price'].value = offer_price ? offer_price : '';
                this.$refs['field-offer_action'].value = offer_action ? offer_action : '';
                this.$refs['field-offer_product_id'].value = offer_product_id ? offer_product_id : '';

                // set modal status to open
                this.modalOpen = true;
            },
            handleFieldReset() {
                // reset field values
                this.$refs['field-offer_id'].value = '';
                this.$refs['field-offer_price'].value = '';
                this.$refs['field-offer_notes'].value = '';
                this.$refs['field-offer_action'].value = '';
                this.$refs['field-offer_product_id'].value = '';
            },
            handleModalClose() {
                // check if current status is loading
                if (this.status === 'loading') return;

                // reset field values
                this.handleFieldReset();

                // set status to idle state
                this.status = 'idle';

                // reset status message
                this.statusMessage = '';

                // set modal status to closed
                this.modalOpen = false;
            },
            handleResponse(status, message) {
                if (!status)
                    return this.handleError();

                // error status types
                const statusFailList = [
                    'failed-custom',
                    'failed-spam',
                    'failed',
                ];

                // success status types
                const statusSuccessList = [
                    'success'
                ];

                // check if is error status
                if (statusFailList.includes(status))
                    return this.handleError(message);

                // check if is success status
                if (statusSuccessList.includes(status))
                    return this.handleSuccess(message);

                return this.handleError();
            },
            handleError(message = 'Something went wrong!') {
                // set success status
                this.status = 'error';

                // set success message
                this.statusMessage = message;
            },
            handleSuccess(message = 'Your offer has been sent!') {
                // set success status
                this.status = 'success';

                // set success message
                this.statusMessage = message;

                // reset field values
                this.handleFieldReset();

                // reload page
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            },
            handleSubmit(e) {
                e.preventDefault();

                // get form data
                const formData = new FormData();

                // set form data
                formData.append('action', 'bidstitch-offer-form-submit');
                formData.append('nonce', this.$refs['field-nonce'].value);
                formData.append('offer_id', this.$refs['field-offer_id'].value);
                formData.append('offer_price', this.$refs['field-offer_price'].value);
                formData.append('offer_notes', this.$refs['field-offer_notes'].value);
                formData.append('offer_action', this.$refs['field-offer_action'].value);
                formData.append('offer_product_id', this.$refs['field-offer_product_id'].value);

                // set loading status
                this.status = 'loading';

                fetch(bidstitchSettings.ajaxUrl, {
                    method: 'POST',
                    body: formData
                })
                    .then((response) => {
                        return response.json();
                    })
                    .then((data) => {
                        const {
                            statusmsg,
                            statusmsgDetail,
                        } = data;

                        this.handleResponse(statusmsg, statusmsgDetail);
                    })
                    .catch(() => {
                        this.handleError();
                    });
            },
            validateMaxLength(e) {
                const targetEl = e.target;

                // get max length of input field
                const maxLength = targetEl.getAttribute('maxlength');
                if (!maxLength) return;

                // get current length of input field
                const curLength = targetEl.value.length;

                // check if input exceeds max character length
                if (curLength > maxLength)
                    targetEl.value = targetEl.value.slice(0, maxLength)
            },
            handleInput(e) {
                this.validateMaxLength(e);
            },
        }
    }
}
