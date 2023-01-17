Storage.prototype.keyExists = function (key) {
    return localStorage.getItem(key) !== null
}

function getData() {
    return Promise.resolve($.getJSON('Timetable2022.json', function (data) {
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


function timetableHandlerConstructor(allTimetable) {
    const timeFormat = 'HH:mm:ss';
    const dateFormat = 'DD.MM.YYYY';
    console.log("Время сейчас", currentTime())
    console.log("День сегодня", currentDate())

    function getGroupData() {
        return JSON.parse(localStorage.getItem('group'))
    }

    function currentTime() {
        // return moment().format(timeFormat)
        return moment('14:00:20', timeFormat).format(timeFormat)
    }

    function currentDate() {
        // return moment().format(dateFormat)
        return moment('08.12.2022', dateFormat).format(dateFormat)
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
                // if (true) return lesson.dayDate === currentDate();
                // else if(false) return lesson.dayDate === currentDate();
                // if ();
                // moment().add('days', 7);    // прибавляет к текущей дате 7 дней
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
        trimWeek: function(){
          this.timetable = this.timetable.filter(function(lesson){
              return moment(lesson.dayDate)
          })
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

// function timetableHandlerConstructor_week(allTimetable) {
//     const timeFormat = 'HH:mm:ss';
//     const dateFormat = 'DD.MM.YYYY';
//     console.log("Время сейчас", currentTime())
//     console.log("День сегодня", currentDate())
//
//     function getGroupData() {
//         return JSON.parse(localStorage.getItem('group'))
//     }
//
//     function currentTime() {
//         return moment().format(timeFormat)
//         return moment('16:30:20', timeFormat).format(timeFormat)
//     }
//
//     function currentDate() {
//         return moment().format(dateFormat)
//         return moment('22.04.2022', dateFormat).format(dateFormat)
//     }
//
//     function filtration(type, lesson) {
//         for (let i = 0; i < 6; i++) {
//
//         }
//         const Date = moment(lesson.dayDate, dateFormat);
//         const DateNext = moment(lesson.dayDate, dateFormat).add('days', 1);
//         const currentMoment = moment(currentDate(), dateFormat);
//         if (type === 1) {
//             return currentMoment.isBetween(Date)
//         } else if (type === 2) {
//             return currentMoment.isAfter(DateNext)
//         } else {
//             return true
//         }
//     }
//
//     return {
//         timetable: allTimetable,
//         dateFormat,
//         currentDate,
//         getTable: function () {
//             return this.timetable;
//         },
//         getCurrentWeekLessons: function () {
//             this.timetable = this.filtrateByDepartment().getTable().filter(function (lessons) {
//                 return lessons.dayDate === currentDate();
//             }).sort(function (day1, day2) {
//                 return day1.dayDate.localeCompare(day2.dayDate);
//             }).map((lesson, index, lessons) => {
//                 if (this.currentTimeLessonsMapper(lesson, index, lessons)) {
//                     lesson.current = true;
//                 }
//                 return lesson;
//             });
//             return this;
//         },
//         filtrateByGroup: function (group) {
//             this.timetable = this.timetable.filter(function (lessons) {
//                 return lessons.GroupCode === (getGroupData().name ?? group);
//             })
//             return this;
//         },
//         filtrateByDepartment: function (department) {
//             this.timetable = this.timetable.filter(function (lessons) {
//                 return lessons.DepartmentCode === (department ?? 'ИТ');
//             })
//             return this;
//         },
//         filtrateByTeacher: function (teacher) {
//             this.timetable = this.timetable.filter(function (lessons) {
//                 return lessons.TeacherFIO === (teacher ?? JSON.parse(localStorage.getItem('professor')).name);
//             })
//             return this;
//         },
//         currentTimeLessonsMapper: function (lessons) {
//             const Date = moment(lessons.dayDate, this.dateFormat);
//             const DateNext = moment(lessons.dayDate, dateFormat).add('days', 1);
//             return moment(this.currentDate(), this.dateFormat).isBetween(Date)
//         },
//         getCurrentTimeLessons: function () {
//             this.getCurrentWeekLessons.filter(this.currentTimeLessonsMapper);
//         },
//         getSeparateTimeRanges: function () {
//             let current, future;
//             current = this.getCurrentWeekLessons().getTable().filter(function (lessons) {
//                 return filtration(1, lessons);
//             })
//
//             future = this.getCurrentWeekLessons().getTable().filter(function (lessons) {
//                 return filtration(2, lessons);
//             })
//             return {current, future}
//         }
//     }
// }
