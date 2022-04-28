<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>...</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bellota+Text:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">
    <input type="checkbox" id="ham-menu">
    <label for="ham-menu" class="menu" id="button_menu">
        <div class="hide-des">
            <span class="menu-line"></span>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
            <span class="menu-line"></span>
        </div>
    </label>

    <div id="overlay_menu"></div>
    <div class="ham-menu" id="menu">
        <ul class="centre-text bold-text">
            <li>
                <input type="radio" name="left_submenu" id="time_table_01"/>
                <label for="time_table_01" class="time">
                    Расписание
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2"
                              transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                              stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2"
                              transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a id="time_today"> На сегодня</a>
                    </li>
                    <li>
                        <a id="time_week"> На неделю</a>
                    </li>
                    <li>
                        <a> Выбрать дату </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="left_submenu" id="time_table_02"/>
                <label for="time_table_02" class="time">
                    Преподаватели в корпусе
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2"
                              transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                              stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2"
                              transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a> На сегодня</a>
                    </li>
                    <li>
                        <a> На неделю</a>
                    </li>
                    <li>
                        <a> Выбрать дату </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="left_submenu" id="time_table_03"/>
                <label for="time_table_03" class="time">
                    Группы в корпусе
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2"
                              transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                              stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2"
                              transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a> На сегодня</a>
                    </li>
                    <li>
                        <a> На неделю</a>
                    </li>
                    <li>
                        <a> Выбрать дату </a>
                    </li>
                </ul>
            </li>

            <li>
                <input type="radio" name="left_submenu" id="time_table_04"/>
                <label for="time_table_04" class="time">
                    Кабинеты
                    <svg class="click" width="28" height="17" viewBox="0 0 28 17" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <line y1="-2" x2="19.3367" y2="-2"
                              transform="matrix(0.706464 -0.707749 0.706464 0.707749 14.1777 16.6855)"
                              stroke-width="4"/>
                        <line y1="-2" x2="19.3375" y2="-2"
                              transform="matrix(0.689819 0.723982 -0.722728 0.691132 0.838379 3)" stroke-width="4"/>
                    </svg>
                </label>

                <ul class="sub-items">
                    <li>
                        <a> На сегодня</a>
                    </li>
                    <li>
                        <a> На неделю</a>
                    </li>
                    <li>
                        <a> Выбрать дату </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="color">
            <h2> Включить тёмную тему </h2>
            <input type="checkbox" class="checkbox" id="checkbox"/>
            <label for="checkbox"></label>
        </div>
    </div>
    <h1>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam dolorum eos fuga hic labore molestias nam
        nulla omnis placeat quia quo quod quos reiciendis temporibus ullam, vero voluptatem? Est exercitationem id nobis
        recusandae tenetur. Enim illo, ipsam ipsum nam porro quia! Amet atque aut commodi consequuntur distinctio eius
        enim error et, ex facilis fugiat fugit inventore laudantium, maiores maxime nesciunt nihil nisi nulla odio odit
        possimus quaerat repudiandae, similique sint sit suscipit veniam voluptate! At delectus dolor iure pariatur,
        tempora voluptatibus. Aliquam assumenda debitis, dicta est excepturi explicabo in incidunt, nisi nobis quae
        quasi quidem sunt. Dolorum eos hic officiis quos sit. Aliquid consequuntur delectus excepturi modi officiis
        pariatur possimus quas quia quis sunt! Beatae blanditiis exercitationem expedita facilis id, illum laborum
        vitae? Beatae deleniti dolores illum inventore ipsum laudantium nam nobis quaerat quibusdam totam! Animi atque
        consectetur dignissimos error est, ex excepturi incidunt maiores quae quas qui quia recusandae repellat
        repellendus sequi similique, sunt tenetur, voluptas? Ab ad architecto assumenda consequatur, cum cupiditate
        deleniti dolorem eligendi esse eveniet, exercitationem fuga, harum iusto laudantium libero minus odit. Aliquid
        amet dolore, doloribus, ex ipsa maxime mollitia nesciunt nisi numquam obcaecati optio possimus quae quaerat
        recusandae reprehenderit sint soluta voluptas, voluptatem. Soluta!</h1>

    <div id="profile_selection_overlay" class="overlay active">
        <div class="modal">
            <div class="tab-list">
                <input type="radio" name="profile_selector" id="student_tab" class="tab_selector" checked>
                <label for="student_tab" class="tab_selector_label">
                    Студент
                </label>
                <input type="radio" name="profile_selector" id="professor_tab" class="tab_selector">
                <label for="professor_tab" class="tab_selector_label">
                    Преподаватель
                </label>
            </div>
            <div class="tab-content">
                <div id="student_tab_content" class="active">
                    <select name="type" required="">
                        <option class="op" selected>Выберите факультет</option>

                        <!  <php> ..>
                    </select>

                    <select name="type" required="">
                        <option class="op" selected>Выберите группу</option>

                        <!  <php> ..>
                    </select>

                    <button type="submit" class="btn"> Показать </button>
                </div>
                <div id="professor_tab_content">
                    <select name="type" class="professor_tab" required="">
                        <option class="op" selected>Выберите преподавателя</option>

                        <!  <php> ..>
                    </select>

                    <button type="submit" class="btn"> Показать </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    const overlay_menu = document.getElementById('overlay_menu');
    const menu = document.getElementById('menu');
    const student_tab = document.getElementById('student_tab');
    const profile_selection_overlay = $('#profile_selection_overlay');

    function toggleModal(closingObject, openingObject) {
        $(closingObject).css('display', 'none');
        $('#ham-menu').prop('checked', false)
        openingObject.addClass('active');
    }

    document.getElementById("time_today").onclick = function () {
        toggleModal([menu, overlay_menu], profile_selection_overlay);
    }

    $('.tab_selector').click(function (event){
        console.log(event.target.id)
        $('.tab-content .active').removeClass('active');
        $('.tab-content').children(`#${event.target.id}_content`).addClass('active');
    })
</script>

</html>
