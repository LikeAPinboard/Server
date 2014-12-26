<?php

class ActivationModel extends SZ_Kennel implements Validatable
{
    /**
     * Autoload signature property
     */
    protected $db;

    /**
     * Model using table name
     */
    protected $table = "pb_user_emails";
    protected $user  = "pb_users";

    /**
     * Activation result status
     */
    const FAILED        = 0x001;
    const SUCCESS       = 0x010;
    const ALREADY       = 0x011;
    const NEED_REGISTER = 0x100;

    /**
     * Generate and save activation code
     *
     * @public
     * @param string $email
     * @param [,mixed $userID]
     * @return string
     */
    public function generateActivationCode($email, $userID = NULL)
    {
        $code = sha1(openssl_random_psudo_bytes(32));
        $date = new DateTime();

        $insert = array(
            "user_id"         => (int)$userID,
            "email"           => $email,
            "activation_code" => $code,
            "created_at"      => $date->format("Y-m-d H:i:s")
        );

        $this->db->insert($this->table, $insert);

        return $code;
    }

    /**
     * Do activate
     *
     * @public
     * @param string $code
     * @return int ActivationModel constants
     */
    public function activate($code)
    {
        $sql = "SELECT "
                .   "U.name, "
                .   "E.is_activted, "
                .   "E.user_id, "
                .   "E.email "
                ."FROM "
                .   $this->table . " AS E "
                ."LEFT OUTER JOIN " . $this->user . " AS U ON ( "
                .   "E.user_id = U.user_id "
                .") "
                ."WHERE "
                .   "E.activation_code = ? "
                ."LIMIT 1"
                ;
        $row = $this->db->query($sql, array($code));
        if ( ! $row )
        {
            return self::FAILED;
        }
        if ( $row->is_activated > 0 )
        {
            return self::ALREADY;
        }

        if ( (int)$row->user_id === 0 )
        {
            return self::NEED_REGISTER;
        }

        $MailModel = Seezoo::$Importer->model("MailModel");
        $MainModel->sendActivationSuccessMail($row->name, $row->email);

        return self::SUCCESS;
    }

    /**
     * Implements Validatable interface
     *
     * @public
     * @param SZ_Validation_field $field
     * @return bool
     */
    public function validate($field)
    {
        $row = $this->find("user_id", array("activation_code" => $field->getValue()));

        if ( ! $row )
        {
            $field->setMessage("Activation Error");
            return FALSE;
        }

        return TRUE;
    }
}

