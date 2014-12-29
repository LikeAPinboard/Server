<?php

class MailModel extends SZ_Kennel
{
    protected $db;
    protected $mail;

    public function __construct()
    {
        $this->mail = Seezoo::$Importer->library("mail");
    }


    public function sendActivationSuccessMail($name, $email)
    {
        // TODO: implement
    }

    public function sendActivationMail($email, $activationCode)
    {
        $this->mail->to($email);
        $this->mail->replayTo("neo.yoshiaki.sugimoto@gmail.com");
        $this->mail->subject("[likeapinboard.com] Activaion Mail");
        $this->mail->from("localhost");
        $this->mail->fromName("likeapinboard.com");
        $url = page_link("activate/verify?code=" . $activationCode);

        $body = <<<END
Activation Mail

Please access url below until 12 hours:
{{$url}}

Thanks.
END;
        $this->mail->body($body);

        return $this->mail->send();

        // TODO: implement
    }
}
