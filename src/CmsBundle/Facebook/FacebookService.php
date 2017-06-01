<?php
namespace CmsBundle\Facebook;


class FacebookService
{
    // Ces variables réceptionnerons nos identifiants
    private $appId;
    private $appSecret;
    private $pageID;
    private $token;
    // Cette variable contiendra notre connexion avec l’API et sera utilisé pour interagir
    private $connection;

    public function __construct($appId,$appSecret,$pageID,$token)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->pageID = $pageID;
        $this->token = $token;

        // Cette instruction nous permettra de nous connecter à l'API
        $this->connection = new \Facebook\Facebook([
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
            'default_graph_version' => 'v2.8',
        ]);

    }

    // Cette fonction permettra de poster sur notre page Facebook
    public function poster($msg, $link, $picture, $name, $caption, $description)
    {
        //cette array contendra les paramètres de notre requête, ici on se contente d'envoyer un texte, mais on pourrait envoyer également avec d'autre paramêtre un lien, une image, etc...
        $attachment = array(
            'access_token' => $this->token,
            'message' => $msg,
            "link" => $link,
            "picture" => $picture,
            "name" => $name,
            "caption" => $caption,
            "description" => $description
        );

        // on poste sur notre page Facebook
        $this->connection->post('/'.$this->pageID.'/feed', $attachment, $this->token);
    }
}


/*
 * Dans le controller nécéssaire:
 *
La methode poster prend en parametre:
1: Le message
2: Le lien sur lequel le post menera
3: La photo
4: Le nom
5: Le titre du post
6: La description du post

$this->get('app_core.facebook')->poster("Mon premier post depuis Symfony sur cette page");

*/