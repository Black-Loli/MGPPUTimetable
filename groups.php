<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>...</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.html'; ?>

    <div class="container">

        <div class="slide" id="already_left">
            <h2 class="building"> Могли уйти </h2>

            <div class="groups"> </div>

        </div>

        <div class="slide active now" id="exist_now">
            <h2 class="building"> Сейчас в корпусе </h2>

            <div class="groups"> </div>

        </div>

        <div class="slide" id="will_come">
            <h2 class="building"> Ещё придут </h2>

            <div class="groups"> </div>

        </div>

    </div>

    <?php include 'choice.php'; ?>

</div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/dark_or_light.js"></script>
<script>
    const overlay_menu = document.getElementById('overlay_menu');
    const menu = document.getElementById('menu');
    const student_tab = document.getElementById('student_tab');
    const profile_selection_overlay = $('#profile_selection_overlay');

    function getLessonsForDate(lessons, date) {
        return lessons.filter(function (lesson) {
            //return lesson.dayDate === `${currentDate.getDay()}.${currentDate.getMonth()}.${currentDate.getFullYear()}`
            return lesson.dayDate === date
        })
    }

    const slides = document.querySelectorAll('.slide')

    for (const slide of slides) {
        slide.addEventListener('click', () => {
            clearActiveClasses()
            slide.classList.add('active')
        })
    }

    function clearActiveClasses() {
        slides.forEach((slide) => {
            slide.classList.remove('active')
        })
    }

    function fillSlideWithLesson(slide, lesson) {
        var startDate = moment(lesson.TimeStart, "HH:mm:ss");
        var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
        if( moment(moment().format('HH:mm:ss'),'HH:mm:ss').isBetween(startDate, endDate) ){
            slide.addClass('now')
        };
        slide.find('.groups_name').html(`${lesson.GroupCode}`);
    }

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

    $.getJSON('timetable.json', function (receivedLessons) {
        // const currentDayLessons = getLessonsForDate(receivedLessons, '12.05.2022').filter(function (lesson) {
        const currentDayLessons = getLessonsForDate(receivedLessons, moment().format(`DD.MM.YYYY`)).filter(function (lesson) {
            return lesson.DepartmentCode === 'ИТ';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        const currentDayGroups = [];
        const futureGroups = [];
        const pastGroups = [];
        currentDayLessons.filter(function (lesson, index, lessons){
            var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
            return ( moment(moment().format('HH:mm:ss'),'HH:mm:ss').isAfter(endDate) );
        }).forEach(function (lesson, index, lessons){
            if (!pastGroups.includes(lesson.GroupCode)){
                pastGroups.push(lesson.GroupCode);
            }
        });
        currentDayLessons.filter(function (lesson, index, lessons){
            var startDate = moment(lesson.TimeStart, "HH:mm:ss");
            return ( moment(moment().format('HH:mm:ss'),'HH:mm:ss').isBefore(startDate) );
        }).forEach(function (lesson, index, lessons){
            if (!futureGroups.includes(lesson.GroupCode)){
                futureGroups.push(lesson.GroupCode);
            }
        });
        currentDayLessons.forEach(function (lesson, index, lessons){
            if (!currentDayGroups.includes(lesson.GroupCode)){
                currentDayGroups.push(lesson.GroupCode);
            }
        });
        generateGroups(currentDayLessons.length);
        currentDayGroups.forEach(function (group, index, groups) {
            currentDayLessons.length;
            // fillSlideWithLesson($(`.slide:eq(0)`).find(`.groups_name:eq(${index})`).html(lesson.GroupCode));
            // fillSlideWithLesson($(`.slide:eq(${index})`), lesson);
            $(`.slide#already_left`).find(`.groups_name:eq(${index})`).html(group);
            console.log(group);
        })

    })

    function generateGroups(amount) {
        for (let i = 0; i < amount; i++) {
            let groups = $(`<h2 class="groups_name"></h2>`);
            $('.groups').append(groups)
        }
    }
</script>

</html>
