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
<script src="js/moment.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/choice.js"></script>
<script src="js/slides.js"></script>
<script src="js/timeTableHandler.js"></script>
<script src="js/lodash.min.js"></script>
<script>
    function getLessonsForDate(lessons, date) {
        return lessons.filter(function (lesson) {
            //return lesson.dayDate === `${currentDate.getDay()}.${currentDate.getMonth()}.${currentDate.getFullYear()}`
            return lesson.dayDate === date
        })
    }

    function fillSlideWithLesson(slide, lesson) {
        if (lesson.current) {
            slide.addClass('now')
        }
        let array = lesson.TeacherFIO.split(' ');
        let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
        slide.find('.prof_name').html(`${result}`);
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

        pastProfessors = _.difference([futureProfessors, currentTimeProfessors], pastProfessors, _.isEqual)
        futureProfessors = _.difference([pastProfessors, currentTimeProfessors], futureProfessors, _.isEqual)
        /*pastProfessors = pastProfessors.filter(function (profName, index) {
            return !futureProfessors.includes(profName) && !currentTimeProfessors.includes(profName)
        })*/
        /*futureProfessors = futureProfessors.filter(function (profName, index) {
            return !pastProfessors.includes(profName) && !currentTimeProfessors.includes(profName)
        })*/
        console.log(pastProfessors);
        console.log(currentTimeProfessors);
        console.log(futureProfessors);

        generateProfessors($('#already_left'), pastProfessors.length);
        generateProfessors($('#exist_now'), currentTimeProfessors.length);
        generateProfessors($('#will_come'), futureProfessors.length);

        currentTimeProfessors.forEach(function (professor, index, professors) {
            let array = professor.split(' ');
            let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
            $(`.slide#exist_now`).find(`.prof_name:eq(${index})`).html(result);
        })

        futureProfessors.forEach(function (professor, index, professors) {
            let array = professor.split(' ');
            let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
            $(`.slide#will_come`).find(`.prof_name:eq(${index})`).html(result);
        })

        pastProfessors.forEach(function (professor, index, professors) {
            let array = professor.split(' ');
            let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
            $(`.slide#already_left`).find(`.prof_name:eq(${index})`).html(result);
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
