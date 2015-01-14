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
        $this->mail->to($email);
        $this->mail->replyTo("neo.yoshiaki.sugimoto@gmail.com");
        $this->mail->subject("[likeapinboard.com] Registration Completed");
        $this->mail->from("noreply@likeapinboard.com");
        $this->mail->fromName("likeapinboard.com");
        $url = page_link("singin");

        $body = <<<END
Hi, {$name}.

Thanks for registration. Please singin below url:
{$url}

Enjoy!

likeapinboard.com====================
END;
        $this->mail->body($body);

        return $this->mail->send();
    }

    public function sendActivationMail($email, $activationCode)
    {
        $this->mail->to($email);
        $this->mail->replyTo("neo.yoshiaki.sugimoto@gmail.com");
        $this->mail->subject("[likeapinboard.com] Activaion Mail");
        $this->mail->from("noreply@likeapinboard.com");
        $this->mail->fromName("likeapinboard.com");
        $url = page_link("activate/verify?code=" . $activationCode);

        $body = <<<END
Activation Mail

Please access below url until 12 hours:
{$url}

Thanks.

likeapinboard.com====================
END;
        $this->mail->body($body);

        return $this->mail->send();
    }
}
