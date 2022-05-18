Storage.prototype.keyExists = function (key) {
    return localStorage.getItem(key) !== null
}

function getData() {
    return Promise.resolve($.getJSON('timetable.json', function (data) {
        try {
            //TODO: срез для кэширования
            //localStorage.setItem('timetable', JSON.stringify(data));
        } catch (e) {
            console.warn(`не удалось положить в память ${data.length} элементов: слишком большой объём данных`)
        }
    }))
}

let getTimeTableSync = async function () {
    if (localStorage.keyExists('timetable')) {
        return (timetableHandlerConstructor(JSON.parse(localStorage.getItem('timetable'))));
    } else {
        return await getData()
    }
}
let getTimeTable = async function (callbackfn) {
    getTimeTableSync().then(data => {
        callbackfn(timetableHandlerConstructor(data))
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
            return moment('11:30:00', this.timeFormat).format(this.timeFormat)
        },
        currentDate: function () {
            return moment('17.05.2022', 'DD.MM.YYYY').format(`DD.MM.YYYY`)
        },
        getTable: function () {
            return timetable;
        },
        getCurrentDayLessons: function () {
            timetable = timetable.filter(function (lesson) {
                return lesson.dayDate === moment('17.05.2022', 'DD.MM.YYYY').format(`DD.MM.YYYY`);
            }).sort(function (lesson1, lesson2) {
                return lesson1.TimeStart.localeCompare(lesson2.TimeStart);
            }).map((lesson, index, lessons) => {
                if (this.currentTimeLessonsMapper(lesson, index, lessons)) {
                    lesson.current = true;
                }
                return lesson;
            });
            return this;
        },
        filtrateByGroup: function (group) {
            timetable = timetable.filter(function (lesson) {
                return lesson.GroupCode === (getGroupData().name ?? group);
            })
            return this;
        },
        filtrateByDepartment: function (department) {
            timetable = timetable.filter(function (lesson) {
                return lesson.DepartmentCode === (department ?? 'ИТ');
            })
            return this;
        },
        currentTimeLessonsMapper: function (lesson) {
            const startDate = moment(lesson.TimeStart, this.timeFormat);
            const endDate = moment(lesson.TimeEnd, this.timeFormat);
            return moment(this.currentTime(), this.timeFormat).isBetween(startDate, endDate)
        },
        getCurrentTimeLessons: function () {
            this.getCurrentDayLessons.filter(this.currentTimeLessonsMapper);
        },
        watchCurrentLessons: function (callBackFn) {

        }
    }
}
