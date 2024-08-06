<?php
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
if(isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>L'Ordre des Dés</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/503f845b3a.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="public/css/base.css">
        <link rel="stylesheet" href="public/css/header.css">
        <link rel="stylesheet" href="public/css/articles.css">

        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

        <style>
            .header__texture{
                width: 100%;
                height: 100%;
                position: absolute;
                top :0;
                left :0;
                background: url('https://i.pinimg.com/originals/ba/31/1f/ba311fcd66de61380eb6835d2b8e6b7b.jpg') center no-repeat;
                background-size: cover;
                z-index: 1;
                opacity: 0.5;
            }
        </style>


    </head>
    <body>
        
        <div class="header">
            <div class="header__texture"></div>
            <div class="header__mask">
                <svg width="100%" height="100%" viewbox="0 0 100 100" preserveAspectRatio="none">
                  <path d="M0 100 L 0 0 C 25 100 75 100 100 0 L 100 100" fill="#fff"></path>
                </svg>
            </div>
           <div class="container">
                <div class="header__navbar">
                    <div class="header__navbar_logo">
                        <h1 class="header__navbar_logo_title">L'ordre des dés  </h1>
                    </div>
                <div class="header__navbar_menu">
                    <a href="" class="header__navbar_menu_link"><i class="fas fa-home"></i>Acceuil</a>
                    <a href="#articles_title" class="header__navbar_menu_link"><i class="fas fa-newspaper"></i>Decouvrir</a>
                    <a href="#contact_title" class="header__navbar_menu_link">Admin</a>
                    <a href="http://localhost:8888/3ICP/PFE/deconnexion.php"  class="header__navbar_menu_link"><i class="fas fa-user-plus"></i>Deconnexion</a> 
       
                    
                </div>
                    <div class="header__navbar_toggle">
                        <span class="header__navbar_toggle_icons"></span>
                    </div>
                </div>
                    <div class="header__slogan">
                        <h1 class="header__slogan_title">

                            <span>Testez votre chance </span><br>
                           
                            
                        </h1>
                        <a href="mailto:massi1011@gmail.com" class="header__slogan_btn"><i class="fa fa-envelope-o" aria-hidden="true"></i>Contactez-nous</a>
                    </div>
                </div>
            </div>
        </div>  
        <div class="container">
            <div class="articles">
            
                <h2 id="bienvenue">Description</h2>
                <p class="intro">Ce jeu est un prototype ! C'est un jeu de lancé de dés c'est à dire un jeu du hasard , testez votre chance et jouez à deux. <br> Si vous voulez etre administrateur de votre partie allez dans votre profil et vous pourrez configurer votre partie comme bon vous semble! </p>
            
                            
                <h2 id="articles_title">Jouer à deux</h2>
                <div class="articles_items">
                    <a href="http://localhost:8888/3ICP/jeu" class="article"  style="background: url('https://c.pxhere.com/photos/39/47/cube_eyes_fall-1405107.jpg!d');background-size: cover;">
                        <div class="article_filtre"></div>
                        <div class="article_name"> PLAY</div>
                        <div class="article_icon"><i class="fas fa-play"></i></div>
                    </a>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <h2 id="contact_title">Contact</h2>
                <p class="intro">Contactez nous pour plus de renseignements.</p>
                <div class="contact">
                    
                    <a href="tel:0032466092511" class="contact_link"><i class="fa fa-phone" aria-hidden="true"></i> Appeler</a>
                    
                    
                </div>
                <h2 id="contact_title">Administration</h2>
                <p class="intro"> Configurez une partie en nombre de joueurs, de dés , de parties et le temps d'attente .</p>
                <div class="contact">
                    
                    <a href="http://127.0.0.1:5000/admin" class="contact_link"> Configurer</a>
                    </div>
                <h2 id="final_title">Disgned by Remidi Massinissa</h2>
             </div>
        </div>
        <script   
        src="https://code.jquery.com/jquery-3.5.1.min.js"   
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="   
        crossorigin="anonymous"></script>
        <script src="public/js/app.js"></script>
        
        
    </body>
</html>
<?php
}
else{
    header("location:inscription2.php");
}
?>