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
    const EXISTS        = 0x101;
    const EXPIRED       = 0x110;

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
        // check already exists
        if ( $this->isEmailExists($email) )
        {
            return self::EXISTS;
        }

        $code = sha1(openssl_random_pseudo_bytes(32));
        $date = new DateTime();
        $date->add(DateInterval::createFromDateString("12 hours"));

        $primary = 1;
        if ( ! is_null($userID) )
        {
            if ( $this->findOne("id", array("user_id" => $userID, "primary_use" => 1)) )
            {
                $primary = 0;
            }
        }

        $insert = array(
            "user_id"         => (int)$userID,
            "email"           => $email,
            "activation_code" => $code,
            "expired_at"      => $date->format("Y-m-d H:i:s"),
            "primary_use"     => $primary
        );

        $this->db->insert($this->table, $insert);

        return $code;
    }

    /**
     * Check email is already exists
     *
     * @public
     * @param string $email
     * @return bool
     */
    public function isEmailExists($email)
    {
        $sql = "SELECT "
                .   "1 "
                ."FROM "
                .   $this->table . " "
                ."WHERE "
                .   "email = ? "
                ."AND "
                .   "is_activated = 0 "
                ."LIMIT 1";
        $query = $this->db->query($sql, array($email));

        return  ( $query->row() ) ? TRUE : FALSE;
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
        $activate = $this->getByCode($code);
        if ( ! $activate )
        {
            return self::FAILED;
        }
        else if ( $activate->is_activated > 0 )
        {
            return self::ALREADY;
        }
        else if ( (int)$activate->user_id === 0 )
        {
            return self::NEED_REGISTER;
        }

        $MailModel = Seezoo::$Importer->model("MailModel");
        $MailModel->sendActivationSuccessMail($activate->name, $activate->email);
        $this->db->update(
            $this->table,
            array("is_activated"    => 1),
            array("activation_code" => $code)
        );

        return self::SUCCESS;
    }

    /**
     * Activatin success, and update target record
     *
     * @public
     * @param int $userID,
     * @param string $activationCode
     * @return bool
     */
    public function activationSuccess($userID, $activationCode)
    {
        $date    = new DateTime();
        $updates = array(
            "is_activated" => 1,
            "user_id "     => $userID,
            "primary_use"  => 1,
            "activated_at" => $date->format("Y-m-d H:i:s")
        );

        return $this->db->update(
            $this->table,
            $updates,
            array("activation_code" => $activationCode)
        );
    }

    /**
     * Get Activation Name from activation code
     *
     * @public
     * @param string $code
     * @return mixed
     */
    public function getByCode($code)
    {
        $sql = "SELECT "
                .   "U.name, "
                .   "E.is_activated, "
                .   "E.user_id, "
                .   "E.email, "
                .   "E.expired_at "
                ."FROM "
                .   $this->table . " AS E "
                ."LEFT OUTER JOIN " . $this->user . " AS U ON ( "
                .   "E.user_id = U.id "
                .") "
                ."WHERE "
                .   "E.activation_code = ? "
                ."AND "
                .   "E.expired_at >= ? "
                ."LIMIT 1"
                ;
        $date   = new DateTime();
        $query  = $this->db->query($sql, array($code, $date->format("Y-m-d H:i:s")));
        return ( $query->row() ) ? $query->row() : NULL;
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

