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
        <!---->
        <!--        <div class="slide active now">-->
        <!--            <div class="time_lesson">-->
        <!--                <h2 class="lesson_index"> Alko - Inu </h2>-->
        <!--                <div class="lesson_range">-->
        <!--                    <h2>09^00 - 10^30 </h2>-->
        <!--                </div>-->
        <!---->
        <!--                <h2 class="lesson_name"> Lorem ipsum dolor sit. </h2>-->
        <!--            </div>-->
        <!---->
        <!--            <div class="professor">-->
        <!--                <h2> Преподаватель: </h2>-->
        <!--                <h2 class="prof_name"> Исаков С.С. </h2>-->
        <!--            </div>-->
        <!---->
        <!--            <div class="room">-->
        <!--                <h2> Аудитория: </h2>-->
        <!--                <h2 class="room_number"> 669 </h2>-->
        <!--            </div>-->
        <!--        </div>-->

    </div>

    <div id="profile_selection_overlay" class="overlay">
        <div class="modal">
            <div class="tab-list">
                <input type="radio" name="profile_selector" id="student_tab" class="tab_selector" checked>
                <label for="student_tab" class="tab_selector_label">
                    Студент
                </label>
                <input type="radio" name="profile_selector" id="professor_tab" class="tab_selector">
                <label for="professor_tab" class="tab_selector_label">
                    Преподаватель
                </label>
            </div>
            <div class="tab-content">
                <div id="student_tab_content" class="active">
                    <select name="type" required="">
                        <option class="op" selected>Выберите факультет</option>

                    </select>

                    <select name="type" required="">
                        <option class="op" selected>Выберите группу</option>

                    </select>

                    <button type="submit" class="btn"> Показать</button>
                </div>
                <div id="professor_tab_content">
                    <select name="type" class="professor_tab" required="">
                        <option class="op" selected>Выберите преподавателя</option>
                        <option class="op">Попков</option>

                    </select>

                    <button type="submit" class="btn"> Показать</button>
                </div>
            </div>
        </div>
    </div>
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

    function slideClicked(e) {
        $('.slide').removeClass('active');
        console.log(e.target, e);
        e.currentTarget.classList.add('active')
    }


    function fillSlideWithLesson(slide, lesson) {
        slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lesson.Number}`);
        slide.find('.lesson_name').html(`${lesson.Discipline}`);
        slide.find('.prof_name').html(`${lesson.TeacherFIO}`);
        slide.find('.room_number').html(`${lesson.Room}`);
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
            return lesson.GroupCode === '19ИТ-ПИ(б/о)ПИП-1';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        generateSlides(currentDayLessons.length);
        currentDayLessons.forEach(function (lesson, index, lessons) {
            currentDayLessons.length;
            fillSlideWithLesson($(`.slide:eq(${index})`), lesson);
        })
        console.log(currentDayLessons);
        console.log(currentDayLessons.length);

    })

    function generateSlides(amount) {
        for (let i = 0; i < amount; i++) {
            let slide = $(`<div class="slide">
                <div class="time_lesson">
                <h2 class="lesson_index"></h2>
            <div class="lesson_range">
                <h2></h2>
            </div>
            <h2 class="lesson_name"></h2>
        </div>
            <div class="professor">
                <h2> Преподаватель: </h2>
                <h2 class="prof_name"></h2>
            </div>
            <div class="room">
                <h2> Аудитория: </h2>
                <h2 class="room_number"></h2>
            </div>
            </div>`);
            slide.click(slideClicked);
            $('.container').append(slide)
        }
    }
</script>

</html>
