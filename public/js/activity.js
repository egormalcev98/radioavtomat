let Activity = {
    search: function () {
        let errorHandle = function (jqXHR, textStatus, errorThrown) {
            let data = jqXHR.responseJSON;

            if (data['errors'] && data['message']) {
                Main.popUp(data['errors']['number'][0]);
            } else {
                Main.popUp('Произошла ошибка, попробуйте еще раз');
            }

        };

        let formData = new FormData();
        formData.append('_token', config.token);
        formData.append('search', $("#activity_search").val());
        formData.append('way',   $('.activity_btn_active').val());

        $.ajax({
            type: 'POST',
            url: '/activity',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#activity_listelements").html(data);
            },
            error: errorHandle
        });
    },

    radioCheck: function (element) {
        $('.activity_btn').removeClass('activity_btn_active');
        element.addClass('activity_btn_active');
        Activity.search();
    },

};
