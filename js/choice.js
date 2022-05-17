const overlay_menu = document.getElementById('overlay_menu');
const menu = document.getElementById('menu');
const student_tab = document.getElementById('student_tab');
const profile_selection_overlay = $('#profile_selection_overlay');
let wishTimetable = '';

function toggleModal(closingObject, openingObject) {
    $(closingObject).css('display', 'none');
    $('#ham-menu').prop('checked', false)
    openingObject.addClass('active');
}

$("#time_today, #time_week, #time_term").click(function () {
    wishTimetable = $(this).attr('id');
    toggleModal([menu, overlay_menu], profile_selection_overlay);
});

$('.tab_selector').click(function (event) {
    console.log(event.target.id)
    $('.tab-content .active').removeClass('active');
    $('.tab-content').children(`#${event.target.id}_content`).addClass('active');
});

$.getJSON('groups.json', function (receivedGroups) {
    console.log(receivedGroups)
    receivedGroups.forEach(function (group, index) {
        $('#group_choice').append(`<option class="name_group" value="${group.id}"> ${group.name} </option>`)
    })
})

$(`.overlay`).click(function (event) {
    if (event.target === $(this).get(0)) {
        profile_selection_overlay.removeClass('active');
        $('#overlay_menu').removeAttr('style');
        $('#menu').removeAttr('style');
        $('#ham-menu').attr('checked', false);
    }
})

$('#group_choice').change(function () {
    console.log("МЯЯЯЯЯУ", $(this).val(), $(this).find('option:selected').html())
    localStorage.setItem('group', JSON.stringify({
        id: $(this).val(),
        name: $(this).find('option:selected').html().trim()
    }))
})

$('#showTimetable').click(function () {
    let selectedTab = $('.tab-list input[type="radio"]:checked').attr('id')

    console.log("Ща покажем для", selectedTab, wishTimetable);
    if( wishTimetable ==='time_today'){
        location.replace('index.php');
    } else {
        location.replace('loading.php');
    }
})

