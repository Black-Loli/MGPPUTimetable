Storage.prototype.keyExists = function (key) {
    return localStorage.getItem(key) !== null
}

function getData() {
    return Promise.resolve($.getJSON('timetable.json', function (data) {
        try {
            // //TODO: срез для кэширования
            // _(data).filter(function (lesson) {
            //     return moment(moment().format('DD.MM.YYYY')).add(14, 'days').isBefore(lesson.dayDate) && moment(moment().format('DD.MM.YYYY')).add(14, 'days').isAfter(lesson.dayDate)
            // }).value()
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
        return timetableHandlerConstructor(await getData())
    }
}
/**
 *
 * @param callbackfn(timetableHandlerConstructor)
 * @return timetableHandlerConstructor
 */
let getTimeTable = function (callbackfn) {
    getTimeTableSync().then(data => {
        callbackfn(data)
    })
}

function timetableHandlerConstructor(allTimetable) {
    const timeFormat = 'HH:mm:ss';
    const dateFormat = 'DD.MM.YYYY';
    console.log("Время сейчас", currentTime())
    console.log("День сегодня", currentDate())

    function getGroupData() {
        return JSON.parse(localStorage.getItem('group'))
    }

    function currentTime() {
        return moment().format(timeFormat)
        // return moment('14:35:00', timeFormat).format(timeFormat)
    }

    function currentDate() {
        return moment().format(dateFormat)
        // return moment('27.05.2022', dateFormat).format(dateFormat)
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
        timetable: allTimetable,
        timeFormat,
        dateFormat,
        currentTime,
        currentDate,
        getTable: function () {
            return this.timetable;
        },
        getCurrentDayLessons: function () {
            this.timetable = this.filtrateByDepartment().getTable().filter(function (lesson) {
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
            this.timetable = this.timetable.filter(function (lesson) {
                return lesson.GroupCode === (getGroupData().name ?? group);
            })
            return this;
        },
        filtrateByDepartment: function (department) {
            this.timetable = this.timetable.filter(function (lesson) {
                return lesson.DepartmentCode === (department ?? 'ИТ');
            })
            return this;
        },
        filtrateByTeacher: function (teacher) {
            this.timetable = this.timetable.filter(function (lesson) {
                return lesson.TeacherFIO === (teacher ?? JSON.parse(localStorage.getItem('professor')).name);
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
