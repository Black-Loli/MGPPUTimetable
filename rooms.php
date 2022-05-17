<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>...</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.php'; ?>

    <div class="container">

        <!--        <div class="slide active now">-->
        <!--            <div class="time_lesson">-->
        <!--                <h2 class="lesson_index"></h2>-->
        <!--                <div class="lesson_range">-->
        <!--                    <h2> </h2>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="room"></div>-->
        <!--        </div>-->
        <!---->
        <!--        <div class="slide">-->
        <!--            <div class="time_lesson">-->
        <!--                <h2 class="lesson_index"></h2>-->
        <!--                <div class="lesson_range">-->
        <!--                    <h2> </h2>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="room"></div>-->
        <!--        </div>-->

    </div>

    <?php include 'choice.php'; ?>

</div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/moment.js"></script>
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

    function fillSlideWithRooms(slide, lesson) {
        var startDate = moment(lesson.TimeStart, "HH:mm:ss");
        var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
        if( moment(moment().format('HH:mm:ss'),'HH:mm:ss').isBetween(startDate, endDate) ){
            slide.addClass('now active')
        }
        slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lesson.Number}`);
        // slide.find('.lesson_name').html(`${lesson.Discipline}`);
        //slide.find('.prof_name').html(`${lesson.TeacherFIO}`);
        slide.find('.rooms').append(`<h2 class="room_number_used">${lesson.Room}</h2>`);
    }

    $.getJSON('timetable.json', function (receivedLessons) {
        const currentDate = new Date();
        console.log(`${currentDate.getDay()}.${currentDate.getMonth()}.${currentDate.getFullYear()}`);
        // const currentDayLessons = getLessonsForDate(receivedLessons, '12.05.2022').filter(function (lesson) {
        const currentDayLessons = getLessonsForDate(receivedLessons, moment().format(`DD.MM.YYYY`)).filter(function (lesson) {
            return lesson.DepartmentCode === 'ИТ';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        generateSlides(5);
        for (let i = 0; i < 5; i++) {
            let slide = $(`.slide:eq(${i})`);
            currentDayLessons.filter(function (lesson, index) {
                return lesson.Number === `${i + 1} пара`
            }).forEach(function (lesson, index, lessons) {
                fillSlideWithRooms(slide, lesson);
            })
        }

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
            </div>
            <div class="rooms"></div>
        </div>`);
            slide.click(slideClicked);
            $('.container').append(slide)
        }
    }
</script>

</html>