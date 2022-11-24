jQuery(function ($) {

    $('select:not(#services-types):not(.no-selectize-me)').selectize();

    let select = $("#services-types");
    let services_default_values = $("#services-types").data('default-values');

    select.selectize({
        options: services_default_values,
        preload: true,
        valueField: 'slug',
        labelField: 'name',
        searchField: 'name',
        plugins: ['remove_button'],
        delimiter: '+',
        load: function (query, callback) {

            $.ajax({
                url: testdevwp_search_object.ajaxurl,
                data: { action: 'testdevwp_autocomplete_services', q: encodeURIComponent(query) },
                dataType: 'json',
                type: 'GET',
                error: function () {
                    callback();
                },
                success: function (res) {
                    console.log(res.data.slice(0, 3));
                    callback(res.data.slice(0, 3));
                }
            });
        },

        onInitialize: function () {
            console.log(services_default_values);
            let selectize = this;
            let selected_items = [];

            $.each(services_default_values, function (i, obj) {
                selected_items.push(obj.slug);
            });

            selectize.setValue(selected_items);
        }
    });
});