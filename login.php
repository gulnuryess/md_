<?php 
session_start();

if(isset($_SESSION['pay'])){
  Header("Location: library");
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
    <link rel="stylesheet/less" type="text/css" href="style/style.less">
    <script src="js/less.min.js" type="text/javascript"></script>

    <!-- JS -->
    <script src="js/sweetalert/dist/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="js/sweetalert/dist/sweetalert.css">

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
              <a class="phoneLookHref" href="index.php?#packetsSection">
                <p class='text-center phoneButton phoneButtonactive'>РЕГИСТРАЦИЯ <i class='fa fa-sign-in' aria-hidden='true'></i></p>
              </a>
          </div>
        </div>
        
      </div>

      </div>
    </div>
    <!-- /SECTION HEADER -->

    <div class="container-fluid" id="loginSection">
      <div class="container_my">

        <div class="content">

          <div class="row">
            <div class="form login">
              <div class="text-center head">
                <p>ВХОД В СИСТЕМУ</p>
                <p>НАЧНИТЕ УЧИТЬСЯ ПРЯМО СЕЙЧАС</p>
              </div>
              <form>
                <input type="email" id="email" name="email" placeholder="ЭЛ. ПОЧТА"><br>
                <input type="password" id="password" name="password" class="password" placeholder="ПАРОЛЬ"><br>
                <p class="button text-center" onclick="login();">ВОЙТИ</p>
              </form>
            </div>
          </div>
          
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

      function login(){

        var email = $("#email").val();
        var password = $("#password").val();

        if (!isEmail(email)) {
          swal("Упс!", "Введите действительную почту", "error");
        }else if ( $("#password").val().length < 6 || $("#password").val().length > 20 ) {
            swal("Упс", "Пароль должен содержать не менее 6 символов, но и не более 20.", "error");
        }else{
          var postForm = {
            'email'     : email,
            'password'  : password
          };
          $.ajax({ //Process the form using $.ajax()
              type      : 'POST', //Method type
              url       : 'library/php/login.php', //Your form processing file URL
              data      : postForm, //Forms name
              crossDomain: true,
              dataType  : 'text',
              success: function(msg) {
                if(msg == "no_user"){

                  swal({   
                    title: "Аккаут не найден",   
                    text: "Мы не смогли найти аккаунт с таким именем аккаунта и паролем",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#A5DC86", 
                    cancelButtonText: "Отмена",
                    confirmButtonText: "Пройти регистрацию",   
                    closeOnConfirm: false 
                  }, function(){
                    location.href = 'index.php#packetsSection';
                  });

                }else if(msg == 'pay'){
                  location.href = 'library/';
                }else{
                  swal("Возникла ошибка", msg +"Попробуйте еще раз", "error");
                }
              }
          });
        }

      }

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

    </script>

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

  </div>
  </body>
</html>