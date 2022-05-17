let getTimeTable = function (callbackfn) {
    $.getJSON('timetable.json', function (data) {
        callbackfn(timetableHandlerConstructor(data));
    })
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
        currentTimeLessonsMapper: function (lesson, index, lessons) {
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