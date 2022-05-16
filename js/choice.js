const overlay_menu = document.getElementById('overlay_menu');
const menu = document.getElementById('menu');
const student_tab = document.getElementById('student_tab');
const profile_selection_overlay = $('#profile_selection_overlay');

function toggleModal(closingObject, openingObject) {
    $(closingObject).css('display', 'none');
    $('#ham-menu').prop('checked', false)
    openingObject.addClass('active');
}

document.getElementById("time_today").onclick = function () {
    toggleModal([menu, overlay_menu], profile_selection_overlay);
}

document.getElementById("time_week").onclick = function () {
    toggleModal([menu, overlay_menu], profile_selection_overlay);
}

document.getElementById("time_term").onclick = function () {
    toggleModal([menu, overlay_menu], profile_selection_overlay);
}

$('.tab_selector').click(function (event) {
    console.log(event.target.id)
    $('.tab-content .active').removeClass('active');
    $('.tab-content').children(`#${event.target.id}_content`).addClass('active');
});

$.getJSON('groups.json', function (receivedGroups) {
    console.log(receivedGroups)
    receivedGroups.forEach(function (group, index){
        $('#group_choice').append(`<option class="name_group" value="${group.id}"> ${group.name} </option>`)
    })
})

$(`.overlay`).click(function (event){
    $(this).css('display', 'none');
})