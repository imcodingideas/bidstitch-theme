export default function () {
    window.eventRegistration = function () {
        return {
            modalOpen: false,

            init() {
                this.$refs.registrationForm.querySelector('.gform_button').remove();
            },

            openModal(eventTitle) {
                this.modalOpen = true;
            },

            closeModal() {
                this.modalOpen = false;
            },

            submitForm() {
                this.$refs.registrationForm.querySelector('form').submit();
            },
        }
    }
}