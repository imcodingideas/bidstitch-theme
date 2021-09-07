import 'jquery';

export default function() {
    const domNodes = {
        input: '.checkout__shipping__input',
        content: '.checkout__shipping__content'
    };

    const classList = {
        contentActive: 'flex',
        contentInactive: 'hidden'
    };

    function handleInputChange() {
        const targetContentNode = $(domNodes.content);

        if ($(this).prop('checked')) {
            $(targetContentNode).removeClass(classList.contentInactive);
            $(targetContentNode).addClass(classList.contentActive);

            return;
        }

        $(targetContentNode).removeClass(classList.contentActive);
        $(targetContentNode).addClass(classList.contentInactive);
    }

    $(domNodes.input).change(handleInputChange);
}