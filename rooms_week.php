<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Неделя | Кабинеты </title>
    <?php include 'header.php'; ?>
    <style>

    </style>
</head>
<body>
<div class="main">

    <?php include 'menu.php'; ?>

    <div class="container_week">

        <div class="slide_day">
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
<script src="js/jquery.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/lodash.min.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/common.js"></script>
<script src="js/timeTableHandler.js"></script>
<script>
	function fillSlideWithLessons(slide_day, lessons, i) {
		_(lessons).groupBy('Number').forEach(function (lessons, number) {
			_(lessons).uniqBy("Room").forEach(function (lesson, index) {
				slide_day.find(`.lesson:eq(${parseInt(number) - 1}) .day`).html(`${lesson.dayDate}`);
				slide_day.find(`.date_week`).html(`<h2 class="day_week_name">${lesson.dayOfWeekName}</h2> <h2 class="date">${moment(lesson.dayDate, 'DD.MM.YYYY').locale('ru').format('DD MMMM')}</h2>`);
				slide_day.find(`.lesson:eq(${parseInt(number) - 1})`).removeClass('empty');
				slide_day.find(`.lesson:eq(${parseInt(number) - 1}) .lesson_index`).html(`${lesson.Number}`);
				slide_day.find(`.lesson:eq(${parseInt(number) - 1}) .lesson_range h2`).html(`${moment(lesson.TimeStart, 'HH:mm').format('HH:mm')} - ${moment(lesson.TimeEnd, 'HH:mm').format('HH:mm')}`);
				slide_day.find(`.lesson:eq(${parseInt(number) - 1}) .prof`).append(`<h2 class="lesson_name">${lesson.Room}</h2>`);
			})
		})
	}

	getTimeTable(function (timeTableHandler) {
		const lessonsArray = timeTableHandler.trimDistant().getTable()
		console.log(lessonsArray)
		let index = 0;
		_(lessonsArray).filter(function(lesson){
			return getDaysArray().includes(lesson.dayDate);
		}).sortBy('dayDate').groupBy('dayDate').forEach(function (lessonRangeForDate, date) {
			console.log(lessonRangeForDate)
			generateLessonsInSlide(7, $(`.slide_day:eq(${index})`));
			fillSlideWithLessons($(`.slide_day:eq(${index})`), lessonRangeForDate, index);
			index++;
		})
	})

	function generateLessonsInSlide(amount, slide) {
		console.log("AMOUNT", amount)
		for (let i = 0; i < amount; i++) {
			let slide_day = $(` <div class="lesson empty">
                <div class="time_lesson">
                    <h2 class="lesson_index"></h2>
                    <div class="lesson_range">
                        <h2></h2>
                    </div>
                </div>
                <div class="prof"> </div>
            </div> `);
			slide_day.click(slideClicked);
			slide.append(slide_day)
		}
	}

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