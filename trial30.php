<?php
session_start();

if(isset($_SESSION['pay'])){
  Header("Location: library");
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

$pack_name = 'ВАГОН ЗНАНИИ';
$pack_desk = '<li>Видеоурок теория "Бухгалтер-оператор"</li>
              <li>Видеоурок практика "Бухгалтер-оператор"</li>
              <li>Видеоурок "Онлайн банкинг (5 банков)"</li>
              <li>Видеоурок "Разбор кейсов"</li>
              <li>Шести месячная поддержка учеников</li>
              <li>База ответов</li>
              <li>Домашнее задание</li>
              <li>Тестирование</li>';
$pack_style = 'third';
$price = 28500;

$checks1 = true;
$checks2 = true;
$checks3 = true;

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
    <link rel="stylesheet/less" type="text/css" href="style/style.less">
    <script src="js/less.min.js" type="text/javascript"></script>

    <!-- JS -->
    <script src="js/sweetalert/dist/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="js/sweetalert/dist/sweetalert.css">
    <script src="https://widget.cloudpayments.kz/bundles/cloudpayments"></script>

  </head>
  <body>
  <div id="wrapper">

    <!-- SECTION HEADER -->
    <div class="container-fluid" id="headerSection">
      <div class="container_my">

      <div class="content">

        <div class="row">
          <div class="col-sm-6 logo">
            <a href="index.php">
              <p class="logoName">MD</p>
              <p class="logoType">STUDY</p>
              <p class="logoSlogan">ПРОГРЕССИВНЫЕ БУХГАЛТЕРСКИЕ<br>КУРСЫ ПО ВСЕМУ КАЗАХСТАНУ</p>
            </a>
          </div>
          <div class="col-sm-6 contacts menu">
            <p onclick="location.href = 'login.php';" class='text-center phoneButton phoneButtonactive'>ВОЙТИ <i class='fa fa-sign-in' aria-hidden='true'></i></p>
          </div>
        </div>
        
      </div>

      </div>
    </div>
    <!-- /SECTION HEADER -->

      <div class="container-fluid" id="registerSection">
        <div class="container_my">
        <div class="container">

          <div class="row">
            <div class="text-center head">
              <p>БЕСПЛАТНАЯ РЕГИСТРАЦИЯ ДЛЯ SDU'ШНИКОВ</p>
              <p>НАЧНИТЕ УЧИТЬСЯ ПРЯМО СЕЙЧАС</p>
            </div>
            <div class="packets text-center">
              <div class="col-sm-12">
                <p class="title text-left"><span class="active">1</span><span>2</span><span>3</span>Ваш багаж знании</p>
              </div>
              <div class="col-sm-4 col-sm-offset-4 <?php echo $pack_style ?>">
                <div class="panel panel-default">
                  <div class="panel-heading"><?php echo $pack_name ?></div>
                  <div class="panel-body">
                    <center><img src="img/packets/<?php echo $pack_style ?>.svg"></center>
                    <ul><?php echo $pack_desk ?></ul>
                    <div class="checks1">
                      <hr>
                      <div class="checkbox">
                        <label><input type="checkbox" disabled="disabled" <?php if ($checks1){echo 'checked="checked"'; } ?> >Сертификат</label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" disabled="disabled" <?php if ($checks2){echo 'checked="checked"'; } ?> >Консультация по почте</label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" disabled="disabled" <?php if ($checks3){echo 'checked="checked"'; } ?> >Шаблоны первичных документов</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="footer menu">
                  <p class="p_first">(вместо <span><span class="span1"><?php echo $price + 4000 ?>тг</span></span>)</p>
                  <p class="p_second"><span class="span1_1"><?php echo $price ?></span> <img src="img/tg_<?php echo $pack_style ?>.png"></p>
                  <p>до <?php echo (new DateTime('+1 day'))->format('d') . " " . $rus_month; ?></p>
                  <a id="packetButton" href="#infoSection"><p class="button packetButton">ПОДТВЕРДИТЬ</p></a>
                  <a href="index.php?#packetsSection" class="btnhref"><p>ВЫБРАТЬ ДРУГОЙ ПАКЕТ</p></a>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="row info display_none" id="infoSection">
            <div>
              <div class="col-sm-12">
                <p class="title"><span class="active">1</span><span class="active">2</span><span>3</span>Ваши данные</p>
              </div>
              <div class="col-sm-12">
                <input type="text" id="name" name="name" placeholder="ИМЯ"><br>
              </div>
              <div class="col-sm-12">
                <input type="text" id="surname" name="surname" placeholder="ФАМИЛИЯ"><br>
              </div>
              <div class="col-sm-12">
                <input type="email" id="email" name="email" placeholder="ЭЛ. ПОЧТА"><br>
              </div>
              <div class="col-sm-12">
                <input type="password" id="password" name="password" placeholder="ПАРОЛЬ"><br>
              </div>
              <div class="clear"></div>
              <br>
              <p class="text-center"><span class="button infoButton">ПОДТВЕРДИТЬ</span></p>
            </div>
          </div>

          <br>

          <div class="row pay display_none">
            <div class="col-sm-12">
              <p class="title"><span class="active">1</span><span class="active">2</span><span class="active">3</span>Оплата курса</p>
            </div>
            <div class="col-sm-12">
              <center><img class="visa" id="checkout" src="img/visa.png"></center>
            </div>
          </div>
          <br><br>
        </div>
        </div>
      </div>

    <!-- SECTION FOOTER -->
    <div class="container-fluid" id="footerSection">
      <div class="container_my">

      <div class="content">

        <div class="row">
        
          <div class="col-md-4 col-sm-6">
            <div class="logo">
              <p class="logoName">MD</p>
              <p class="logoType">STUDY</p>
              <p class="logoSlogan">ПРОГРЕССИВНЫЕ БУХГАЛТЕРСКИЕ<br>КУРСЫ ПО ВСЕМУ КАЗАХСТАНУ</p>
              <div class="clear"></div>
            </div>
            
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=XwY5PU4D4YB32GhPO-BMWUd8Rj3S8XEr&amp;width=100%&amp;height=120&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
            <p class="adress"><span>Наш офис: </span>г. Алматы, мкр. Самал-2, 58/19 | MIRUSDESK | 831216300684</p>

            <p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="https://drive.google.com/file/d/0B7nmWECPy2hQMXhxbHhFSGozbEE/view?usp=sharing" target="_blank">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a></p>
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
            <p>ЭЛЕКТРОННАЯ РАССЫЛКА</p>
            <p>Опыт | идеи | кейсы | новости | скидки | обратная связь</p>
            <p>Оставьте свою электронную почту,<br class="sm-hidden"> и будь в курсе событии</p>
            <input type="text" class="text" id="email_news" placeholder="Ваша почта:">
            <p class='button' onclick="sendData();">ПОДПИСАТЬСЯ!</p>
            <p class="copy">© 2008 — <?php echo date ( 'Y' ) ; ?> MADE WITH<img src="img/love1.gif">BY MIRUSDESK<br><a href="https://drive.google.com/file/d/0B7nmWECPy2hQMXhxbHhFSGozbEE/view?usp=sharing" target="_blank">ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</a></p>
          </div>

        </div>
        
      </div>

      </div>
    </div>
    <!-- /SECTION FOOTER -->

    <script type="text/javascript">

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

      var packetButtonBool = true;

      $(".packetButton").click(function(){
        if (packetButtonBool) {
          $(".packetButton").css('background','#777777');
          $(".info").slideDown();
          packetButtonBool = false;
        }else{
          $( "#packetButton" ).attr( "href", "#" );
        }
      })


      var infoButtonBool = true;
      $(".infoButton").click(function(){
        if (infoButtonBool) {

          if ( $("#name").val().length < 3 || $("#name").val().length > 20 ) {
            swal("Упс", "Имя посетителя должно быть не менее 3 символов, но и не более 20.", "error");
          }else if ( $("#surname").val().length < 3 || $("#surname").val().length > 20 ) {
            swal("Упс", "Фамилия посетителя должно быть не менее 3 символов, но и не более 20.", "error");
          }else if ( !isEmail( $("#email").val() ) ) {
            swal("Упс", "Пожалуйста, введите действительный адрес электронной почты", "error");
          }else if ( $("#password").val().length < 6 || $("#password").val().length > 20 ) {
            swal("Упс", "Пароль должен содержать не менее 6 символов, но и не более 20.", "error");
          }else{
            infoButtonBool = false;
            var postForm = {
              'name'     : $("#name").val(),
              'surname'  : $("#surname").val(),
              'email'    : $("#email").val(),
              'password' : $("#password").val()
            };
            $.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : 'library/php/register.php', //Your form processing file URL
                data      : postForm, //Forms name
                dataType  : 'text',
                success: function(msg) {
                  if (msg == "success") {
                    $(".pay").slideDown();
                    infoButtonBool = false;
                    $(".infoButton").css("background","#777777");
                  }else if (msg == "email"){

                    swal({   
                      title: "Упс",   
                      text: "Данная почта уже зарегестрирована у нас",   
                      type: "warning",   
                      showCancelButton: true,   
                      confirmButtonColor: "#A5DC86", 
                      cancelButtonText: "Отмена",
                      confirmButtonText: "Войти с этой почтой",   
                      closeOnConfirm: false 
                    }, function(){
                      location.href = 'login.php';
                    });

                    infoButtonBool = true;

                  }else{
                    
                    swal("Возникла ошибка", "Попробуйте еще раз немного позже. Или обратитесь в службу технической поддержке.", "error");
                    infoButtonBool = true;

                  }
                }
            });
          }

        }
      })

      function sendData() {
        var email = $("#email_news").val();
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

      var payHandler = function () {

          var postForm = {
            'email': $('#email').val(),
            'packet': 3,
            'plus1': true,
            'plus2': true,
            'plus3': true
          };

          $.ajax({ //Process the form using $.ajax()
              type      : 'POST', //Method type
              url       : 'library/php/pay.php', //Your form processing file URL
              data      : postForm, //Forms name
              crossDomain: true,
              dataType  : 'text',
              success: function(msg) {
                swal({   
                  title: "Так держать!",   
                  text: "Регистрация прошла успешно, теперь вы можете войти в систему",   
                  type: "success",   
                  showCancelButton: false,   
                  confirmButtonColor: "#A5DC86", 
                  cancelButtonText: "Отмена",
                  confirmButtonText: "Войти в систему",   
                  closeOnConfirm: false 
                }, function(){
                  location.href = 'login.php';
                });
                
              }
          });
        
      };
      $('#checkout').on("click", payHandler);

    </script>


  </div>
  </body>
</html>