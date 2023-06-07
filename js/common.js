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

$("#time_today, #time_week, #time_term").click(function (event) {
    if ((!localStorage.keyExists('group') && event.target.dataset.tabTarget === 'student_tab') || (!localStorage.keyExists('professor') && event.target.dataset.tabTarget === 'professor_tab')){
        event.preventDefault();
        wishTimetable = $(this).attr('id');
        const {tabTarget} = event.target.dataset
        $(`.tab-list input[type="radio"]#${tabTarget}`).attr('checked', true).click();

        toggleModal([menu, overlay_menu], profile_selection_overlay);
    }
});

$('.tab_selector').click(function (event) {
    console.log(event.target.id)
    $('.tab-content .active').removeClass('active');
    $('.tab-content').children(`#${event.target.id}_content`).addClass('active');
});

$.getJSON('groups.json', function (receivedGroups) {
    receivedGroups.forEach(function (group, index) {
        $('#group_choice').append(`<option class="name_group" value="${group.id}"> ${group.name} </option>`)
    });
});
$.getJSON('IT_timetable_spring.json', function (receivedLessons) {
    _(receivedLessons).filter(function (lesson) {
        return lesson.TeacherFIO !== null;
    }).uniqBy('TeacherID').sort(function (lesson1, lesson2) {
        return lesson1.TeacherFIO.localeCompare(lesson2.TeacherFIO);
    }).forEach(function (lesson, index) {
        $('#professor_choice').append(`<option class="name_prof" value="${lesson.TeacherID}"> ${lesson.TeacherFIO}</option>`)
    })
});

$(`.overlay`).click(function (event) {
    if (event.target === $(this).get(0)) {
        profile_selection_overlay.removeClass('active');
        $('#overlay_menu').removeAttr('style');
        $('#menu').removeAttr('style');
        $('#ham-menu').attr('checked', false);
    }
})

$('#professor_choice').change(function () {
    console.log("Профессора котических наук", $(this).val(), $(this).find('option:selected').html())
    localStorage.setItem('professor', JSON.stringify({
        id: $(this).val(),
        name: $(this).find('option:selected').html().trim()
    }))
})

$('#group_choice').change(function () {
    console.log("Котёнок из группы", $(this).val(), $(this).find('option:selected').html())
    localStorage.setItem('group', JSON.stringify({
        id: $(this).val(),
        name: $(this).find('option:selected').html().trim()
    }))
})

$('#showTimetable').click(function () {
    let selectedTab = $('.tab-list input[type="radio"]:checked').attr('id')

    console.log("Ща тыгдыкним для", selectedTab, wishTimetable);
    if (wishTimetable === 'time_today') {
        location.replace('schedule_group_day.php');
    } else if (wishTimetable === 'time_week') {
        location.replace('schedule_group_week.php');
    } else {
        location.replace('schedule_group_month.php');
    }

    if (selectedTab === 'professor_tab') {
        if (wishTimetable === 'time_today') {
            location.replace('schedule_teacher_day.php');
        } else if (wishTimetable === 'time_week') {
            location.replace('schedule_teacher_week.php');
        } else {
            location.replace('schedule_teacher_month.php');
        }
    }
})

function slideClicked(e) {
    $('.slide').removeClass('active');
    e.currentTarget.classList.add('active')
}

function slide_dayClicked(e) {
    $('.slide_day').removeClass('active');
    e.currentTarget.classList.add('active')
}


