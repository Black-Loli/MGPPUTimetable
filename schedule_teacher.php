<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Расписание | Преподаватель</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.php'; ?>

    <div class="container"></div>

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
<script src="js/lodash.min.js"></script>
<script>
    function fillSlideWithLessons(slide, lessons) {
        //работает в рамках одной пары
        if (lessons[0].current) {
            slide.addClass('now active')
        }
        slide.find('.lesson_range h2').html(`${lessons[0].lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lessons[0].Number}`);
        slide.find('.lesson_name').html(`${lessons[0].Discipline}`);
        slide.find('.group_name').html(`${_(lessons).map('GroupCode').value().join('<br>')}`);
        slide.find('.room_number').html(`${lessons[0].Room}`);
    }

    getTimeTable(function (timeTableHandler) {
        const currentDayLessons = timeTableHandler.getCurrentDayLessons().filtrateByTeacher().getTable()
        _(currentDayLessons).groupBy('Number').forEach(function (lessonGrouping) {
            const slide = generateSlide();
            fillSlideWithLessons(slide, lessonGrouping);
            $('.container').append(slide)
        })
    })

    function generateSlide() {
        return $(`<div class="slide">
                <div class="time_lesson">
                <h2 class="lesson_index"></h2>
            <div class="lesson_range">
                <h2></h2>
            </div>
            <h2 class="lesson_name"></h2>
        </div>
            <div class="professor">
                <h2> Группы: </h2>
                <h2 class="group_name"></h2>
            </div>
            <div class="room">
                <h2> Аудитория: </h2>
                <h2 class="room_number"></h2>
            </div>
            </div>`).click(slideClicked);
    }
</script>

</html>
<?php
