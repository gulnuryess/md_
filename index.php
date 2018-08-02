<?php
session_start();

if(isset($_SESSION['pay'])){
  Header("Location: library");
}

  if(!isset($_COOKIE["time"])) {
    setcookie("time", date('H:i:s'), time() + 14400, "/");
    $all_second = 14400;
  } else {
    $old_date = $_COOKIE["time"];
    $new_date = date('H:i:s');
    $time1 = new DateTime($old_date);
    $time2 = new DateTime($new_date);
    $interval = $time1->diff($time2);
    $date =  ($interval->format('%H') * 3600) + ($interval->format('%I') * 60) + $interval->format('%S');
    $all_second = 14400 - $date;
  }

  $Month_r = array(
  "01" => "Января",
  "02" => "Февраля",
  "03" => "Марта",
  "04" => "Апреля",
  "05" => "Мая",
  "06" => "Июня",
  "07" => "Июля",
  "08" => "Августа",
  "09" => "Сентября",
  "10" => "Октября",
  "11" => "Ноября",
  "12" => "Декабря");

  $now_month = date('m', time()); // месяц на eng
  $rus_month = $Month_r[$now_month];


  if (filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING) == NULL or filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING) == ''){
    if(isset($_SERVER['HTTP_REFERER'])) {
      $utm_source = $_SERVER['HTTP_REFERER'];
    }else{
      $utm_source = "Прямой переход";
    }
    $utm_source = "Прямой переход";
    $utm_campaign = "";
    $utm_keyword = "";
    $utm_sourcersy = "";
    $utm_medium = "";
  }else{
    $utm_source = filter_input(INPUT_GET,"utm_source",FILTER_SANITIZE_STRING);
    $utm_campaign = filter_input(INPUT_GET,"utm_campaign",FILTER_SANITIZE_STRING);
    $utm_keyword = filter_input(INPUT_GET,"utm_term",FILTER_SANITIZE_STRING);
    $utm_sourcersy = filter_input(INPUT_GET,"utm_content",FILTER_SANITIZE_STRING);
    $utm_medium = filter_input(INPUT_GET,"utm_medium",FILTER_SANITIZE_STRING);
  }

  if($utm_source == NULL or $utm_source == ''){
    $utm_source = "Прямой переход";
  }

  if(isset($_GET['utm_city'])) {
    if($_GET['utm_city'] == 'alm') {
      $city = 'Almaty';
    }
    elseif($_GET['utm_city'] == 'ast'){
      $city = 'Astana';
    }
  }else {
    $city = "Almaty";
  }

  if (isset($_REQUEST["text"])) {
    $text = preg_replace("![^0-9]!", "", $_REQUEST["text"]);
  }
  if (isset($_REQUEST["add"])) {
    $add = preg_replace("![^0-9]!", "", $_REQUEST["add"]);
  }
  if (isset($_REQUEST["block"])) {
    $block = preg_replace("![^0-9]!", "", $_REQUEST["block"]);
  }
  if (isset($_REQUEST["stock"])) {
    $stock = preg_replace("![^0-9]!", "", $_REQUEST["stock"]);
  }

  if (!isset($text)) {
    $text = 1;
  }
  if (!isset($add)) {
    $add = 1;
  }
  if (!isset($block) || $block>5) {
    $block = 1;
  }
  if (!isset($stock) || $stock>3) {
    $stock = 1;
  }


  //Ссылка на наш опубликованный файл CSV
  $fileUrl = 'https://docs.google.com/spreadsheets/d/1YMZppJPlirgmB3Tl5QAgigDdP-TxFTvi1mZxPaO-zNQ/pub?gid=0&single=true&output=csv';
  //Получаем наш файл из гугл док в виде массива
  $table = fsCsvToArray($fileUrl);


  // Для каждой переменной выбираем значение из таблицы

  for ($i=0; $i<count($table); $i++) {
    if ($table[$i][0] == $text) {
      $curr_text = $table[$i][1];
      break;
    }
  }

  for ($i=0; $i<count($table); $i++) {
    if ($table[$i][2] == $add) {
      $curr_add = $table[$i][3];
      break;
    }
  }

  for ($i=0; $i<count($table); $i++) {
    if ($table[$i][4] == $add) {
      $curr_block = $table[$i][5];
      break;
    }
  }

  function fsCsvToArray($pFile, $pDelimiter = ','){

      if (($handle = fopen($pFile, 'r')) !== FALSE) {
        $i = 0;
        while (($lineArray = fgetcsv($handle, 4000, $pDelimiter, '"')) !== FALSE) {
          for ($j = 0; $j < count($lineArray); $j++) {
            $arr[$i][$j] = $lineArray[$j];
          }
          $i++;
        }
        fclose($handle);
      }
      return $arr;
  }

  function formatPrint($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MD Study | Прогрессивные бухгалтерские курсы по всему Казахстану</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

    <!-- Style -->
    <link rel="stylesheet/less" type="text/css" media="all" href="style.less?id=1">
    <script src="js/less.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/like/social-likes_classic.css">
    <!-- JS -->
    <script src="js/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/sweetalert/dist/sweetalert.css">
    <script src="//vk.com/js/api/openapi.js?122" type="text/javascript"></script>

  </head>
  <body>
  <div id="wrapper">

    <!-- Modal -->
    <div id="offerModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center" style="    display: block;
    -webkit-margin-before: 1.33em;
    -webkit-margin-after: 1.33em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
    font-weight: bold;">Сделайте репост в соц. сетях и получи<br>доступ к бесплатному пробному уроку</h4>
          </div>
          <div class="modal-body">
            <center><img style="width: 50%;" src="img/desktop.png"></center>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <script src="js/like/social-likes.min.js"></script>
            <center>
              <div class="social-likes" data-url="http://study.mirusdesk.kz">
                <div class="facebook socDiv" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
                <div class="mailru socDiv" title="Поделиться ссылкой в Моём мире">Мой мир</div>
                <div class="vkontakte socDiv" title="Поделиться ссылкой во Вконтакте">Вконтакте</div><br>
                <div class="odnoklassniki socDiv" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
                <div class="plusone socDiv" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
              </div>
            </center>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal -->
    <!-- <div id="offerModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">

        <div class="modal-content">
          <div class="row">
            <p class="btn_end" class="text-right"><span><i class="fa fa-times fa-lg" class="close" data-dismiss="modal"></i></span></p>
            <div class="jumbotronus">
              <div class="left col-sm-5">
                <img src="img/desktop.png">
              </div>
              <div class="right col-sm-7">
                <p>Сделайте репост в соц. сетях и получи доступ к бесплатному пробному уроку</p>
              </div>

              <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
              <script src="js/like/social-likes.min.js"></script>
              <center>
                <div class="social-likes" data-url="http://study.mirusdesk.kz">
                  <div class="facebook socDiv" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
                  <div class="mailru socDiv" title="Поделиться ссылкой в Моём мире">Мой мир</div>
                  <div class="vkontakte socDiv" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
                  <div class="odnoklassniki socDiv" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
                  <div class="plusone socDiv" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
                </div>
              </center>

              <p class="button text-center">скачать урок</p>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /Modal -->

    <!-- SECTION HEADER -->
    <div class="container-fluid" id="headerSection" style="	#headerSection{
    		.container_my{
    			padding: 35px 5% 0px 5%;
    		}
    	}">
      <div class="container_my" style="background-color: black; ">

      <div class="content">

        <div class="row">
          <div class="col-sm-6 logo">
            <p  style="color:white;"class="logoName">MD</p>
            <p class="logoType">STUDY</p>
            <p class="logoSlogan" style="color:#777777;">ПРОГРЕССИВНЫЕ БУХГАЛТЕРСКИЕ<br>КУРСЫ ПО ВСЕМУ КАЗАХСТАНУ</p>
          </div>
          <div class="addingPeople" style=".addingPeople .proff {
    position: absolute;
    top: 0;
    right: 170px;
    font-size: 10px;
    color: white;
    font-family: inherit;
    border: 0;
    background-color: #80397b;
    outline: none;
    border-radius: 0 0 3px 3px;
    padding: 6px;
    padding-left: 6px;
    font-weight: 300;
}">
            <input type="button" checked value="ПРОФЕССИОНАЛ" class="proff" >
            <input type="button" value="НОВИЧОК" class="newo">
            <script>

 };
            </script>


          </div>
            <div class="clear"></div>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION HEADER -->

    <!-- SECTION UTP -->
    <div class="container-fluid" id="utpSection" >

      <video   style="width:100%; position:absolute;"autoplay= "autoplay" class="video">
        <source src="vvedenie.mp4" type="video/mp4">


      </video>


  <!--    <video autoplay controls style="width:auto; height:auto; position:absolute;
