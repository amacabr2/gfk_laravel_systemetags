$tokenField = $('#tokenfield');

$tokenField.tokenfield({
    autocomplete: {
        source: $tokenField.data('url'),
        minLength: 1,
        delay: 100
    },
    showAutocompleteOnFocus: true
});