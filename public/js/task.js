var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {

    plugins: ['interaction', 'dayGrid', 'timeGrid'],
    // defaultView: 'dayGridMonth',
    locale: 'ru',
    header: false,
    buttonIcons: false, // show the prev/next text
    weekNumbers: true,
    navLinks: true, // can click day/week names to navigate views
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    displayEventTime: true,
    aspectRatio: 1.5,
    scrollTime: '00:00',
    defaultView: 'dayGridMonth',
    eventRender: function (info) {
        $(info.el).append(info.event.rendering);
    },
    eventSources: [
        {
            url: getTasksUrl, // use the `url` property
            color: 'yellow',    // an option!
            textColor: 'black',  // an option!
            extraParams: function () {
                return {
                    users: $('#responsible_users').val(),
                    taskStatus: $('#task_status').val(),
                };
            }
        }
    ],
    eventClick: function (info) {
        jQuery.ajaxSetup({async: false});
        $.get(info.event.extendedProps.taskInfoUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        $('#task_show_modal').modal('show');
    },
    viewSkeletonRender: function (view, element) {
        let date;
        switch (view.type) {
            case 'timeGridDay':
                date = view.start.format('DD dddd YYYY')
                break
            case 'timeGridWeek':
                date = view.start.format('MMMM')
                break
            case 'dayGridMonth':
                date = view.start.format('MMMM')
                break
        }
        $('#title').text(view.view.title);
    },
    datesRender: function (view, el) {
        let date
        switch (view.type) {
            case 'timeGridDay':
                date = view.start.format('DD dddd YYYY')
                break
            case 'timeGridWeek':
                date = view.start.format('MMMM')
                break
            case 'dayGridMonth':
                date = view.start.format('MMMM')
                break
        }
        $('#title').text(view.view.title);
    },
});
calendar.render();

$('.task_primary').click(function () {
    var grid = $(this).data('grid');
    calendar.changeView(grid);
});

$("#calendar-custom-prev").on('click', function () {
    calendar.prev();
});
$("#calendar-custom-next").on('click', function () {
    calendar.next();
});
$("#calendar-custom-today").on('click', function () {
    calendar.today();
});

// $('#status-info').on('click', function () {
//     $('#status-info-block').toggleClass("active");
// });

$('.refetch_events').on('change', function (e) {
    calendar.refetchEvents();
});

$('#calendar-show-filter').on('click', function () {
    $('#task-filter').toggleClass("active");
});

$('#task_years_show').on('click', function () {
    $('#task_years').toggleClass("active");
});

$('.task_data_goto').click(function () {
   Task.setDate(this);
});

let Task = {
    setDate: function (element) {
        var gotoDate = $(element).data('goto');
        var tglCurrent = calendar.getDate();
        if (String(gotoDate).length == 4) {
            var tgl = moment(tglCurrent).format('MM-DD');
            var needlDate = gotoDate + '-' + tgl;
        }
        if (String(gotoDate).length == 7) {
            var tgl = moment(tglCurrent).format('DD');
            var needlDate = gotoDate + '-' + tgl;
        }
        if (String(gotoDate).length == 2) {
            var tgl = moment(tglCurrent).format('YYYY-MM');
            var needlDate = tgl + '-' + gotoDate;
        }
        if (String(gotoDate).length == 10) {
            var needlDate = gotoDate;
        }
        var isoDat = moment(needlDate).format('YYYY-MM-DD HH:mm');
        calendar.gotoDate(isoDat);
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
                    calendar.refetchEvents();
                    Main.modalWithConfirm.hideModal();
                    $('#task_show_modal').modal('hide');
                };

                Main.ajaxRequest('POST', deleteUrl, data, successFunction);

            };
            Main.modalConfirm('Удалить Задачу/Приказ', 'Task.destroyElement()')
        }
    },

    createTask: function (createUrl) {
        jQuery.ajaxSetup({async: false});
        $.get(createUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        $('#task_show_modal').modal('show');

        Daterangepicker.activate();

        // не понимаю в чем дело. если написать сразу Task.select2Activate() то съезжает верстка, однако если написать в консоле браузера то всё норм,
        // что-то где-то не успевает. пока вот такой костыль
        setTimeout("Task.select2Activate();", 1000);
    },

    editTask: function (editUrl) {
        jQuery.ajaxSetup({async: false});
        $.get(editUrl, function (data) {
            $("#task_show_modal_content").html(data);
        });
        Daterangepicker.activate();
        Task.select2Activate();
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
                calendar.refetchEvents();
                $('#task_show_modal').modal('hide');
                Main.popUp('Успешно сохранено');
            },
            error: function (data) {
                if (data.status == 422) {
                    var errors = JSON.parse(data.responseText);
                    $("#task_show_modal_content").find(".alert-danger.alert-important").remove();
                    $("#task_show_modal_content").find('.is-invalid').removeClass('is-invalid');
                    Task.showErrorsValidation(errors.errors);
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

    selectDate: function () {
        $(".task_absolute").hide();
        let view =  calendar.view;
        if(view.type == 'dayGridMonth'){
            $("#task_absolute_month").show();
        }
        if(view.type == 'dayGridDay' || view.type =='timeGridDay'){
            let year = calendar.getDate().getFullYear();
            let month = calendar.getDate().getMonth()+1;
            let count = new Date(year, month, 0).getDate();
            let html ='';
            let k;
            for(i = 1; i < count+1; i++){
                k = i;
                if(i < 10) {
                    k = '0' + i;
                }
                html += '<button onclick="Task.setDate(this)" class="btn btn-default task_absolute_day_button" data-goto="' + k + '">' + i+ '</button>';
            }
            $("#task_absolute_day").html(html);
            $("#task_absolute_day").show();
        }
        if(view.type == 'timeGridWeek'){
            let currentDate = calendar.getDate();
            let currentFormatedDate =  moment(currentDate).format('DD.MM.YYYY');

            let formData = new FormData();
            formData.append('_token', config.token);
            formData.append('date',currentFormatedDate);
            $.ajax({
                type: 'POST',
                url: getTaskWeeks,
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#task_absolute_weeks").html(data);
                    $("#task_absolute_weeks").show();
                },
            });
        }
    },
};

jQuery(function($){
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".task_absolute"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.hide(); // скрываем его
        }
    });
});
