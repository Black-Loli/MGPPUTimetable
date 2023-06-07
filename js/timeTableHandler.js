const timeFormat = 'HH:mm:ss';
const dateFormat = 'DD.MM.YYYY';
Storage.prototype.keyExists = function (key) {
    return localStorage.getItem(key) !== null
}

function getDaysArray(initialDate = activeDateObject()) {
    let days = []
    for (let i = 1; i < 7; i++) {
        days.push(initialDate.day(i).format('DD.MM.YYYY'))
    }
    return days;
}

function getDaysArrayMonth(initialDate = activeDateObject()) {
    let days = []
    for (let i = 1; i < getDaysCountInMonth; i++) {
        days.push(initialDate.day(i).format('DD.MM.YYYY'))
    }
    return days;
}

const getDatesInMonth = (year = moment(activeDateObject(), "YYYY"), month) => {
    var monthIndex = month; // 0..11 instead of 1..12
    // var names = ['Воскресенье', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
    var date = new Date(year, monthIndex, 1);
    var result = [];
    while (date.getMonth() === monthIndex) {
        result.push(moment(date));
        //result.push(date.getDate() );
        date.setDate(date.getDate() + 1);
    }
    return result;
};

function getDaysCountInMonth() {
    return moment(activeDate(), "YYYY-MM").daysInMonth()
}

function currentTimeObject() {
    // return moment()
    return moment('14:00:20', timeFormat)
}

function currentTime() {
    return currentTimeObject().format(timeFormat)
}

function incrementMonth() {
    localStorage.setItem('date', activeDateObject().add(1, 'months').format(dateFormat))
}

function decrementMonth() {
    localStorage.setItem('date', activeDateObject().subtract(1, 'months').format(dateFormat))
}

function returnNow() {
    localStorage.removeItem('date')
}

function decrementDay() {
    localStorage.setItem('date', activeDateObject().subtract(1, 'day').format(dateFormat))
}

function incrementDay() {
    localStorage.setItem('date', activeDateObject().add(1, 'day').format(dateFormat))
}

function decrementWeek() {
    localStorage.setItem('date', activeDateObject().subtract(1, 'week').format(dateFormat))
}

function incrementWeek() {
    localStorage.setItem('date', activeDateObject().add(1, 'week').format(dateFormat))
}

function activeDateObject() {
    //Активная дата - та которую хотим наблюдать
    return localStorage.keyExists('date') ?
        moment(localStorage.getItem('date'), dateFormat) :
        moment()

}

function activeDate() {
    return activeDateObject().format(dateFormat)
}

function currentDateObject() {
    //Сегодняшняя дата
    return moment()
    // return moment('5.04.2023', dateFormat)
}

function currentDate() {
    return currentDateObject().format(dateFormat)

}

function getData() {
    return Promise.resolve($.getJSON('IT_timetable_spring.json', function (data) {
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
// let getTimeTableSync_Week = async function () {
//     if (localStorage.keyExists('timetable')) {
//         return (timetableHandlerConstructor_week(JSON.parse(localStorage.getItem('timetable'))));
//     } else {
//         return timetableHandlerConstructor_week(await getData())
//     }
// }
/**
 *
 * @param callbackfn(timetableHandlerConstructor)
 * @return timetableHandlerConstructor
 */
let getTimeTable = function (callbackfn) {
    getTimeTableSync().then(data => {
        callbackfn(data)
    })
    // getTimeTableSync_Week().then(data => {
    //     callbackfn(data)
    // })
}

function getGroupData() {
    return JSON.parse(localStorage.getItem('group'))
}
function getTeacherData() {
    return JSON.parse(localStorage.getItem('professor'))
}

function timetableHandlerConstructor(allTimetable) {
    console.log("Время сейчас", currentTime())
    console.log("День сегодня", activeDate())

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
        timeFormat: timeFormat,
        dateFormat: dateFormat,
        currentTime,
        currentDate: activeDate,
        getTable: function () {
            return this.timetable.map(function (lesson, index) {
                return lesson;
            });
        },
        getCurrentDayLessons: function () {
            this.timetable = this.filtrateByDepartment().getTable().filter(function (lesson) {
                return lesson.dayDate === activeDate();
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
        // trimWeek: function () {
        // 	this.timetable = this.timetable.filter(function (lesson) {
        // 		return moment(lesson.dayDate, dateFormat).isBetween(
        // 			moment(currentDate(), dateFormat),
        // 			moment(currentDate(), dateFormat).add(7, 'days'),
        // 			undefined,
        // 			'[]'
        // 		)
        // 	})
        // 	return this;
        // },
        trimDistant: function () {
            this.timetable = this.timetable.filter(function (lesson) {
                return lesson.Building !== "Дистанционно";
            })
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
                return lesson.TeacherFIO === (teacher ?? getTeacherData().name);
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
        trimSession: function () {
            this.timetable = this.timetable.filter(function (lesson) {
                return !lesson.isSession;
            })
            return this;
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
