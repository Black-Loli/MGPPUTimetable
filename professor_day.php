<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сегодня | Преподаватели</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="main">
    <?php include 'menu.php'; ?>

    <div class="container">

        <div class="slide" id="already_left">
            <h2 class="building"> Могли уйти </h2>

            <div class="professor"></div>

        </div>

        <div class="slide active now" id="exist_now">
            <h2 class="building"> Сейчас в корпусе </h2>

            <div class="professor"></div>

        </div>

        <div class="slide" id="will_come">
            <h2 class="building"> Ещё придут </h2>

            <div class="professor"></div>

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
<script src="js/lodash.min.js"></script>
<script>
    function fillSlide(element, professor) {
        let array = professor.split(' ');
        let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
        element.html(result);
    }

    getTimeTable(function (timeTableHandler) {
        let currentTimeProfessors = [];
        let futureProfessors = [];
        let pastProfessors = [];
        timeTableHandler.getSeparateTimeRanges().past.forEach(function (lesson, index, lessons) {
            pastProfessors = _.uniqBy(lessons, (lesson) => lesson.TeacherFIO).map(lesson => lesson.TeacherFIO);
        });
        timeTableHandler.getSeparateTimeRanges().current.forEach(function (lesson, index, lessons) {
            currentTimeProfessors = _.uniqBy(lessons, (lesson) => lesson.TeacherFIO).map(lesson => lesson.TeacherFIO);
        });
        timeTableHandler.getSeparateTimeRanges().future.forEach(function (lesson, index, lessons) {
            futureProfessors = _.uniqBy(lessons, (lesson) => lesson.TeacherFIO).map(lesson => lesson.TeacherFIO);
        });

        pastProfessors = _(pastProfessors).difference(futureProfessors, _.isEqual).difference(currentTimeProfessors, _.isEqual).value()
        futureProfessors = _(futureProfessors).difference(pastProfessors, _.isEqual).difference(currentTimeProfessors, _.isEqual).value()
        console.log(pastProfessors);

        generateProfessors($('#already_left'), pastProfessors.length);
        generateProfessors($('#exist_now'), currentTimeProfessors.length);
        generateProfessors($('#will_come'), futureProfessors.length);

        currentTimeProfessors.forEach(function (professor, index) {
            fillSlide($(`.slide#exist_now`).find(`.prof_name:eq(${index})`), professor)
        })
        futureProfessors.forEach(function (professor, index) {
            fillSlide($(`.slide#will_come`).find(`.prof_name:eq(${index})`), professor)
        })
        pastProfessors.forEach(function (professor, index) {
            fillSlide($(`.slide#already_left`).find(`.prof_name:eq(${index})`), professor)
        })

    })

    function generateProfessors(parentBlock, amount) {
        for (let i = 0; i < amount; i++) {
            let slide = $(`<h2 class="prof_name"></h2>`);
            parentBlock.find('.professor').append(slide)
        }
    }

    $('.slide').click(slideClicked);
</script>

</html>
