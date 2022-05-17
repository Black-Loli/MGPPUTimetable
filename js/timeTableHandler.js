Storage.prototype.keyExists = function (key) {
    return localStorage.getItem(key) !== null
}
let getTimeTable = function (callbackfn) {
    if (localStorage.keyExists('timetable')) {
        callbackfn(timetableHandlerConstructor(JSON.parse(localStorage.getItem('timetable'))));
    } else {
        $.getJSON('timetable.json', function (data) {
            try {
                //TODO: срез для кэширования
                localStorage.setItem('timetable', JSON.stringify(data));
            } catch (e) {
                console.warn(`не удалось положить в память ${data.length} элементов: слишком большой объём данных`)
            }
            callbackfn(timetableHandlerConstructor(data));
        })
    }

}

function timetableHandlerConstructor(timetable) {
    function getGroupData() {
        return JSON.parse(localStorage.getItem('group'))
    }

    return {
        timeFormat: 'HH:mm:ss',
        timeTable: timetable,
        currentTime: function () {
            //moment().format('HH:mm:ss')
            moment('11:30:00', this.timeFormat).format(this.timeFormat)
        },
        currentDate: function () {
        },
        changeTime: function () {
        },
        getTimeTable: function () {
            return timetable;
        },
        getCurrentDayLessons: function () {
            return timetable.filter(function (lesson) {
                return lesson.dayDate === moment().format(`DD.MM.YYYY`);
            }).filter(function (lesson) {
                return lesson.GroupCode === getGroupData().name;
            }).sort(function (lesson1, lesson2) {
                return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
            }).map((lesson, index, lessons) => {
                if (this.currentTimeLessonsMapper(lesson, index, lessons)) {
                    lesson.current = true;
                }
                return lesson;
            });
        },
        currentTimeLessonsMapper: function (lesson) {
            const startDate = moment(lesson.TimeStart, this.timeFormat);
            const endDate = moment(lesson.TimeEnd, this.timeFormat);
            return moment(this.currentTime, this.timeFormat).isBetween(startDate, endDate)
        },
        getCurrentTimeLessons: function () {
            this.getCurrentDayLessons.filter(this.currentTimeLessonsMapper);

        },
        watchCurrentLessons: function (callBackFn) {

        }
    }
}