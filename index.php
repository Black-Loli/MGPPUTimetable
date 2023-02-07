<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Выбор </title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="parent" id="menu">
    <div class="div entrance">
        <ul>
            <li>
                <input type="radio" name="menu" id="time_table_01"/>
                <label for="time_table_01" class="time">
                    Расписание
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2" transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)" stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2" transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li id="time_today">
                        <a> На сегодня </a>
                    </li>
                    <li id="time_week">
                        <a> На неделю </a>
                    </li>
                    <li id="time_term">
                        <a> На семестр </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="menu" id="time_table_02"/>
                <label for="time_table_02" class="time">
                    Преподаватели в корпусе
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2" transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)" stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2" transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a href="professor_day.php"> Сегодня </a>
                    </li>
                    <li>
                        <a href="professor_week.php"> В течение недели </a>
                    </li>
                    <li>
                        <a href="loading.php"> На семестр </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="menu" id="time_table_03"/>
                <label for="time_table_03" class="time">
                    Группы в корпусе
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2" transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)" stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2" transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a href="groups_day.php"> Сегодня </a>
                    </li>
                    <li>
                        <a href="groups_week.php"> В течение недели </a>
                    </li>
                    <li>
                        <a href="loading.php"> На семестр </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="menu" id="time_table_04"/>
                <label for="time_table_04" class="time">
                    Кабинеты
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2" transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)" stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2" transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a href="rooms_day.php"> На сегодня </a>
                    </li>
                    <li>
                        <a href="rooms_week.php"> На неделю </a>
                    </li>
                    <li>
                        <a> На семестр </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="color">
            <h2> Включить тёмную тему </h2>
            <input type="checkbox" class="checkbox" id="themeToggleCheckbox"/>
            <label for="themeToggleCheckbox"></label>
        </div>
    </div>
</div>

<?php include 'choice.php'; ?>

</body>

<script src="js/jquery.min.js"></script>
<script src="js/lodash.js"></script>
<script src="js/moment.js"></script>
<script src="js/dark_or_light.js"></script>
<script src="js/common.js"></script>
<script>
    const menu = document.getElementById('menu');
    const profile_selection_overlay = $('#profile_selection_overlay');

    function toggleModal(closingObject, openingObject) {
        $(closingObject).css('display', 'none');
        $(openingObject).addClass('active');
    }

    document.getElementById("time_today").onclick = function () {
        toggleModal(menu, profile_selection_overlay);
    }

    document.getElementById("time_week").onclick = function () {
        toggleModal(menu, profile_selection_overlay);
    }

    document.getElementById("time_term").onclick = function () {
        toggleModal(menu, profile_selection_overlay);
    }

    $('.tab_selector').click(function (event) {
        console.log(event.target.id)
        $('.tab-content .active').removeClass('active');
        $('.tab-content').children(`#${event.target.id}_content`).addClass('active');
    })


</script>

</html>
