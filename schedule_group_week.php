<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Неделя | Расписание </title>
    <?php include 'header.php'; ?>
    <style>

    </style>
</head>
<body>
<div class="main">

    <?php include 'menu.php'; ?>

    <div class="container_week">

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->

        </div>

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->

        </div>

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->

        </div>

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->

        </div>

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->

        </div>

        <div class="slide_day">
            <h2 class="today"> Сегодня </h2>
            <h2 class="tomorrow"> Завтра </h2>
            <div class="date_week">
                <h2 class="day_week_name"></h2>
                <h2 class="date"></h2>
            </div>
<!--            <div class="lesson">-->
<!--                <div class="time_lesson">-->
<!--                    <h2 class="lesson_index"></h2>-->
<!--                    <div class="lesson_range">-->
<!--                        <h2></h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <h2 class="lesson_name"></h2>-->
<!--            </div>-->
        </div>
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
	// function fillSlideWithRooms(slide, lesson) {
	//     if (lesson.current) slide.addClass('now active')
	//     slide.find('.lesson_range').append(`<h2>${lesson.TimeStart} - ${lesson.TimeEnd}</h2>`);
	//     slide.find('.date_week').append(`<h2 class="day_week_name">${lesson.dayOfWeekName}</h2> <h2 class="date">${lesson.dayDate}</h2>`);
	//     slide.find('.lesson_index').html(`${lesson.Number}`);
	//     slide.find('.rooms').append(`<h2 class="room_number_used">${lesson.Room}</h2>`);
	// }
	function fillSlideWithLessons(slide_day, lessons, i) {



		lessons.forEach(function (lesson) {
			/*if (lesson.current) {
			slide_day.addClass('now active')
		}*/
			slide_day.find(`.day:eq(${i})`).html(`${lesson.dayDate}`);
			slide_day.find(`.date_week:eq(${i})`).html(`<h2 class="day_week_name">${lesson.dayOfWeekName}</h2> <h2 class="date">${moment(lesson.dayDate, 'DD.MM.YYYY').locale('ru').format('DD MMMM')}</h2>`);
			slide_day.find(`.lesson_range:eq(${i}) h2`).append(`${lesson.TimeStart} - ${lesson.TimeEnd}`);
			slide_day.find(`.lesson_index:eq(${i})`).append(`${lesson.Number}`);
			slide_day.find(`.lesson_name:eq(${i})`).append(`${lesson.Discipline}`);
		})
	}

	getTimeTable(function (timeTableHandler) {
		const lessonsArray = timeTableHandler.trimWeek().filtrateByGroup().getTable()
		generateSlides(lessonsArray.length);
		console.log(_(lessonsArray))
		let index = 0;
		_(lessonsArray).groupBy('dayDate').forEach(function (lessonRangeForDate, date) {
			fillSlideWithLessons($(`.slide_day:eq(${index})`), lessonRangeForDate, index);
			index++;
		})
	})

	function generateSlides(amount) {
	    for (let i = 0; i < amount; i++) {
	        let slide_day = $(` <div class="lesson">
                <div class="time_lesson">
                    <h2 class="lesson_index"></h2>
                    <div class="lesson_range">
                        <h2></h2>
                    </div>
                </div>
                <h2 class="lesson_name"></h2>
            </div> `);
	        slide_day.click(slideClicked);
	        $('.slide_day').append(slide_day)
	    }
	}
	//
	// function slideClicked(e) {
	//     $('.slide_day').removeClass('active');
	//     e.currentTarget.classList.add('active')
	// }

	const slides_day = document.querySelectorAll('.slide_day')

	for (const slide of slides_day) {
		slide.addEventListener('click', () => {
			clearActiveClasses()
			slide.classList.add('active')
		})
	}

	function clearActiveClasses() {
		slides_day.forEach((slide) => {
			slide.classList.remove('active')
		})
	}
</script>
</html>
