// инициализирует тайм пикер по всему приложению, подключается в мастере
$(document).ready(function () {
    Daterangepicker.activate();
});

let Daterangepicker = {
    activate: function () {
        let dateRangePickerLocale = {
            "format": "DD.MM.YYYY",
            "separator": " - ",
            "applyLabel": "Применить",
            "cancelLabel": "Очистить",
            "fromLabel": "От",
            "toLabel": "До",
            "customRangeLabel": "Свой диапазон",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        };

         let dateRangePickerLocaleTime =  Object.assign({}, dateRangePickerLocale);
         dateRangePickerLocaleTime.format = dateRangePickerLocaleTime.format + ' H:mm';

// Инициализация daterangepicker
        $(document).find('input.date-range-picker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'))
                .trigger('change');
        }).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('').trigger('change');
        }).daterangepicker({
            autoUpdateInput: false,
            alwaysShowCalendars: true,
            cancelClass: "btn-danger",
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: dateRangePickerLocale
        });

        $(document).find('input.date-picker')
            .on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('').trigger('change');
            })
            .daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                locale: dateRangePickerLocale
            }, function (start, end, label) {
                $(this.element).val(start.format('DD.MM.YYYY'));
            });

        $(document).find('input.date-picker-autocomplete')
            .daterangepicker({
                singleDatePicker: true,
                locale: dateRangePickerLocale
            }, function (start, end, label) {
                $(this.element).val(start.format('DD.MM.YYYY'));
            });

        $(document).find('input.date-picker-time')
            .daterangepicker({
                singleDatePicker: true,
                timePicker24Hour: true,
                timePicker: true,
                locale: dateRangePickerLocaleTime,
            }, function (start, end, label) {
                $(this.element).val(start.format('DD.MM.YYYY H:mm'));
            });
    }
};
