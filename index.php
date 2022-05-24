<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сегодня | Расписание</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.php'; ?>

    <div class="container">

    </div>

<!--    Прикрепление файла с выбором факультета и групыы-->
    <?php include 'choice.php'; ?>


</div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/lodash.js"></script>
<script src="js/moment.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/choice.js"></script>
<script src="js/slides.js"></script>
<script src="js/timeTableHandler.js"></script>
<script>
    function fillSlideWithLesson(slide, lesson) {
        if (lesson.current) {
            slide.addClass('now active')
        }
        slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lesson.Number}`);
        slide.find('.lesson_name').html(`${lesson.Discipline}`);
        slide.find('.prof_name').html(`${lesson.TeacherFIO}`);
        slide.find('.room_number').html(`${lesson.Room}`);
    }

    getTimeTable(function (timeTableHandler) {
        const lessonsArray = timeTableHandler.getCurrentDayLessons().filtrateByGroup().getTable()
        generateSlides(lessonsArray.length);
        console.log(timeTableHandler.getCurrentDayLessons())
        lessonsArray.forEach(function (lesson, index) {
            fillSlideWithLesson($(`.slide:eq(${index})`), lesson);
        })
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
