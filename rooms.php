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
            <h2 class="building"> Освободились </h2>

            <div class="professor"> </div>
        </div>

        <div class="slide active now" id="exist_now">
            <h2 class="building"> Сейчас в корпусе </h2>
            <div class="professor"> </div>
        </div>

        <div class="slide" id="will_come">
            <h2 class="building"> Ещё придут </h2>

            <div class="professor"> </div>

        </div>

    </div>

    <?php include 'choice.php'; ?>

</div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/choice.js"></script>
<script>

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

    // const slides = document.querySelectorAll('.slide')
    //
    // for (const slide of slides) {
    //     slide.addEventListener('click', () => {
    //         clearActiveClasses()
    //         slide.classList.add('active')
    //     })
    // }
    //
    // function clearActiveClasses() {
    //     slides.forEach((slide) => {
    //         slide.classList.remove('active')
    //     })
    // }

    function fillSlideWithLesson(slide, lesson) {
        slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lesson.Number}`);
        // slide.find('.lesson_name').html(`${lesson.Discipline}`);
        //slide.find('.prof_name').html(`${lesson.TeacherFIO}`);
        slide.find('.room_number').html(`${lesson.Room}`);
    }

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
            fillSlideWithLesson($(`.slide:eq(${index})`), lesson);
            console.log(lesson);
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
                         <h2> Кабинеты </h2>
                    </div>
                    <h2 class="lesson_name"></h2>
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