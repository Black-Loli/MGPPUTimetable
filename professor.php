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

        <div class="slide">
            <h2 class="building"> Могли уйти </h2>

            <div class="professor">

            </div>

        </div>

        <div class="slide active now">
            <h2 class="building"> Сейчас в корпусе </h2>

            <div class="professor">

            </div>

        </div>

        <div class="slide">
            <h2 class="building"> Ещё придут </h2>

            <div class="professor">

            </div>

        </div>

    </div>

    <?php include 'choice.php'; ?>

</div>
</body>

<script src="jquery.min.js"></script>
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

    // function slideClicked(e) {
    //     $('.slide').removeClass('active');
    //     console.log(e.target, e);
    //     e.currentTarget.classList.add('active')
    // }

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
        // slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        // slide.find('.lesson_index').html(`${lesson.Number}`);
        // slide.find('.lesson_name').html(`${lesson.Discipline}`);
        slide.find('.prof_name').html(`${lesson.TeacherFIO}`);
        // slide.find('.room_number').html(`${lesson.Room}`);
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
        const currentDate = new Date();
        console.log(`${currentDate.getDay()}.${currentDate.getMonth()}.${currentDate.getFullYear()}`);
        const currentDayLessons = getLessonsForDate(receivedLessons, '12.05.2022').filter(function (lesson) {
            return lesson.DepartmentCode === 'ИТ';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        generateSlides(currentDayLessons.length);
        currentDayLessons.forEach(function (lesson, index, lessons) {
            currentDayLessons.length;
            // fillSlideWithLesson($(`.slide:eq(0)`).find(`.prof_name:eq(${index})`).html(lesson.TeacheFIO));
            fillSlideWithLesson($(`.slide:eq(${index})`), lesson);
            console.log(lesson);
        })
        console.log(currentDayLessons);
        console.log(currentDayLessons.length);

    })

    function generateSlides(amount) {
        for (let i = 0; i < amount; i++) {
            let slide = $(`
                <h2 class="prof_name"></h2>`);
            $('.professor').append(slide)
        }
    }
</script>

</html>