display:block;">
      <source  src="video/vvedenie.mp4" type="video/mp4">
     </video>  -->
      <div class="container_my">

      <div class="black">

        <div class="row">
          <div class="col-sm-12">
            <p style="color:white"><?php echo $curr_text;?></p>
            <p style="color: white"><?php echo $curr_add;?></p>
            <div class="coupon"><span style="color:white"><?php echo $curr_block;?></span></div>
            <div class="buttons" style=".buttons a:nth-child(1) span {
    background: #38b630;
    padding: 10px 10px;
    border-radius: 2px;
    float: left;
    color: white;
    cursor: pointer;
}">

              <u class="menu" ><a href="#packetsSection" onclick="spoilerClicked()"><span>СКАЧАТЬ ПРОГРАММУ</span></a></u>
              <a href="login.php"><span  >ВОЙТИ В СИСТЕМУ</span></a></div>


          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION UTP -->


    <!-- SECTION MENU -->
    <!-- /SECTION MENU -->

    <!-- SECTION PAIN -->
    <div class="spoiler_content" style="display: none">
    <div class="container-fluid" id="painSection">
      <div class="container_my">

      <div class="content">

        <div id="myCarousel" class="carousel slide" data-interval="false" data-ride="carousel" >
          <div class="carousel-inner" role="listbox">

            <div class="item active">
              <div class="carousel-caption">
                <div class="top">
                  <p>Устали слушать</p>
                  <p>скучных лекторов, теоретиков</p>
                  <p>и их монотонные объяснения?</p>
                </div>
               if
                <div class="image">
                  <center><img src="img/slider/Slide_icon1.png"></center>
                </div>
                <div class="foot">
                  <div>
                    <p>Мы выжили все соки</p>
                    <p>и показываем только то, что действительно требуется на работе</p>
                  </div>
                  <p class="text-center"><span href="#myCarousel" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
                </div>
              </div>
            </div>

            <div class="item">
              <div class="carousel-caption">
                <div class="top">
                  <p>Устали ходить и</p>
                  <p>учиться на старых компьютерах</p>
                  <p> и программах в атмосфере совковых аудитории</p>
                </div>
                <div class="image">
                  <center><img src="img/slider/Slide_icon2.png"></center>
                </div>
                <div class="foot">
                  <div>
                    <p>Получайте знания в уютной атмосфере</p>
                    <p>лежа на диване с чашкой чая</p>
                  </div>
                  <p class="text-center"><span href="#myCarousel" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
                </div>
              </div>
            </div>

            <div class="item">
              <div class="carousel-caption">
                <div class="top">
                  <p>Устали записывать и</p>
                  <p>перечитывать конспекты</p>
                  <p>а затем искать нужную информацию</p>
                </div>
                <div class="image">
                  <center><img src="img/slider/Slide_icon3.png"></center>
                </div>
                <div class="foot">
                  <div>
                    <p>Наши курсы всегда под рукой</p>
                    <p>и вы сможете применять знания прямо на работе</p>
                  </div>
                  <p class="text-center"><span href="#myCarousel" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
                </div>
              </div>
            </div>

            <div class="item">
              <div class="carousel-caption">
                <div class="top">
                  <p>Устали тратить время и</p>
                  <p>сидеть на форумах целыми днями</p>
                  <p>с целью найти ответы среди кучи мусора</p>
                </div>
                <div class="image">
                  <center><img src="img/slider/Slide_icon4.png"></center>
                </div>
                <div class="foot">
                  <div>
                    <p>Мы консультируем индивидуально</p>
                    <p>и отвечаем на каждый вопрос моментально</p>
                  </div>
                  <p class="text-center"><span href="#myCarousel" role="button" data-slide="next">БОЛЬШЕ ПРИЧИН</span> <img src="img/ar.png"></p>
                </div>
              </div>
            </div>

          </div>

          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span><img class="swap1" src="img/slider/left.png" /></span><span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span><img class="swap2" src="img/slider/right.png" /></span><span class="sr-only">Next</span>
          </a>

        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION PAIN -->


    <!-- SECTION OFFER -->
    <div class="container-fluid" id="offerSection">
      <div class="container_my">

      <div class="content">

        <div class="row">
          <div class="col-sm-12">
            <p>СДЕЛАЙТЕ РЕПОСТ В СОЦ. СЕТЯХ И</p>
            <p>ПОЛУЧИТЕ ПРОБНЫЙ<br>УРОК Бесплатно</p>
            <div class="coupon"><span>ТОЛЬКО СЕГОДНЯ, ПОЛУЧИТЕ памятку и<br><u>календарь бухгалтера В ПОДАРОК!</u></span></div>
            <div class="timer">
              <b>До конца акции осталось:</b>
              <div>
                <span class="count hour">00</span>
                <span class="dots">:</span>
                <span class="count minutes">00</span>
                <span class="dots">:</span>
                <span class="count seconds">00</span>
                <span class="button" data-toggle="modal" data-target="#offerModal">СКАЧАТЬ УРОК</span>
              </div>
            </div>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION OFFER -->


    <!-- SECTION PACKETS -->
    <div class="container-fluid" id="packetsSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>Выберите</p>
            <p>Багаж знании</p>
            <p>для своего развития</p>
          </div>
        </div>

        <div class="row text-center">
          <div class="col-sm-4 first">
            <div class="panel panel-default">
              <div class="panel-heading">Сумка знании</div>
              <div class="panel-body">
                <center><img src="img/packets/first.svg"></center>
                <ul>
                  <li>Видеоурок теория «Бухгалтер-оператор»</li>
                  <li>Видеоурок практика «Бухгалтер-оператор»</li>
                  <li>База ответов</li>
                  <li>Домашнее задание</li>
                  <li>Тестирование</li>
                </ul>
                <div class="checks1 display_none">
                  <hr>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks1_1" value="">Сертификат</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks1_2" value="">Консультация по почте</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks1_3" value="">Шаблоны первичных документов</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="footer">
              <p>(вместо <span><span class="span1">23500</span></span>)</p>
              <p><span class="span1_1">4900</span> <img src="img/tg_first.png"></p>
              <p><span onclick="choose('1')" class="button chooseButton1">ПОЛУЧИТЬ ДОСТУП</span></p>
              <p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
            </div>
          </div>

          <div class="col-sm-4 second">
            <div class="panel panel-default">
              <div class="panel-heading">чемодан знании</div>
              <div class="panel-body">
                <center><img src="img/packets/second.svg"></center>
                <ul>
                  <li>Видеоурок теория «Бухгалтер-оператор»</li>
                  <li>Видеоурок практика «Бухгалтер-оператор»</li>
                  <li>Видеоурок «Онлайн банкинг (KAZKOM)»</li>
                  <li>Видеоурок «Разбор кейсов»</li>
                  <li>Трехмесячная поддержка учеников</li>
                  <li>База ответов</li>
                  <li>Домашнее задание</li>
                  <li>Тестирование</li>
                </ul>
                <div class="checks2 display_none">
                  <hr>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks2_1" value="">Сертификат</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks2_2" value="">Консультация по почте</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks2_3" value="">Шаблоны первичных документов</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="footer">
              <p>(вместо <span class="span2">32500</span>)</p>
              <p><span class="span2_1">9900</span> <img src="img/tg_second.png"></p>
              <p><span onclick="choose('2')" class="button chooseButton2">ПОЛУЧИТЬ ДОСТУП</span>
              </p>
              <p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
            </div>
          </div>

          <div class="col-sm-4 third">
            <div class="panel panel-default">
              <div class="panel-heading">вагон знании</div>
              <div class="panel-body">
                <center><img src="img/packets/third.svg"></center>
                <ul>
                  <li>Видеоурок теория «Бухгалтер-оператор»</li>
                  <li>Видеоурок практика «Бухгалтер-оператор»</li>
                  <li>Видеоурок «Онлайн банкинг (5 банков)»</li>
                  <li>Видеоурок «Разбор кейсов»</li>
                  <li>Шести месячная поддержка учеников</li>
                  <li>База ответов</li>
                  <li>Домашнее задание</li>
                  <li>Тестирование</li>
                </ul>
                <div class="checks3 display_none">
                  <hr>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks3_1" value="">Сертификат</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks3_2" value="">Консультация по почте</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" id="checks3_3" value="">Шаблоны первичных документов</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="footer">
              <p>(вместо <span class="span3">43500</span>)</p>
              <p><span class="span3_1">14900</span> <img src="img/tg_third.png"></p>
              <p><span onclick="choose('3')" class="button chooseButton3">ПОЛУЧИТЬ ДОСТУП</span></p>
              <p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
            </div>
          </div>
        </div>

      </div>


      </div>
    </div>
    <!-- /SECTION PACKETS -->


    <!-- SECTION STUDENT TYPE -->
    <div class="container-fluid" id="studentTypeSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>Понять и применять</p>
            <p>знания на практике в любой компании</p>
            <p>обучившись основам бухгалтерии всего за 2 дня</p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 type">
            <img src="img/student_type/1.svg">
            <div class="text">
              <p>Вы недавно закончили университет?</p>
              <p>Для тех, кто хочет изучить бухгалтерский учет «с нуля», а так же освоить практические знания по программе 1С бухгалтерия 8.3</p>
            </div>
            <div class="clear"></div>
          </div>
          <div class="col-md-6 type">
            <img src="img/student_type/2.svg">
            <div class="text">
              <p>Вы начали искать работу?</p>
              <p>Для тех, кто хочет изучить бухгалтерский учет «с нуля», а так же освоить практические знания по программе 1С бухгалтерия 8.3</p>
            </div>
            <div class="clear"></div>
          </div>
          <div class="col-md-6 type">
            <img src="img/student_type/3.svg">
            <div class="text">
              <p>Вы не хотите проходить бесплатные стажировки?</p>
              <p>Для тех, кто хочет изучить бухгалтерский учет «с нуля», а так же освоить практические знания по программе 1С бухгалтерия 8.3</p>
            </div>
            <div class="clear"></div>
          </div>
          <div class="col-md-6 type">
            <img src="img/student_type/4.svg">
            <div class="text">
              <p>Вы хотите грамотно работать в 1С?</p>
              <p>Для тех, кто хочет изучить бухгалтерский учет «с нуля», а так же освоить практические знания в программе 1С бухгалтерия 8.3</p>
            </div>
            <div class="clear"></div>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION STUDENT TYPE -->

    <!-- SECTION PROGRAMM -->
    <div class="container-fluid" id="programmSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>На данном курсе вы получите</p>
            <p>36 видеоуроков реальной практики</p>
            <p>на базе 1С 8.3</p>
          </div>
        </div>
        <ul class="nav nav-pills">
          <li class="nav1 active"><a data-toggle="pill" href="#home">Основы бухгалтерии</a></li>
          <li class="nav2"><a data-toggle="pill" href="#menu1">Практическое задание</a></li>
          <li class="nav3"><a data-toggle="pill" href="#menu2">ДОМАШНЕЕ ЗАДАНИЕ</a></li>
          <li class="nav4"><a data-toggle="pill" href="#menu3">ТЕСТИРОВАНИЕ</a></li>
        </ul>

        <div class="tab-content">

          <div id="home" class="tab-pane fade in active">
            <div class="row tab">
              <div class="col-sm-4 block">
                <p><img src="img/list/1.svg">Касса</p>
                <p>Порядок оформления кассовых документов вам понадобится для регистрации приема и выдачи денежных средств. Заполнение необходимых данных для выписки приходного кассового ордера и расходного кассового ордера.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/2.svg">Банк</p>
                <p>Для проведения безналичных операции необходимо составить банковские документы, а именно входящие и исходящие платежные поручения в базе 1С.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/3.svg">Поступление товаров/услуг</p>
                <p>Процесс получения товаров или услуг от поставщика предполагает получение входящей счет-фактуры и правильного отражения в оборотах предприятия.</p>
              </div>
            </div>
            <div class="row second_row">
              <div class="col-sm-4 block">
                <p><img src="img/list/4.svg">Реализация товаров/услуг</p>
                <p>Продажу товаров или услуг необходимо сопровождать выдачей счет-фактуры покупателю.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/5.svg">Заработная плата</p>
                <p>Для оплаты труда вам необходимо будет ежемесячно начислять зарплату, рассчитывать налоги и отчисления, а также отражать зарплату в регламентированном учете.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/6.svg">Кадровый учет</p>
                <p>Документальное сопровождение приемов на работу сотрудников, увольнения и командировок организации.</p>
              </div>
            </div>
          </div>

          <div id="menu1" class="tab-pane fade">
            <div class="row tab">
              <div class="col-sm-4 block">
                <p><img src="img/list/1.svg">Касса</p>
                <p>Организация кассовых операции и их документальное оформление, утвержденные Министерством Финансов Республики Казахстан.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/2.svg">Банк</p>
                <p>Ознакомление с различными видами банковских операции.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/3.svg">Поступление товаров/услуг</p>
                <p>Оприходование входящих счет-фактур, накладных/актов выполненных работ за приобретенных товар или услуг.</p>
              </div>
            </div>
            <div class="row second_row">
              <div class="col-sm-4 block">
                <p><img src="img/list/4.svg">Реализация товаров/услуг</p>
                <p>Счет-фактура является обязательным документом при осуществлении оборотов по реализации товаров, работ, услуг.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/5.svg">Заработная плата</p>
                <p>Вознаграждение за труд работников в соответствии с законодательством Республики Казахстан.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/6.svg">Кадровый учет</p>
                <p>Введение кадрового учета является обязательным, и должно сопровождаться правильным документооборотом.</p>
              </div>
            </div>
          </div>

          <div id="menu2" class="tab-pane fade">
            <div class="row tab">
              <div class="col-sm-4 block">
                <p><img src="img/list/1-1.svg">Бухгалтерский учет - его сущность и значение</p>
                <p>Ознакомление с основными принципами построения бухгалтерского учета, его целями и функциями,а также с требованиями, предъявляемыми к информации, формируемой в бухгалтерском учете.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-2.svg">Предмет и метод бухгалтерского учета</p>
                <p>Ознакомление с основой методологии бухгалтерского учета, которой является система способов и набор определенных приемов, применяющихся в определенной последовательности и взаимосвязи для отражения объектов учета.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-3.svg">Бухгалтерский баланс</p>
                <p>Понятие "баланс" в бухгалтерском учете, его составные части, а также различия между ними.</p>
              </div>
            </div>
            <div class="row second_row">
              <div class="col-sm-4 block">
                <p><img src="img/list/1-4.svg">Система бухгалтерских счетов и двойная запись</p>
                <p> Ознакомление со структурой информационной системы бухгалтерского учета, которую определяет двойная запись на счетах, понятие синтетических и аналитических счетов.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-5.svg">Основы финансовой отчетности</p>
                <p>Финансовая отчетность в системе в системе управления организацией, ее состав и предъявляемые к ней требования.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-6.svg">Учет, амортизация и выбытие нематериальных активов</p>
                <p> Понятие и виды нематериальных активов,их характеристика и оценка.</p>
              </div>
            </div>
          </div>

          <div id="menu3" class="tab-pane fade">
            <div class="row tab">
              <div class="col-sm-4 block">
                <p><img src="img/list/1-1.svg">Бухгалтерский учет-его сущность и значение</p>
                <p>Ознакомление с основными принципами построения бухгалтерского учета, его целями и функциями,а также с требованиями, предъявляемыми к информации, формируемой в бухгалтерском учете.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-2.svg">Предмет и метод бухгалтерского учета</p>
                <p>Ознакомление с основой методологии бухгалтерского учета, которой является система способов и набор определенных приемов, применяющихся в определенной последовательности и взаимосвязи для отражения объектов учета.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-3.svg">Бухгалтерский баланс</p>
                <p>Понятие "баланс" в бухгалтерском учете, его составные части, а также различия между ними.</p>
              </div>
            </div>
            <div class="row second_row">
              <div class="col-sm-4 block">
                <p><img src="img/list/1-4.svg">Система бухгалтерских счетов и двойная запись</p>
                <p> Ознакомление со структурой информационной системы бухгалтерского учета, которую определяет двойная запись на счетах, понятие синтетических и аналитических счетов.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-5.svg">Основы финансовой отчетности</p>
                <p>Финансовая отчетность в системе в системе управления организацией, ее состав и предъявляемые к ней требования.</p>
              </div>
              <div class="col-sm-4 block">
                <p><img src="img/list/1-6.svg">Учет, амортизация и выбытие нематериальных активов</p>
                <p> Понятие и виды нематериальных активов,их характеристика и оценка.</p>
              </div>
            </div>
          </div>

        </div>

        <p class="menu"><a href="#packetsSection"><span>СКАЧАТЬ ПРОГРАММУ</span></a></p>

      </div>

      </div>
    </div>
    <!-- /SECTION PROGRAMM -->

    <!-- SECTION FACTS -->
    <div class="container-fluid" id="factsSection">
      <div class="container_my">

      <div class="content">


        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>Неоспоримые и Подтвержденные факты </p>
            <p>Практического курса</p>
            <p>от прогрессивной компании MIRUSDESK</p>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3 col-xs-6 fact">
            <center>
              <img src="img/facts/1.svg">
              <p>Более 1200 учеников успешно прошли наши курсы за последние полгода</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 fact">
            <center>
              <img src="img/facts/2.svg">
              <p>Курс записан бухгалтерами - практиками на основе реальных компаний</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 fact">
            <center>
              <img src="img/facts/3.svg">
              <p>Наши сертификаты имеет высокую репутацию в компаниях Казахстана</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 fact">
            <center>
              <img src="img/facts/4.svg">
              <p>Мы единственные в Казахстане,<br> кто обучает на базе программы 1С 8.3</p>
            </center>
          </div>
          <div class="col-sm-12 bigFact">
            <center>
              <div>
                <img src="img/wow.gif">
              </div>
              <div class="clear"></div>
              <div class="text">
                <p>95% учеников находят работу</p>
                <p>в течение 1-го месяца</p>
              </div>
            </center>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION FACTS -->

    <!-- SECTION VIDEO -->
    <div class="container-fluid" id="videoSection">

 </video>
      <div class="container_my">

        <div class="row">

          <div class="col-sm-12 bigReason">
            <center>
              <div class="videoWrapper">
                <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><iframe src="//fast.wistia.net/embed/iframe/qir0m3apfs?videoFoam=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="100%" height="100%"></iframe></div></div>
                <script src="//fast.wistia.net/assets/external/E-v1.js" async></script>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/NNcenE1WMlg" frameborder="0" allowfullscreen></iframe> -->
              </div>
              <div class="text">
                <p>Ляззат Абдраимова</p>
                <p>бухгалтер материального стола</p><br>
                <p class="text-center menu"><span class="button" id="btnAnimate2">ПОСМОТРЕТЬ ОСТАЛЬНЫХ</span></p>
              </div>
            </center>
          </div>

          <div class="col-sm-12 bigReason">
            <center>
              <div class="videoWrapper">
                <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><iframe src="//fast.wistia.net/embed/iframe/629q3bejiw?videoFoam=true" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="100%" height="100%"></iframe></div></div>
                <script src="//fast.wistia.net/assets/external/E-v1.js" async></script>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/NNcenE1WMlg" frameborder="0" allowfullscreen></iframe> -->
              </div>
              <div class="text">
                <p>Корлан Апраимова</p>
                <p>бухгалтер материального стола</p><br>
                <p class="text-center menu"><span class="button" id="btnAnimate1">ПОСМОТРЕТЬ ОСТАЛЬНЫХ</span></p>
              </div>
            </center>
          </div>

        </div>

      </div>
    </div>
    <!-- /SECTION VIDEO -->



    <!-- SECTION REASONS -->
    <div class="container-fluid" id="reasonsSection">
      <div class="container_my">

      <div class="content">


        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>Самые основные</p>
            <p>7 причин купить курс</p>
            <p>прямо сегодня</p>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/1.svg">
              <p>Гибкий график обучения<br>на ваше усмотрение</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/2.svg">
              <p>Доступ к курсам с любого устройства и с любой точки мира</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/3.svg">
              <p>Большое сообщество бухгалтеров для обмена знаниями</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/4.svg">
              <p>Курс отвечает на реальные потребности компании</p>
            </center>
          </div>
        </div><br>

        <div class="row">
          <div class="col-sm-1" style="width: 12.499999995%"></div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/5.svg">
              <p>Публикуем лучшие результаты учеников для работодателей</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons/6.svg">
              <p>Данный курс в 3 раза дешевле,<br> чем на рынке</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-12 reason">
            <center>
              <img src="img/reasons/7.svg">
              <p>Любая удобная форма оплаты <br>(Qiwi-кошелек, Visa, MasterCard и тд.)</p>
            </center>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION REASONS -->

    <!-- SECTION REASONS 2 -->
    <div class="container-fluid" id="plusSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1 two">
          <div class="col-sm-12 text-center">
            <p>Эксклюзивные материалы</p>
            <p>Лайфхаки и уникальные фишки</p>
            <p>от профессиональных бухгалтеров</p>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons2/1.svg">
              <p>Пользоваться всеми онлайн банками ведущих банков РК</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons2/2.svg">
              <p>Самостоятельно создавать базу и настраивать 1С в компаниях</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons2/3.svg">
              <p>Самостоятельно настраивать кабинет налогоплательщика</p>
            </center>
          </div>
          <div class="col-sm-3 col-xs-6 reason">
            <center>
              <img src="img/reasons2/4.svg">
              <p>Выставлять счет на оплату<br>за 59 секунд</p>
            </center>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 bigReason">
            <center>
              <div>
                <img src="img/mac.png" style="width: 100%; max-width: 934px;">
              </div>
              <div class="clear"></div>
              <div class="text">
                <p>Профессионально работать с первичной документацией</p>
                <p>и не допускать ошибок в 1С — никогда</p>
              </div>
            </center>
          </div>
        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION REASONS 2 -->

    <!-- SECTION COMPANIES -->
    <div class="container-fluid" id="companiesSection">
      <div class="container_my">

      <div class="content">


        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>краткий список</p>
            <p>список действующих компаний</p>
            <p>которым требуется бухгалтер на постоянной основе</p>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/gt.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/opt.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/vse.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/gala.jpg" style="width: 100%;"></center>
          </div>

        </div>
        <br><br>
        <div class="row">

          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/mle.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/stroi.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/alasha.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/trub.jpg" style="width: 100%;"></center>
          </div>

        </div>
        <br><br>
        <div class="row">

          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/kabel.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/alel.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/md.jpg" style="width: 100%;"></center>
          </div>
          <div class="col-sm-3 col-xs-6">
            <center><img src="img/logos/amanat.jpg" style="width: 100%;"></center>
          </div>
        </div>

        <br><br><br><br><br><br>

      </div>

      </div>
    </div>
    <!-- /SECTION COMPANIES -->


    <div class="container-fluid" id="feedbackSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>отзывы реальных учеников, которые </p>
            <p>устроились на престижную работу</p>
            <p>благодаря нашим курсам</p>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-6 feedback">
            <div class="panel panel-default">
              <div class="panel-body">
                <script src="//fast.wistia.com/embed/medias/04i7me0q5m.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper" style="height:130px;width:130px;"><span class="wistia_embed wistia_async_04i7me0q5m popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:130px;width:130px">&nbsp;</span></div></div>
                <img src="img/ava.png">
                <div class="text">
                  <p>Галия Мукашева</p>
                  <p>бухгалтер оператор</p>
                  <p>Всем привет! Меня зовут Галия, мне 21 год. Родом с Алматинской области, закончила бухгалтерский учет и аудит. Хочу открыть свое дело, но для начало - получить знание.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 feedback">
            <div class="panel panel-default">
              <div class="panel-body">
                <script src="//fast.wistia.com/embed/medias/h8rdpkwvrs.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper" style="height:130px;width:130px;"><span class="wistia_embed wistia_async_h8rdpkwvrs popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:130px;width:130px">&nbsp;</span></div></div>
                <img src="img/ava.png">
                <div class="text">
                  <p>Айталина Константинова</p>
                  <p>бухгалтер</p>
                  <p>Всем привет! Меня зовут Айталина, я родом из Якутска. Я начала искать работу, я понимала, что перспективную работу мне будет трудно найти, после чего решила пройти курсы.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row">

          <div class="col-sm-6 feedback">
            <div class="panel panel-default">
              <div class="panel-body">
                <script src="//fast.wistia.com/embed/medias/mejptw97af.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper" style="height:130px;width:130px;"><span class="wistia_embed wistia_async_mejptw97af popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:130px;width:130px">&nbsp;</span></div></div>
                <img src="img/ava.png">
                <div class="text">
                  <p>Меруерт Увакова</p>
                  <p>рядовой бухгалтер</p>
                  <p>Вообще, я начинала с офис-менеджера, это было примерно год назад. Год спустя я решилась поговорить с шефом о своей мечте-пойти по бухгалтерской стези.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6 feedback">
            <div class="panel panel-default">
              <div class="panel-body">
                <script src="//fast.wistia.com/embed/medias/ooliydro72.jsonp" async></script><script src="//fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding"><div class="wistia_responsive_wrapper" style="height:130px;width:130px;"><span class="wistia_embed wistia_async_ooliydro72 popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:130px;width:130px">&nbsp;</span></div></div>
                <img src="img/ava.png">
                <div class="text">
                  <p>Асанбай Рахматуллаев</p>
                  <p>рядовой бухгалтер</p>
                  <p>Қайырлы күн! Меня зовут Асан, мне 23 года. Совсем недавно я приехал в Алматы в поисках работы, решил, как говорится, покорить большой город, испытать себя на прочность. </p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 share" style="margin-top: 10px;">
            <div class="text-center">
              <p style="font-size: 20px;">РАССКАЖИТЕ ДРУЗЬЯМ И ПОЛУЧИТЕ ДОСТУП К СООБЩЕСТВУ</p>
              <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
              <script src="js/like/social-likes.min.js"></script>

              <div class="social-likes" data-url="http://study.mirusdesk.kz">
                <div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
                <div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
                <div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
                <div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
                <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
              </div>
            </div>
          </div>


        </div>

      </div>

      </div>
    </div>
    <!-- SECTION REASONS -->

    <!-- SECTION COMMENT -->
    <div class="container-fluid" id="commentSection">
      <div class="container_my">

      <div class="content">

        <div class="row head1">
          <div class="col-sm-12 text-center">
            <p>Здесь наши ученики оставляют</p>
            <p>слова благодарности и делятся инсайтами</p>
            <p>по завершению нашего курса</p>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-6">
            <script type="text/javascript">
              VK.init({apiId: 5248192, onlyWidgets: true});
            </script>
            <div id="vk_comments"></div>
            <script type="text/javascript">
            VK.Widgets.Comments("vk_comments", {limit: 10, width: "665", attach: "*"});
            </script>
          </div>

          <div class="col-sm-6">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.6";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-comments" data-href="http://study.mirusdesk.kz" data-numposts="5"></div>
          </div>

        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION COMMENT -->
