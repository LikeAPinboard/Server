<?php

class CronModel extends SZ_Kennel
{
    protected $db;
    protected $table = "pb_cron_times";

    public function __construct()
    {
        parent::__construct();
    }

    public function getCronTimeList()
    {
        return $this->findAll();
    }
}
