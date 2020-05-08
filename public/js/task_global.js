let TaskGlobal = {

    getInfo: function (taskInfoUrl) {
        $("#task_show_modal_content").html(errorMessage);
        jQuery.ajaxSetup({async: false});
        $.get(taskInfoUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        $('#task_show_modal').modal('show');

        return true;
    },

    editTask: function (editUrl) {
        jQuery.ajaxSetup({async: false});
        $.get(editUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        $('#task_show_modal').modal('show');
        Daterangepicker.activate();
        setTimeout("TaskGlobal.select2Activate();", 1000);
    },

    deleteTask: function (deleteUrl) {

        let thisGeneral = this;

        if (deleteUrl) {
            thisGeneral.destroyElement = function () {
                let data = new FormData();
                data.append('_token', config.token);
                data.append('_method', 'DELETE');

                let successFunction = function (data) {
                    if (data.status == 'false') {
                        alert('Ошибка при удалении')
                    }
                    if(typeof(calendar) != "undefined" && calendar !== null) {
                        calendar.refetchEvents();
                    }
                    Main.modalWithConfirm.hideModal();
                    $('#task_show_modal').modal('hide');
                };

                Main.ajaxRequest('POST', deleteUrl, data, successFunction);

            };
            Main.modalConfirm('Удалить Задачу/Приказ', 'TaskGlobal.destroyElement()')
        }
    },

    checkSelectAll: function () {
        if ($("#task_select_all").prop("checked")) {
            $("#user_ids").prop("disabled", true);
            $("#structural_unit_id").prop("disabled", true);
        } else {
            $("#user_ids").prop("disabled", false);
            $("#structural_unit_id").prop("disabled", false);
        }
    },

    checkSelectUnit: function () {
        if ($("#structural_unit_id").val() != '') {
            $("#user_ids").prop("disabled", true);
        } else {
            $("#user_ids").prop("disabled", false);
        }
    },

    createTask: function (createUrl) {
        $("#task_show_modal_content").html(errorMessage);
        jQuery.ajaxSetup({async: false});
        $.get(createUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        $('#task_show_modal').modal('show');

        Daterangepicker.activate();

        // не понимаю в чем дело. если написать сразу TaskGlobal.select2Activate() то съезжает верстка, однако если написать в консоле браузера то всё норм,
        // что-то где-то не успевает. пока вот такой костыль
        setTimeout("TaskGlobal.select2Activate();", 1000);
    },

    storeOrUpdate: function (action) {
        let formData = new FormData(task_form_data);
        $.ajax({
            type: 'POST',
            url: action,
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#task_show_modal').modal('hide');
                Main.popUp('Успешно сохранено');
                if(typeof(calendar) != "undefined" && calendar !== null) {
                    calendar.refetchEvents();
                }

            },
            error: function (data) {
                if (data.status == 422) {
                    var errors = JSON.parse(data.responseText);
                    $("#task_show_modal_content").find(".alert-danger.alert-important").remove();
                    $("#task_show_modal_content").find('.is-invalid').removeClass('is-invalid');
                    TaskGlobal.showErrorsValidation(errors.errors);
                } else {
                    Main.popUp('Произошла ошибка, попробуйте еще раз');
                }
            },
        });
    },

    showErrorsValidation: function (data) {
        $.each(data, function (key, value) {
            let html =
                '<div class="alert alert-danger alert-important">' +
                value +
                '</div>';
            key = key.split('.')[0];
            $("#task_show_modal_content").find('[name*=' + key + ']').addClass('is-invalid');
            $("#task_show_modal_content").find('[name*=' + key + ']').parent().append(html);
        });
    },

    select2Activate: function () {
        $(document).find('select.select2-ajax-data').select2({
            language: Main.autocompleteLanguageConfig,
            placeholder: $(this).attr('data-placeholder'),
            // minimumInputLength: 1,
            ajax: {
                url: function (params) {
                    return $(this).attr('data-action');
                },
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term,
                        page: params.page || 1
                    };
                },
                delay: 250,
            }
        });

        $(document).find('select.select2').select2({
            language: Main.autocompleteLanguageConfig
        });
    },

};