</div>
    <!-- SECTION FOOTER -->
    <div class="container-fluid"  style="
    position: relative
    ;
"id="footerSection">
      <div class="container_my" style=".container_my {
    padding: 0px 5% 0px 5%;
}">

      <div class="content">

        <div class="row">

          <div class="col-md-4 col-sm-6">
            <div class="logo">
              <p class="logoName">MD</p>
              <p class="logoType">STUDY</p>
              <p class="logoSlogan" >ПРОГРЕССИВНЫЕ БУХГАЛТЕРСКИЕ<br>КУРСЫ ПО ВСЕМУ КАЗАХСТАНУ</p>
              <div class="clear"></div>
            </div>

            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=XwY5PU4D4YB32GhPO-BMWUd8Rj3S8XEr&amp;width=100%&amp;height=120&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
            <p class="adress"><span>Наш офис: </span>г. Алматы, мкр. Самал-2, 58/19 | ИП «MIRUSDESK» | 831216300684</p>

            <p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="https://drive.google.com/file/d/0B7nmWECPy2hQMU9KM1diSTI0U0k/view?usp=sharing" target="_blank">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a> | RELEASE 1.0</p>
          </div>

          <div class="col-md-4 hidden-sm hidden-xs">
            <p>
              <span>Оформление:</span> приходного кассового ордера | прихода в кассу от оплаты покупателя | взноса наличных денежных средств в банк из кассы | реализации товаров | реализации услуг | покупки товаров у поставщика | доверенности на покупку товара | командировочного удостоверения | расходно-кассового ордера на оплату поставщику
              <br><br>
              <span>Формирование:</span> платежного поручения на перечисление пенсионных взносов | платежного поручения на перечисление социальных отчислений  | платежного поручения на перечисление социального налога  | платежного поручения на перечисление индивидуального подоходного налога | платежного поручения на выплату заработной платы сотруднику с расчетного счета <br><br>
              Возврат денежных средств осуществляется в порядке, предусмотренном законодательством РК
            </p>
          </div>

          <div class="col-md-4 col-sm-6">
            <p style="color:white">ЭЛЕКТРОННАЯ РАССЫЛКА</p>
            <p>Опыт | идеи | кейсы | новости | скидки | обратная связь</p>
            <p>Оставьте свою электронную почту,<br class="sm-hidden"> и будь в курсе событии</p>
            <input type="text" class="text" id="email" placeholder="Ваша почта:">
            <p class='button' onclick="sendData();">ПОДПИСАТЬСЯ!</p>
            <p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="https://drive.google.com/file/d/0B7nmWECPy2hQMU9KM1diSTI0U0k/view?usp=sharing" target="_blank">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a> | RELEASE 1.0</p>
          </div>

        </div>

      </div>

      </div>
    </div>
    <!-- /SECTION FOOTER -->

    <script type="text/javascript">

    // Call sidebar
    $("#divBar").click(function() {
      sidebar("slide");
    });

    // Check which nav must see user
    checkScreenSize();
    window.onresize = function(event) {
      checkScreenSize();
    }

    // when scroll check screen, fix nav and close sidebar
    $(window).scroll(function(){
      checkScreenSize();
      fixedNav();
      sidebar("close");
    });

    // sidebar open and close
    function sidebar(command){
      if (command == "close"){
        if($("#divBar").hasClass("cross") == true) {
          $("#sidebar").css("right","-100%");
          $("#divBar").removeClass("cross");
        }
      }else{
        if($("#divBar").hasClass("cross") == false){
          $("#sidebar").css("right","0px");
        }else{
          $("#sidebar").css("right","-100%");
        }
        return $("#divBar").toggleClass("cross");
      }
    }

    // Check which nav must see user
    function checkScreenSize(){
      var windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;
      var mobile = windowWidth < 993;
      var hideContact = windowWidth < 500;

      if (mobile) {
        $("#nav").addClass('display_none');
        $("#navMobile").removeClass('display_none');
      }else{
        $("#navMobile").addClass('display_none');
        $("#nav").removeClass('display_none');
      }
    }

    // Fix navigation to top
    function fixedNav(){
      var aTop = $('#headerSection').height() + $('#utpSection').height();
      var width = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;

      var fromTop = $(this).scrollTop();

      var studentTypeSection1 = $("#studentTypeSection").position().top;
      var studentTypeSection2 = $("#studentTypeSection").position().top + $('#studentTypeSection').height();

      var programmSection1 = $("#programmSection").position().top - 50;
      var programmSection2 = $("#programmSection").position().top + $('#programmSection').height();

      var reasonsSection1 = $("#reasonsSection").position().top - 50;
      var reasonsSection2 = $("#reasonsSection").position().top + $('#reasonsSection').height() + $('#plusSection').height();

      var packetsSection1 = $("#packetsSection").position().top - 50;
      var packetsSection2 = $("#packetsSection").position().top + $('#packetsSection').height();

      var factsSection1 = $("#factsSection").position().top - 50;
      var factsSection2 = $("#factsSection").position().top + $('#factsSection').height() + $('#videoSection').height();

      var offerSection1 = $("#offerSection").position().top - 50;
      var offerSection2 = $("#offerSection").position().top + $('#offerSection').height();

      var painSection1 = $("#painSection").position().top - 50;
      var painSection2 = $("#painSection").position().top + $('#painSection').height();

      if (fromTop > studentTypeSection1 && fromTop < studentTypeSection2) {
        $("#studentTypeSectionMenu").addClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > programmSection1 && fromTop < programmSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").addClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > reasonsSection1 && fromTop < reasonsSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").addClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > packetsSection1 && fromTop < packetsSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").addClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > factsSection1 && fromTop < factsSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").addClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > offerSection1 && fromTop < offerSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").addClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }else if (fromTop > painSection1 && fromTop < painSection2) {
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").addClass( "active" );
      }else{
        $("#studentTypeSectionMenu").removeClass( "active" );
        $("#programmSectionMenu").removeClass( "active" );
        $("#reasonsSectionMenu").removeClass( "active" );
        $("#packetsSectionMenu").removeClass( "active" );
        $("#factsSectionMenu").removeClass( "active" );
        $("#offerSectionMenu").removeClass( "active" );
        $("#painSectionMenu").removeClass( "active" );
      }


      if($(this).scrollTop()>=aTop){
        $('#menuSection').css("position", "fixed");
        $('#menuSection').css("top", "0px");
        $('#menuSection').css("margin-top", "0px");

        $('#sidebar').css("position", "fixed");
        $('#sidebar').css("top", "49px");
      }else{

        if (width > 991) {
          // Table etc
          $('#menuSection').css("position", "absolute");
          $('#menuSection').css("top", "600px");
          $('#menuSection').css("margin-top", "2px");

          $('#sidebar').css("position", "absolute");
          $('#sidebar').css("top", "652px");

        }else{
          // Mobile
          $('#menuSection').css("position", "absolute");
          $('#menuSection').css("top", "480px");
          $('#menuSection').css("margin-top", "2px");

          $('#sidebar').css("position", "absolute");
          $('#sidebar').css("top", "532px");
        }
      }
    }

    function sendData() {
        var email = $("#email").val();
        if (!isEmail(email)) {
          swal("Упс!", "Напишите действительную почту", "error");
        }else{
          var postForm = { //Fetch form data
            'email'     : email
          };
          $.ajax({ //Process the form using $.ajax()
              type      : 'POST', //Method type
              url       : 'library/php/newsletter.php', //Your form processing file URL
              data      : postForm, //Forms name
              dataType  : 'text',
              success: function(msg) {
                swal("Успешно отправлено!", "Теперь вы будете в курсе всех событии", "success");
              }
          });
        }
      }
      function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }

      $(".socDiv").click(function(){
        yaCounter38127950.reachGoal('trial_video');
        var counter = 0;
        var interval = setInterval(function() {
            counter++;
            // Display 'counter' wherever you want to display it.
            if (counter == 20) {
                window.location='video/study.mirusdesk.kz.zip';
                clearInterval(interval);
            }
        }, 1000);
      })

      // Teachers blog with big video animate slide left
      function animateLeft($src, $tgt){
        var $parent = $src.parent();
        var width = $parent.width();
        var srcWidth = $src.width();
        $src.css({position: 'relative'});
        $src.fadeOut( 500, function() {
          $tgt.hide().appendTo($parent).css({left: width, position: 'relative'});
          $tgt.show().animate({left: 0}, 500, function(){
              $tgt.css({left: null, position: null});
          });
        });
      }
      $(function(){
        var $first = $("#videoSection .bigReason:nth-child(1)");
        var $second = $("#videoSection .bigReason:nth-child(2)");
        $second.hide();
        $("#btnAnimate1").click(function(){
            animateLeft($first, $second);
            var tmp = $first;
            $first = $second;
            $second = tmp;
        });
        $("#btnAnimate2").click(function(){
            animateLeft($first, $second);
            var tmp = $first;
            $first = $second;
            $second = tmp;
        });
      })

      // Header contact button
      $(".phoneLook").html("<p class='text-center phoneButton phoneButtonactive'>Посмотреть номер <i class='fa fa-eye' aria-hidden='true'></i></p>")
      $(".phoneLook").click(function (){
        yaCounter38127950.reachGoal('phone');
        $(".phoneLook").html("<p class='text-center phoneButton'>+7 (701) 443-4554 <i class='fa fa-eye' aria-hidden='true'></i></p>");
      })

      // Pain slide swap button highlight to orange color
      $('img.swap1').hover(function (){ this.src = 'img/slider/left_o.png';
      }, function (){ this.src = 'img/slider/left.png'; });
      $('img.swap2').hover(function (){ this.src = 'img/slider/right_o.png';
      }, function (){ this.src = 'img/slider/right.png'; });

      // Parallax effect slide
      $(".menu").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href');
          if (id == "#painSection") {
            var top = $(id).offset().top;
          }else{
            var top = $(id).offset().top - 49;
          }
        $('body,html').animate({scrollTop: top}, 500);
      });

      // Timer for offer section
      var all_second = <?php echo $all_second; ?>;
      var second = 0;
      var minute = 0;
      var hour = 0;

      window.setInterval(function(){
        hour = (all_second - (all_second % 3600)) / 3600;
        second = ((all_second - (hour * 3600)) % 60);
        minute =  (all_second - (hour * 3600) - second) / 60;

        if (hour < 10) {hour = "0"+hour;}
        if (minute < 10) {minute = "0"+minute;}
        if (second < 10) {second = "0"+second;}

        $(".hour").html(hour);
        $(".minutes").html(minute);
        $(".seconds").html(second);
        all_second -= 1;
      }, 1000);

      // Choose pack of education
      function choose(num){
        if (num == 1) {
          if ($('.checks1').is(':visible')){

            var link = 'register.php?id=1'

            if($("#checks1_1").prop('checked')) {
              link += "&check1=true"
            }else{
              link += "&check1=false"
            }
            if($("#checks1_2").prop('checked')) {
              link += "&check2=true"
            }else{
              link += "&check2=false"
            }
            if($("#checks1_3").prop('checked')) {
              link += "&check3=true"
            }else{
              link += "&check3=false"
            }

            window.location.href = link;

          }else{
            $(".checks1").slideDown( "slow", function() { });
            $(".chooseButton1").html("ПРИОБРЕСТИ");
            $(".checks2").slideUp( "slow", function() { });
            $(".chooseButton2").html("ПОЛУЧИТЬ ДОСТУП");
            $(".checks3").slideUp( "slow", function() { });
            $(".chooseButton3").html("ПОЛУЧИТЬ ДОСТУП");
          }
        }else if (num == 2) {
          if ($('.checks2').is(':visible')){

            var link = 'register.php?id=2'

            if($("#checks2_1").prop('checked')) {
              link += "&check1=true"
            }else{
              link += "&check1=false"
            }
            if($("#checks2_2").prop('checked')) {
              link += "&check2=true"
            }else{
              link += "&check2=false"
            }
            if($("#checks2_3").prop('checked')) {
              link += "&check3=true"
            }else{
              link += "&check3=false"
            }

            window.location.href = link;

          }else{
            $(".checks1").slideUp( "slow", function() { });
            $(".chooseButton1").html("ПОЛУЧИТЬ ДОСТУП");
            $(".checks2").slideDown( "slow", function() { });
            $(".chooseButton2").html("ПРИОБРЕСТИ");
            $(".checks3").slideUp( "slow", function() { });
            $(".chooseButton3").html("ПОЛУЧИТЬ ДОСТУП");
          }
        }else{
          if ($('.checks3').is(':visible')){

            var link = 'register.php?id=3'

            if($("#checks3_1").prop('checked')) {
              link += "&check1=true"
            }else{
              link += "&check1=false"
            }
            if($("#checks3_2").prop('checked')) {
              link += "&check2=true"
            }else{
              link += "&check2=false"
            }
            if($("#checks3_3").prop('checked')) {
              link += "&check3=true"
            }else{
              link += "&check3=false"
            }

            window.location.href = link;

          }else{
            $(".checks1").slideUp( "slow", function() { });
            $(".chooseButton1").html("ПОЛУЧИТЬ ДОСТУП");
            $(".checks2").slideUp( "slow", function() { });
            $(".chooseButton2").html("ПОЛУЧИТЬ ДОСТУП");
            $(".checks3").slideDown( "slow", function() { });
            $(".chooseButton3").html("ПРИОБРЕСТИ");
          }
        }
      }
      // Choose checkboxs for education packs
      var span1 = 23500;
      var span1_1 = 4900;
      $('.checks1 :checkbox').click(function() {
          var $this = $(this);
          if ($this.is(':checked')) {
            if($this.attr('id') == "checks1_1"){
              span1 = span1 + 5000;
              span1_1 = span1_1 + 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }else if($this.attr('id') == "checks1_2"){
              span1 = span1 + 5000;
              span1_1 = span1_1 + 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }else if($this.attr('id') == "checks1_3"){
              span1 = span1 + 5000;
              span1_1 = span1_1 + 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }
          } else {
            if($this.attr('id') == "checks1_1"){
              span1 = span1 - 5000;
              span1_1 = span1_1 - 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }else if($this.attr('id') == "checks1_2"){
              span1 = span1 - 5000;
              span1_1 = span1_1 - 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }else if($this.attr('id') == "checks1_3"){
              span1 = span1 - 5000;
              span1_1 = span1_1 - 5000;
              $('.first .span1').html( span1 );
              $('.first .span1_1').html( span1_1 );
            }
          }
      });

      var span2 = 32500;
      var span2_1 = 9900;
      $('.checks2 :checkbox').click(function() {
          var $this = $(this);
          if ($this.is(':checked')) {
            if($this.attr('id') == "checks2_1"){
              span2 = span2 + 5000;
              span2_1 = span2_1 + 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }else if($this.attr('id') == "checks2_2"){
              span2 = span2 + 5000;
              span2_1 = span2_1 + 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }else if($this.attr('id') == "checks2_3"){
              span2 = span2 + 5000;
              span2_1 = span2_1 + 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }
          } else {
            if($this.attr('id') == "checks2_1"){
              span2 = span2 - 5000;
              span2_1 = span2_1 - 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }else if($this.attr('id') == "checks2_2"){
              span2 = span2 - 5000;
              span2_1 = span2_1 - 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }else if($this.attr('id') == "checks2_3"){
              span2 = span2 - 5000;
              span2_1 = span2_1 - 5000;
              $('.second .span2').html( span2 );
              $('.second .span2_1').html( span2_1 );
            }
          }
      });


      var span3 = 43500;
      var span3_1 = 14900;
      $('.checks3 :checkbox').click(function() {
          var $this = $(this);
          if ($this.is(':checked')) {
            if($this.attr('id') == "checks3_1"){
              span3 = span3 + 5000;
              span3_1 = span3_1 + 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }else if($this.attr('id') == "checks3_2"){
              span3 = span3 + 5000;
              span3_1 = span3_1 + 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }else if($this.attr('id') == "checks3_3"){
              span3 = span3 + 5000;
              span3_1 = span3_1 + 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }
          } else {
            if($this.attr('id') == "checks3_1"){
              span3 = span3 - 5000;
              span3_1 = span3_1 - 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }else if($this.attr('id') == "checks3_2"){
              span3 = span3 - 5000;
              span3_1 = span3_1 - 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }else if($this.attr('id') == "checks3_3"){
              span3 = span3 - 5000;
              span3_1 = span3_1 - 5000;
              $('.third .span3').html( span3 );
              $('.third .span3_1').html( span3_1 );
            }
          }
      });

    </script>

    <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1839276229684359', {
em: 'insert_email_variable,'
});
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1839276229684359&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->

   <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter38127950 = new Ya.Metrika({
                        id:38127950,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");


    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/38127950" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
<script>
function spoilerClicked()
{
let x = document.getElementsByClassName("spoiler_content");
x[0].style.display = "block"

/*
if (x.style.display === "none")
{
  x.style.display = "block";
}
else
{
  x.style.display = "none";
}
*/
};
console.log('asdasdasdasdas')
</script>
  </div>
  </body>
</html>
