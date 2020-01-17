// Make your own here: http://eternicode.github.io/bootstrap-datepicker

var dateSelect     = $('#flight-datepicker');
var dateDepart     = $('#start-date');
var dateReturn     = $('#end-date');
var spanDepart     = $('.date-depart');
var spanReturn     = $('.date-return');
var spanDateFormat = 'ddd, MMMM D yyyy';

dateSelect.datepicker({
    language: 'fr',
    autoclose: true,
    format: "dd/mm/yyyy",
    maxViewMode: 0,
    clearBtn: true,
    startDate: "now"
}).on('change', function() {
    var start = $.format.date(dateDepart.datepicker('getDate'), spanDateFormat);
    var end = $.format.date(dateReturn.datepicker('getDate'), spanDateFormat);
    spanDepart.text(start);
    spanReturn.text(end);
});