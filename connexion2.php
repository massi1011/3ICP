<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');
if (isset($_POST['formconnexion'])) {
    $mailconnect= htmlspecialchars($_POST['mailconnect']);
    $mdpconnect= sha1($_POST['mdpconnect']);
    if (!empty($mailconnect) AND !empty($mdpconnect)) {
        $requser= $bdd->prepare("SELECT * FROM users WHERE mail=? AND motdepasse=?");
        $requser->execute(array($mailconnect,$mdpconnect));
        $userexist= $requser->rowCount() ;
        if ($userexist==1) {
            $userinfo = $requser->fetch();
            $_SESSION['id']=$userinfo['id'];
            $_SESSION['pseudo']=$userinfo['pseudo'];
            $_SESSION['mail']=$userinfo['mail'];
            header("Location: Acceuil.php?id=".$_SESSION['id']);
           
        }else {
            $erreur ="Email ou Mot de passe incorrect .";
        }
    }
    else {
        $erreur="Tout les champs doivent etre complétés !";
    }
}
?>
<html>
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
        <style>
           
            h1{
                font-size: 30px;
                text-align: center;
                color: #fff;
                border-bottom: 3px solid #60a3bc;
                display: inline;
                text-decoration: none;
            }
            input{
                height: 30px;
                width: 100%;
                border-radius: 5px;
                border: 2px solid #60a3bc;
                outline: 0;
                transition: all 0.2s ease-in-out;
                padding-left: 10px;
                font-size: 16px;
                margin-bottom: 10px;
            }
            label{
                color: #fff;
                font-size: 20px;
            }
            .submit_btn{
                color: #fff;
                text-decoration: none;
                padding: 5px 20px;
                background: #60a3bc;
                transition: all 0.3 ease-in-out;
                font-weight: 500;
                
            }
            .submit_btn:hover{
                color: #60a3bc;
                background: transparent;
                cursor: pointer;
            }

            .title_site{
                color: #fff ;
                font-size: 45px;
                font-family: 'Pacifico', cursive;
             }
            .btn_retour{
                color: #fff;
                text-decoration: none;
                padding: 5px 20px;
                background: #60a3bc;
                border-radius: 4px;
                font-size: large;
                border: 2px solid #60a3bc;
                font-weight: 500;
                transition: all 0.3 ease-in-out;
                
                
            }
            .btn_retour:hover{
                color: #60a3bc;
                background: transparent;
                cursor: pointer;
            }

            body{
                background: url('https://c.pxhere.com/photos/39/47/cube_eyes_fall-1405107.jpg!d') center no-repeat;
                width: 100%;
                height: 100%;
                position: absolute;
                top :0;
                left :0;
                background-size:cover;
                opacity: 1;
            }
            .container {
                width: 80%;
                margin: auto; 
                position: relative;
                z-index: 999;
                align-items: center;
            }
        </style>
    </head>
    <body > 
       
        <div class="container">
        <h1 class="title_site">L'Ordre des Dés</h1>
        <div  align="center">
            <h1>Connexion</h1>
            <br /><br /><br />
            <form method="POST" action="">
                <table>
                    <tr>
                                <td align="right">
                                    <label for="mailconnect">Email:</label>
                                </td>
                                <td>
                                    <input type="email" placeholder="Votre Email" id="mailconnect" name="mailconnect" >
                                </td>
                    </tr>
                    <tr>
                                <td align="right">
                                    <label for="mdpconnect">Mot de passe:</label>
                                </td>
                                <td>
                                    <input type="password" placeholder="Votre mot de passe" id="mdpconnect" name="mdpconnect">
                                </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                        <br />    
                            <input class="submit_btn" type="submit" name="formconnexion" value ="Se connecter">
                        </td>
                    </tr>
                    <tr>
                    <td></td>
                        <td align="center"> 
                            <br />
                            <a href="http://localhost:8888/3ICP/PFE/inscription2.php" class="btn_retour">Retour</a>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                if (isset($erreur)) {
                    echo '<font color= "red">' .$erreur."</font>";
                }
            ?>
        </div>
        </div>
        
    </body>



</html> 