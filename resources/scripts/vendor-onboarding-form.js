import 'jquery';
export default function() {
    jQuery(document).on('ready', function() {
        function getStates(countryCode = '') {
            const endpoint = `/wp-json/onboarding/v1/states/?country=${countryCode}`;
    
            return new Promise((resolve) => {
                if (!countryCode) return resolve(false);

                fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'X-WP-Nonce': bidstitchSettings.restNonce
                    }
                })
                .then((response) => {
                    response.json()
                    .then((data) => {
                        return resolve(data.data);
                    })
                })
                .catch(() => {
                    resolve(false)
                });
            });
        }
        
        const domNodes = {
            form: '.onboarding__form',
            inputState: '.onboarding__field--state',
            inputCountry: '.onboarding__field--country'
        };

        function createInputNode(elementType) {
            const selectNode = document.createElement(elementType);
            
            $(selectNode).attr('placeholder', $(domNodes.inputState).attr('placeholder'));
            $(selectNode).attr('name', $(domNodes.inputState).attr('name'));
            $(selectNode).attr('class', $(domNodes.inputState).attr('class'));
            $(selectNode).attr('id', $(domNodes.inputState).attr('id'));

            if (elementType === 'input') {
                $(selectNode).attr('type', 'text');
            }

            return selectNode;
        }

        const stateSelectNode = createInputNode('select');
        const stateInputNode = createInputNode('input');

        function handleDisable() {
            $(domNodes.inputState).addClass('disabled');
            $(domNodes.inputState).prop('disabled', true);
        }

        function handleEnable() {
            $(domNodes.inputState).removeClass('disabled');
            $(domNodes.inputState).prop('disabled', false);
        }

        function handleInputChange() {
            // Disable while loading
            handleDisable();
            
            getStates($(this).val())
            .then((states) => {
                if (!states || $.isEmptyObject(states)) {
                    $(domNodes.inputState).replaceWith(stateInputNode);
                    return handleEnable();
                }
    
                const options = Object.keys(states).map((item) => {
                    const currentChoice = $(domNodes.inputState).attr('value') === item;
    
                    return new Option(item, item, currentChoice, currentChoice);
                });

                // If is select node, update existing options
                if ($(domNodes.inputState).is('select')) {
                    $(domNodes.inputState).empty().append(options);
                    return handleEnable();
                }
    
                // If is text node, replace with populated select node
                $(stateSelectNode).empty().append(options);
                $(domNodes.inputState).replaceWith(stateSelectNode);
                return handleEnable();
            })
        }
        
        $(domNodes.inputCountry).change(handleInputChange);
        $(domNodes.inputCountry).change();
    });
}