
$(document).ready(function(){
    let dropdown = $('#inputState');
    $.getJSON("http://se.shenkar.ac.il/students/2020-2021/web1/dev_209/data/balance.json", function (data) {
        $.each(data, function (key, entry) {
        dropdown.append($('<option></option>').attr('value', entry).text(key));
        });
    });
});