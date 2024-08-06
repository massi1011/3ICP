<?php
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');

if (isset($_POST['forminscription'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']) ;
    $mdp2 = sha1($_POST['mdp2']) ;

    if (!empty($_POST['pseudo']) and  !empty($_POST['mail']) and  !empty($_POST['mail2']) and  !empty($_POST['mdp']) and  !empty($_POST['mdp2'])  ) {

        $pseudolength = strlen($pseudo);
        if ($pseudolength <= 255) {
            
                if ($mail=$mail2) {
                   
                    $reqmail = $bdd->prepare("SELECT * FROM users WHERE mail=?");
                    $reqmail->execute(array($mail));
                    $mailexist =$reqmail->rowCount();
                    if ($mailexist ==0) {
                        
                    
                        if ($mdp=$mdp2) {
                            $insertmbr = $bdd->prepare("INSERT INTO users(pseudo,mail,motdepasse) VALUES(?,?,?)");
                            $insertmbr->execute(array($pseudo, $mail , $mdp));
                            $erreur="Votre compte a bien été créé, connectez vous <a  href=\"connexion2.php\"> ici </a> ";
                        } else {
                            $erreur="Vos mots de passes ne correspondent pas .";
                        }
                    }else {
                        $erreur = "Adresse mail déja utilisée , connectez vous <a  href=\"connexion2.php\"> ici </a> ";
                    }
                           } 
                        else 
                        {
                            $erreur="Vos adresses mails ne correspondent pas .";
                        }
                
                    
        }else {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractéres ." ;
        }
    }
    else {
        $erreur = "Tout les champs doivent etre complétés !";
    }
}
?>

<html>
    <head>
        <title>Inscription</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/503f845b3a.js" crossorigin="anonymous"></script>
        <style>
            .contact_ins{
                display: flex;
                flex-direction: column;
                padding-top: 40px;
                flex-wrap: wrap;
                
            }
            .container {
                width: 80%;
                margin: auto; 
                position: relative;
                z-index: 999;
                align-items: center;
            }
           
            .contact_ins_link {
                text-decoration: none;
                font-size: 25px;
                color: #60a3bc;
            }
            
            .contact_ins_link:hover{
                transform: scale(1.1);
                display: inline;
            }
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
                background-size: cover;
                opacity: 1;
            }
             .lien_con{
                color: #fff;
                text-decoration: none;
                padding: 5px 20px;
                background: #60a3bc;
                border-radius: 4px;
                font-size: large;
                border: 2px solid #60a3bc;
                font-weight: 500;
                transition: all 0.3 ease-in-out;
                justify-content: right;
                margin-bottom: 50px;
                
            }
            .lien_con:hover{
                color: #60a3bc;
                background: transparent;
                cursor: pointer;
            }
        </style>
    </head>
    <body > 
       
       <div class="container">
        <h1 class="title_site">L'Ordre des Dés</h1><br>
        
        <div  align="center">
            <h1>Inscription</h1>
            <br /><br /><br />
            <form method="POST" action="">
                <table>
                    <tr>
                        <td align="right">
                            <label for="pseudo">Pseudo:</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mail">Email:</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre Email" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mail2">Confirmation de l'email:</label>
                        </td>
                        <td>
                            <input type="email" placeholder="votre email" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mdp">Mot de passe:</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp">
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mdp2">Confirmation du mot de passe:</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp2" name="mdp2">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                        <br />    
                            <input class="submit_btn" type="submit" name="forminscription" value ="S'inscrire">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                        <br />    
                            <a class="lien_con" href="connexion2.php">Déja membre</a>
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
        
                
                <h1>Contact</h1>
                <div class="contact_ins">
                   
                    <a class="contact_ins_link" href="tel:0561484542" class="contact_link_ins"><i class="fa fa-phone" aria-hidden="true"></i>Appeler</a><br />
                    
        </div>
            </div>
    </body>



</html> 
