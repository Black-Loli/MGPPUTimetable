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
<script src="js/choice.js"></script>
<script>

    function getLessonsForDate(lessons, date) {
        return lessons.filter(function (lesson) {
            //return lesson.dayDate === `${currentDate.getDay()}.${currentDate.getMonth()}.${currentDate.getFullYear()}`
            return lesson.dayDate === date
        })
    }

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
        var startDate = moment(lesson.TimeStart, "HH:mm:ss");
        var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
        if (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isBetween(startDate, endDate)) {
            slide.addClass('now')
        }
        slide.find('.groups_name').html(`${lesson.GroupCode}`);
    }

    $.getJSON('timetable.json', function (receivedLessons) {
        // const currentDayLessons = getLessonsForDate(receivedLessons, '12.05.2022').filter(function (lesson) {
        const currentDayLessons = getLessonsForDate(receivedLessons, moment().format(`DD.MM.YYYY`)).filter(function (lesson) {
            return lesson.DepartmentCode === 'ИТ';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        console.log('currentDayLessons', currentDayLessons)
        let currentTimeGroups = [];
        let futureGroups = [];
        let pastGroups = [];
        currentDayLessons.filter(function (lesson, index, lessons) {
            var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isAfter(endDate));
        }).forEach(function (lesson, index, lessons) {
            if (!pastGroups.includes(lesson.GroupCode)) {
                pastGroups.push(lesson.GroupCode);
            }
        });
        currentDayLessons.filter(function (lesson, index, lessons) {
            var startDate = moment(lesson.TimeStart, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isBefore(startDate));
        }).forEach(function (lesson, index, lessons) {
            if (!futureGroups.includes(lesson.GroupCode)) {
                futureGroups.push(lesson.GroupCode);
            }
        });
        currentDayLessons.filter(function (lesson, index, lessons) {
            var lessonStartTime = moment(lesson.TimeStart, "HH:mm:ss");
            var lessonEndTime = moment(lesson.TimeEnd, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isBetween(lessonStartTime, lessonEndTime));
        }).forEach(function (lesson, index, lessons) {
            if (!currentTimeGroups.includes(lesson.GroupCode)) {
                currentTimeGroups.push(lesson.GroupCode);
            }
        });
        pastGroups = pastGroups.filter(function (groupName, index) {
            return !futureGroups.includes(groupName) && !currentTimeGroups.includes(groupName)
        })
        futureGroups = futureGroups.filter(function (groupName, index) {
            return !pastGroups.includes(groupName) && !currentTimeGroups.includes(groupName)
        })
        console.log('pastGroups', pastGroups)
        console.log('currentGroups', currentTimeGroups)
        console.log('futureGroups', futureGroups)

        generateGroups($('#already_left'), pastGroups.length);
        generateGroups($('#exist_now'), currentTimeGroups.length);
        generateGroups($('#will_come'), futureGroups.length);
        currentTimeGroups.forEach(function (group, index, groups) {
            currentDayLessons.length;
            $(`.slide#exist_now`).find(`.groups_name:eq(${index})`).html(group);
            console.log(group);
        })

        pastGroups.forEach(function (group, index, groups) {
            currentDayLessons.length;
            $(`.slide#already_left`).find(`.groups_name:eq(${index})`).html(group);
            console.log(group);
        })

        futureGroups.forEach(function (group, index, groups) {
            currentDayLessons.length;
            $(`.slide#will_come`).find(`.groups_name:eq(${index})`).html(group);
            console.log(group);
        })
    })

    function generateGroups(parentBlock, amount) {
        for (let i = 0; i < amount; i++) {
            let groups = $(`<h2 class="groups_name"></h2>`);
            parentBlock.find('.groups').append(groups)
        }
    }
</script>

</html>
