 <?php
session_start();
if (!(isset($_SESSION['nom'])))
{
   $_SESSION['lien']=$_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;

}
 $UploadAvatarMessage = NULL;
 $c=$_SESSION['id'].'.png';
 $chemin='avatars/'.$c;
 $chemin_miniature='avatars/'.$_SESSION['id'].'min.png';
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                               
                                if ($_FILES['Avatar']['size'] && $_FILES['Avatar']['size'] < 1048576) {
                                    require(dirname(__FILE__) . "/src/ImageResize.class.php");
                                    $UploadAvatar  = new ImageResize('PostField', 'Avatar');
                                    $MUploadResult = $UploadAvatar->Resize(256, $chemin, 100);
                                    $LUploadResult = $UploadAvatar->Resize(48, $chemin_miniature, 100);
                                    if ($LUploadResult && $MUploadResult)
                                    {
                                        require_once 'config.php';
                                      
                                            $requete2=$bdd->prepare('UPDATE comptes SET photo=1 WHERE id=?');
                                            $requete2->execute(array($_SESSION['id']));

                                       
                                        $UploadAvatarMessage = "ok";
                                    }
                                    else
                                        $UploadAvatarMessage = 'Echec. Le fichier uploadé n\'est probablement pas une image.';
                                } else {
                                    $UploadAvatarMessage = 'Fichier non choisi ou trop volumineux.';
                                }
                            }
                            $_SESSION['erreur']=$UploadAvatarMessage;
                            $_SESSION['num_verif']=3;
                            header("Location: mon_profil.php");
                            exit;

                            ?>