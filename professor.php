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
        let array = lesson.TeacherFIO.split(' ');
        let result = `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
        slide.find('.prof_name').html(`${result}`);
    }

    $.getJSON('timetable.json', function (receivedLessons) {
        // const currentDayLessons = getLessonsForDate(receivedLessons, '13.05.2022').filter(function (lesson) {
        const currentDayLessons = getLessonsForDate(receivedLessons, moment().format(`DD.MM.YYYY`)).filter(function (lesson) {
            return lesson.DepartmentCode === 'ИТ';
        }).sort(function (lesson1, lesson2) {
            return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
        });
        let currentTimeProfessors = [];
        let futureProfessors = [];
        let pastProfessors = [];
        currentDayLessons.filter(function (lesson, index, lessons) {
            var endDate = moment(lesson.TimeEnd, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isAfter(endDate));
        }).forEach(function (lesson, index, lessons) {
            if (!pastProfessors.includes(lesson.TeacherFIO)) {
                pastProfessors.push(lesson.TeacherFIO);
            }
        });
        currentDayLessons.filter(function (lesson, index, lessons) {
            var startDate = moment(lesson.TimeStart, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isBefore(startDate));
        }).forEach(function (lesson, index, lessons) {
            if (!futureProfessors.includes(lesson.TeacherFIO)) {
                futureProfessors.push(lesson.TeacherFIO);
            }
        });

        currentDayLessons.filter(function (lesson, index, lessons) {
            const startProfessorTime = moment(lesson.TimeStart, "HH:mm:ss");
            const endProfessorTime = moment(lesson.TimeEnd, "HH:mm:ss");
            return (moment(moment().format('HH:mm:ss'), 'HH:mm:ss').isBetween(startProfessorTime, endProfessorTime));
        }).forEach(function (lesson, index, lessons) {
            if (!currentTimeProfessors.includes(lesson.TeacherFIO)) {
                currentTimeProfessors.push(lesson.TeacherFIO);
            }
        });

        pastProfessors = pastProfessors.filter(function (profName, index) {
            return !futureProfessors.includes(profName) && !currentTimeProfessors.includes(profName)
        })

        futureProfessors = futureProfessors.filter(function (profName, index) {
            return !pastProfessors.includes(profName) && !currentTimeProfessors.includes(profName)
        })

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
        console.log(currentTimeProfessors);
        console.log(pastProfessors);
        console.log(futureProfessors);
    })

    function generateProfessors(parentBlock, amount) {
        for (let i = 0; i < amount; i++) {
            let slide = $(`<h2 class="prof_name"></h2>`);
            parentBlock.find('.professor').append(slide)
        }
    }
</script>

</html>
