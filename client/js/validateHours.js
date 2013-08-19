$("div#log-hours-for-project input.hours-field.Hour-field").change(function() {
    $("div#log-hours-for-project input.hours-field.Hour-field").val(
        roundToQuarter($("div#log-hours-for-project input.hours-field.Hour-field").val());
    )
});

$("div#edit-hours-for-project input.hours-field.Hour-field").change(function() {
    $("div#edit-hours-for-project input.hours-field.Hour-field").val(
        roundToQuarter($("div#edit-hours-for-project input.hours-field.Hour-field").val());
    )
});

$("div#log-hours-for-support input.hours-field.Hour-field").change(function() {
    $("div#log-hours-for-support input.hours-field.Hour-field").val(
        roundToQuarter($("div#log-hours-for-support input.hours-field.Hour-field").val());
    )
});

$("div#edit-hours-for-support input.hours-field.Hour-field").change(function() {
    $("div#edit-hours-for-support input.hours-field.Hour-field").val(
        roundToQuarter($("div#edit-hours-for-support input.hours-field.Hour-field").val());
    )
});

function roundToQuarter(number) {
    return Math.round(number * 4) / 4).toFixed(2);
}
