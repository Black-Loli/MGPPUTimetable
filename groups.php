<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сегодня | Группы</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.php'; ?>

    <div class="container">

        <div class="slide" id="already_left">
            <h2 class="building"> Могли уйти </h2>

            <div class="groups"></div>

        </div>

        <div class="slide active now" id="exist_now">
            <h2 class="building"> Сейчас в корпусе </h2>

            <div class="groups"></div>

        </div>

        <div class="slide" id="will_come">
            <h2 class="building"> Ещё придут </h2>

            <div class="groups"></div>

        </div>

    </div>

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
    function fillSlideWithLesson(slide, lesson) {
        if (lesson.current) {
            slide.addClass('now')
        }
        slide.find('.groups_name').html(`${lesson.GroupCode}`);
    }

    getTimeTable(function (timeTableHandler) {
        let currentTimeGroups = [];
        let futureGroups = [];
        let pastGroups = [];

        timeTableHandler.getSeparateTimeRanges().past.forEach(function (lesson, index, lessons) {
            pastGroups = _.uniqBy(lessons, (lesson) => lesson.GroupCode).map((lesson) => lesson.GroupCode)
        })
        timeTableHandler.getSeparateTimeRanges().current.forEach(function (lesson, index, lessons) {
            currentTimeGroups = _.uniqBy(lessons, (lesson) => lesson.GroupCode).map((lesson) => lesson.GroupCode)
        })
        timeTableHandler.getSeparateTimeRanges().future.forEach(function (lesson, index, lessons) {
            futureGroups = _.uniqBy(lessons, (lesson) => lesson.GroupCode).map((lesson) => lesson.GroupCode)
        })

        pastGroups = _(pastGroups).difference(futureGroups, _.isEqual).difference(currentTimeGroups, _.isEqual).value();
        futureGroups = _(futureGroups).difference(pastGroups, _.isEqual).difference(currentTimeGroups, _.isEqual).value();

        generateGroups($('#already_left'), pastGroups.length);
        generateGroups($('#exist_now'), currentTimeGroups.length);
        generateGroups($('#will_come'), futureGroups.length);
        currentTimeGroups.forEach(function (group, index) {
            $(`.slide#exist_now`).find(`.groups_name:eq(${index})`).html(group);
        })

        pastGroups.forEach(function (group, index) {
            $(`.slide#already_left`).find(`.groups_name:eq(${index})`).html(group);
        })

        futureGroups.forEach(function (group, index) {
            $(`.slide#will_come`).find(`.groups_name:eq(${index})`).html(group);
        })
    })

    function generateGroups(parentBlock, amount) {
        for (let i = 0; i < amount; i++) {
            let groups = $(`<h2 class="groups_name"></h2>`);
            parentBlock.find('.groups').append(groups)
        }
    }

    $('.slide').click(slideClicked);
</script>

</html>
