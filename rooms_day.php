<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сегодня | Аудитории</title>
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
<script src="js/common.js"></script>
<script src="js/timeTableHandler.js"></script>
<script>
    function fillSlideWithRooms(slide, lesson) {
        if (lesson.current) slide.addClass('now active')
        slide.find('.lesson_range h2').html(`${lesson.lessonTimeRange}`);
        slide.find('.lesson_index').html(`${lesson.Number}`);
        slide.find('.rooms').append(`<h2 class="room_number_used">${lesson.Room}</h2>`);
    }

    getTimeTable(function (timeTableHandler) {
        let currentDayLessons = timeTableHandler.getCurrentDayLessons().getTable();
        generateSlides(5);
        for (let i = 0; i < 5; i++) {
            let slide = $(`.slide:eq(${i})`);
            currentDayLessons.filter(function (lesson) {
                return lesson.Number === `${i + 1} пара`
            }).forEach(function (lesson) {
                fillSlideWithRooms(slide, lesson);
            })
        }
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
