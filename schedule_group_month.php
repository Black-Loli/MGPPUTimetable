<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Месяц | Расписание для группы </title>
    <?php include 'header.php'; ?>
    <style>

    </style>
</head>
<body>
<div class="main">

    <?php include 'menu.php'; ?>

    <div class="technical_values">

    </div>
    <!--    <div class="container_month container_month__calendar">-->
    <!--    </div>-->

    <div class="container_month__list">
    </div>

    <?php include 'choice.php'; ?>

</div>
</body>
<script src="js/jquery.js"></script>
<script src="js/moment.js"></script>
<script src="js/lodash.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/common.js"></script>
<script src="js/timeTableHandler.js"></script>
<script>
    function first_day() {
        let day = moment().format('1 MM YYYY')
        return moment(day, 'DD.MM.YYYY').format('dddd')
    }

    $('.container_month__calendar').addClass(first_day())
    $('.technical_values').append(`<h1 class="container_month_name"> ${moment(currentDateObject, 'DD.MM.YYYY').locale('ru').format('MMMM')} </h1>`);


    // $('.slide_day').click(slide_dayClicked);

    function convertInitials(professor) {
        let array = professor.split(' ');
        return `${array[0]} ${array[1][0]}. ${array[2][0]}.`;
    }

    /*function fillSlideWithLessons(slide_day, lessons, i) {
        lessons.forEach(function (lesson) {
            const index = parseInt(lesson.Number) - 1;
            // slide_day.find(`.lesson:eq(${index}) .day`).html(`${lesson.dayDate}`);
            // slide_day.find(`.date_week`).html(`<h2 class="day_week_name">${lesson.dayOfWeekName}</h2> <h2 class="date">${moment(lesson.dayDate, 'DD.MM.YYYY').locale('ru').format('DD MMMM')}</h2>`);
            slide_day.find(`.lesson:eq(${index})`).removeClass('empty');
            slide_day.find(`.lesson:eq(${index}) .lesson_range h2`).html(`${moment(lesson.TimeStart, 'HH:mm').format('HH:mm')} - ${moment(lesson.TimeEnd, 'HH:mm').format('HH:mm')}`);
            slide_day.find(`.lesson:eq(${index}) .lesson_index`).append(`${lesson.Number}`);
            slide_day.find(`.lesson:eq(${index}) .lesson_name`).append(`${lesson.Discipline}`);
            slide_day.find(`.lesson:eq(${index}) .prof_name`).append(`${convertInitials(lesson.TeacherFIO)}`);
            slide_day.find(`.lesson:eq(${index}) .room_number`).append(`${lesson.Room}`);
        })
    }*/

    /*getTimeTable(function (timeTableHandler) {
        const lessonsArray = timeTableHandler.filtrateByGroup().getTable()
        console.log(_(lessonsArray))
        let index = 0;

        getDaysArray().forEach(function (date, index) {
            $(`.slide_day:eq(${index})`).get(0).dataset.date = date
            $(`.slide_day:eq(${index})`).find('.day_week_name').html(moment(date, 'DD.MM.YYYY').locale('ru').format('dddd'))
            $(`.slide_day:eq(${index})`).find('.date').html(moment(date, 'DD.MM.YYYY').locale('ru').format('DD MMMM'))
        })
        _(lessonsArray).filter(function (lesson) {
            return getDaysArray().includes(lesson.dayDate);
        }).groupBy('dayDate').forEach(function (lessonRangeForDate, date) {
            generateLessonsInSlide(7, $(`.slide_day[data-date="${date}"]`));
            fillSlideWithLessons($(`.slide_day[data-date="${date}"]`), lessonRangeForDate, index);
            index++;
        })
        $(`.slide_day[data-date="${timeTableHandler.currentDate()}"]`).addClass('now active')
    })*/

    // generateLessonsInSlide(getDaysInMonth(), $(`.container_month__calendar`));
    generateDays(getDaysCountInMonth(), $(`.container_month__list`));

    function generateLessons(date, lessons) {
        const rootEmptyTag = $('<div class="lesson-list"></div>')
        if (lessons.length === 0) {
            rootEmptyTag.append(`<div class="lesson-list__empty">
                <h2 class=""> Пёся отправляет на отдых </h2>
                <svg viewBox="0 0 235.51 235.511">
                    <path d="M175.585,148.621c-8.876-4.087-22.064-4.953-31.57-4.953c-3.058,0-5.61,0.076-7.357,0.169l0.084-8.279
			c3.991-1.403,5.635-4.601,6.271-6.616c0.697,0.16,1.419,0.232,2.137,0.232c7.554,0,13.465-8.352,13.5-8.412
			c11.081-12.984,3.154-36.167,2.785-37.225l-0.965-1.361l-0.862-0.16c-1.454-0.298-3.157-0.449-5.073-0.449
			c-12.627,0-31.264,6.578-36.994,8.72c-4.42-3.797-13.52-5.791-14.619-6.045l-1.545,0.104l-0.591,0.557
			c-0.938,0.904-2.893,2.777,3.064,14.607c-0.684,0.521-1.311,1.092-1.886,1.675c-5.322-1.579-14.857-2.158-15.943-2.238
			l-2.717-0.164l0.072,2.725c0.292,11.499,20.638,26.114,23.417,27.938c1.603,16.246-32.705,32.944-33.035,33.121
			c-5.094,2.184-13.251,3.358-23.566,3.358c-7.78,0-14.186-0.706-14.232-0.706l-1.797-0.176l-0.755,1.623
			c-0.675,1.475-0.675,3.098,0,4.692c2.395,5.703,14.17,11.101,21.235,13.906c-3.619,6.42-3.194,16.936-2.967,18.799
			c-7.927,7.927-11.491,15.088-10.606,21.283c0.89,6.132,5.769,8.724,5.983,8.832l2.464,1.331l1.012-2.605
			c2.561-6.5,19.745-23.383,25.396-28.949l0.867-1.227c3.595,0.661,7.079,1.074,10.367,1.227c1.146,0.076,2.263,0.092,3.371,0.092
			c32.248,0,41.144-24.686,43.176-32.748c0.344,0.044,0.688,0.06,1.05,0.06c3.054,0,5.811-1.779,7.302-2.945
			c1.791,1.259,3.862,1.888,6.115,1.888c5.959,0,11.958-4.433,16.39-7.69c1.122-0.817,2.132-1.555,2.974-2.107
			c9.354-5.919,9.923-7.867,9.706-9.65C177.105,149.804,176.383,148.85,175.585,148.621z M164.854,156.288
			c-0.934,0.597-2.04,1.395-3.314,2.332c-3.831,2.821-9.076,6.685-13.377,6.685c-1.694,0-3.117-0.63-4.376-1.948l-1.839-1.932
			l-1.796,1.977c-0.128,0.132-2.93,2.977-5.414,2.977c-0.564,0-1.086-0.164-1.57-0.477l-3.311-2.132l-0.513,3.911
			c-0.156,1.271-4.332,31.37-38.778,31.37c-1.02,0-2.09-0.032-3.158-0.076c-3.291-0.16-6.835-0.613-10.588-1.318l-1.499,0.093
			l-0.583,0.536c-0.848,0.81-20.756,19.456-27.272,29.775c-0.587-0.766-1.238-1.903-1.477-3.435
			c-0.667-4.601,2.733-10.703,9.836-17.681l0.739-1.178l-0.052-0.705c-0.309-4.096-0.23-15.533,3.791-19.076l3.178-2.805
			l-4.003-1.427c-4.765-1.703-17.398-6.9-20.836-11.277c2.442,0.185,6.688,0.453,11.527,0.453c11.152,0,19.774-1.274,25.64-3.787
			c1.583-0.766,39.094-18.814,35.812-39.236l-0.487-1.198l-0.551-0.381c-5.042-3.435-18.511-14.018-21.604-22.115
			c4.831,0.435,10.576,1.229,12.758,2.225l1.986,0.869l1.152-1.821c0.175-0.24,1.196-1.609,3.489-2.973l2.024-1.227l-1.106-2.09
			c-1.733-3.288-3.298-6.789-4.091-9.207c3.879,1.13,8.323,2.921,9.722,4.757l1.146,1.477l1.755-0.691
			c0.252-0.099,2.02-0.786,4.703-1.709c0.613,1.771,2.284,3.068,4.264,3.068c2.492,0,4.524-2.032,4.524-4.528
			c0-0.471-0.085-0.89-0.205-1.318c7.458-2.238,16.599-4.477,23.42-4.477c0.949,0,1.831,0.056,2.637,0.141
			c1.15,3.987,5.534,21.604-2.461,30.995c-0.044,0.054-4.853,6.494-9.59,6.494c-0.949,0-1.831-0.276-2.729-0.842l-3.879-2.5
			l0.031,4.645c0.013,0.484-0.1,4.953-4.7,5.643l-2.108,0.324l-0.168,17.736l2.757-0.212c0.722-0.064,4.541-0.325,9.662-0.325
			c7.803,0,18.707,0.613,26.83,3.451C169.823,152.945,167.996,154.296,164.854,156.288z"/>
                    <path d="M202.435,32.18c0.842-7.684-1.35-15.252-6.195-21.315c-4.845-6.053-11.754-9.853-19.456-10.698
			C175.718,0.04,174.66,0,173.578,0c-4.171,0-8.219,0.864-12.014,2.607c-4.437,2.032-8.203,5.149-11.068,8.951
			c-3.282-1.242-6.785-1.932-10.295-1.932c-4.164,0-8.203,0.886-12.022,2.637c-2.076,0.936-4.044,2.128-5.849,3.559
			c-12.593,9.858-14.815,28.12-4.945,40.72c11.876,15.156,31.364,17.41,41.912,17.41c2.705,0,4.745-0.143,5.851-0.243l-1.895,3.853
			l8.455,0.638l-1.362-5.777c3.879,0.487,13.413,2.344,17.248,8.774c2.696,4.5,2.168,10.672-1.503,18.33
			c-1.455,3.01-2.773,5.707-3.987,8.133c-11.068,22.332-11.47,24.532,7.337,45.754c0.485,0.514,1.143,0.834,1.864,0.834
			c0.368,0,0.713-0.093,1.033-0.221c0.209-0.116,0.438-0.232,0.622-0.425c1.033-0.894,1.134-2.488,0.216-3.519
			c-17.02-19.18-16.823-19.58-6.597-40.2c1.207-2.451,2.549-5.16,4.004-8.189c4.477-9.271,4.905-17.025,1.303-23.062
			c-3.419-5.717-9.742-8.56-14.932-9.979C185.921,63.119,200.303,51.411,202.435,32.18z M121.332,53.447
			c-3.948-5.047-5.707-11.319-4.921-17.695c0.765-6.374,3.971-12.066,9.002-16.006c1.499-1.17,3.126-2.166,4.85-2.959
			c3.165-1.447,6.508-2.178,9.95-2.178c2.532,0,5.045,0.44,7.605,1.242c-1.578,3.094-2.652,6.436-3.049,9.97
			c-2.232,20.33,12.018,36.383,19.059,42.954c-0.981,0.088-2.393,0.154-4.111,0.154C149.902,68.902,131.857,66.894,121.332,53.447z
			 M169.43,67.074c-0.132-0.1-0.292-0.242-0.452-0.376l-0.137-0.597l-0.168,0.329c-5.086-4.544-21.1-20.494-18.932-40.068
			c0.914-8.352,6.244-15.731,13.902-19.215c3.134-1.437,6.476-2.154,9.934-2.154c0.891,0,1.779,0.05,2.67,0.168
			c6.375,0.705,12.09,3.837,16.089,8.848c4.012,5.014,5.835,11.281,5.114,17.641C195.074,53.203,174.131,64.752,169.43,67.074z"/>
                    <path d="M153.89,100.492c0.509,0,0.981-0.116,1.426-0.331c1.311-0.667,2.324-3.2,2.762-5.438c0.252-1.365,0.513-3.875-0.661-5.244
			c-0.381-0.449-0.994-0.659-1.823-0.659c-2.509,0-7.574,2.126-8.833,4.657c-0.461,0.907-0.396,1.859,0.177,2.661
			C147.442,96.812,150.856,100.492,153.89,100.492z"/>
                    <path d="M124.336,97.375c2.318,0,4.202,1.883,4.202,4.202c0,2.32-1.884,4.202-4.202,4.202c-2.318,0-4.197-1.882-4.197-4.202
			C120.139,99.258,122.019,97.375,124.336,97.375z"/>
                </svg>
            </div>`)
        }
        console.log(lessons)
        lessons.sort(function (lesson1, lesson2) {
            return (lesson1.Number > lesson2.Number) ? 1 : -1
        }).forEach(function (lesson) {
            $(`<div class="lesson" data-index="${lesson.Number.replace(' пара', '')}">
                <div class="time_lesson">
                    <h2 class="lesson_index">${lesson.Number}</h2>
                    <div class="lesson_range">
                        <h2>${moment(lesson.TimeStart, 'HH:mm').format('HH:mm')} - ${moment(lesson.TimeEnd, 'HH:mm').format('HH:mm')}</h2>
                    </div>
                    <h2 class="lesson_name">${lesson.Discipline}</h2>
                </div>
                <div class="professor">
                    <h2> Преподаватель: </h2>
                    <h2 class="prof_name">${lesson.TeacherFIO}</h2>
                </div>
                <div class="room">
                    <h2> Аудитория: </h2>
                    <h2 class="room_number">${lesson.Room}</h2>
                </div>
            </div>`).appendTo(rootEmptyTag)
        })

        return rootEmptyTag;
    }

    function generateDays(amount, slide) {
        console.log(
            getDatesInMonth(
                currentDateObject().year(),
                currentDateObject().month() + 1
            )
        )
        console.log("AMOUNT", amount)
        slide.find('.empty-holder').remove()
        getTimeTable(function (lessons) {

            for (let i = 0; i < amount; i++) {
                let dateObject = getDatesInMonth(currentDateObject().year(), currentDateObject().month())[i]
                let dateSignature = dateObject.locale('ru').format('D.MM dddd')
                // let DateSignature = getDatesInMonth(currentDateObject().year(), currentDateObject().month())[i].format('dddd')
                $(` <div class="slide_month_day" data-date="${dateObject.format('DD.MM.YYYY')}">
                        <h1 class="date">${dateSignature}</h1>

                </div>`)
                    .appendTo(slide)
                    .append(generateLessons(
                        dateObject.format('DD.MM.YYYY'),
                        lessons.filtrateByGroup().getTable().filter(function (lesson) {
                            return lesson.dayDate === dateObject.format('DD.MM.YYYY');
                        })
                    ));
                // slide.append(slide_day)
            }
        })
    }
</script>
</html>
