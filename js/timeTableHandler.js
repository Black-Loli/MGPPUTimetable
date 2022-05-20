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
    const timeFormat = 'HH:mm:ss';
    const dateFormat = 'DD.MM.YYYY';

    function getGroupData() {
        return JSON.parse(localStorage.getItem('group'))
    }

    function currentTime() {
        //moment().format('HH:mm:ss')
        return moment('11:30:00', timeFormat).format(timeFormat)
    }

    function currentDate() {
        return moment('17.05.2022', dateFormat).format(dateFormat)
    }

    function filtration(type, lesson) {
        const startTime = moment(lesson.TimeStart, timeFormat);
        const endTime = moment(lesson.TimeEnd, timeFormat);
        const currentMoment = moment(currentTime(), timeFormat);
        if (type === 1) {
            return currentMoment.isAfter(endTime)
        } else if (type === 2) {
            return currentMoment.isBetween(startTime, endTime)
        } else if (type === 3) {
            return currentMoment.isBefore(endTime)
        } else {
            return true
        }
    }

    return {
        timetable,
        timeFormat,
        dateFormat,
        currentTime,
        currentDate,
        getTable: function () {
            return timetable;
        },
        getCurrentDayLessons: function () {
            timetable = this.filtrateByDepartment().getTable().filter(function (lesson) {
                return lesson.dayDate === currentDate();
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
        getSeparateTimeRanges: function () {
            let past, current, future;


            past = this.getCurrentDayLessons().getTable().filter(function (lesson) {
                return filtration(1, lesson);
            })
            current = this.getCurrentDayLessons().getTable().filter(function (lesson) {
                return filtration(2, lesson);
            })

            future = this.getCurrentDayLessons().getTable().filter(function (lesson) {
                return filtration(3, lesson);
            })
            return {past, current, future}
        }
    }
}
