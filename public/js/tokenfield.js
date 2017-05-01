$('#tokenfield').tokenfield({
    autocomplete: {
        source: "/api/tags",
        minLength: 1,
        delay: 100
    },
    showAutocompleteOnFocus: true
});