jQuery(function ($) {

    const form = $('#contact-form');

    form.on('submit', function (event) {

        const formData = new FormData(form[0]);

        formData.append('action', 'testdevwp_submit_form');
        
        $.ajax({
            url: testdevwp_form_object.ajaxurl,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function (){
                //
            },
            success: function (response) {
                if (response.success) {
                    form[0].reset();
                }
            },
        })
        event.preventDefault();
        event.stopPropagation();
    });
});