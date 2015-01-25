<?php

class PinModel extends SZ_Kennel
{
    protected $db;

    protected $table = "pb_urls";
    protected $tag   = "pb_tags";

    public function getRecentPins($userID, $tag = FALSE, $limit = 20, $offset = 0)
    {
        $records   = array();

        $sql = "SELECT "
                .   "DISTINCT U.id, "
                .   "U.title, "
                .   "U.url, "
                .   "U.created_at "
                . "FROM "
                .   $this->table . " AS U "
                ;
        $where = array();
        if ( $tag )
        {
            $sql .= "JOIN " . $this->tag . " AS T ON ("
                    .   "U.id = T.url_id "
                    .") "
                    ;
        }

        $sql .= "WHERE "
                .   "user_id = ? ";
        $where[] = $userID;
        if ( $tag )
        {
            $sql .= "AND T.name LIKE ? ";
            $where[] = "%{$tag}%";
        }

        $sql .= "ORDER BY id DESC "
                ."LIMIT ? "
                ."OFFSET ? "
                ;
        $where[] = (int)$limit;
        $where[] = (int)$offset;

        $query = $this->db->query($sql, $where);
        if ( $query )
        {
            $records = array_map(function($row) {
                $row->tags = $this->getTagsByID($row->id);
                return $row;
            }, $query->result());
        }

        return $records;
    }

    public function getTotalPins($userID, $tag = FALSE)
    {
        $records   = array();

        $sql = "SELECT "
                .   "DISTINCT U.id "
                . "FROM "
                .   $this->table . " AS U "
                ;
        $where = array();
        if ( $tag )
        {
            $sql .= "JOIN " . $this->tag . " AS T ON ("
                    .   "U.id = T.url_id "
                    .") "
                    ;
        }

        $sql .= "WHERE "
                .   "user_id = ? ";
        $where[] = $userID;
        if ( $tag )
        {
            $sql .= "AND T.name LIKE ? ";
            $where[] = "%{$tag}%";
        }

        $query = $this->db->query($sql, $where);
        return count($query->result());
    }

    public function getTagsByID($urlID)
    {
        $sql = "SELECT "
                .   "name "
                . "FROM "
                .   $this->tag . " "
                . "WHERE "
                .   "url_id = ?"
                ;

        $query = $this->db->query($sql, array((int)$urlID));
        return ( $query->numRows() > 0 ) ? $query->result() : array();
    }

    public function getRecentTags($userID)
    {
        $sql = "SELECT "
               // .   "(SELECT "
               // .       "COUNT(name) "
               // .   "FROM "
               // .       $this->tag . " as CT "
               // .   "WHERE "
               // .       "CT.name = T.name "
               // .   "LIMIT 1) as cnt, "
                .   "T.name "
                . "FROM "
                .   $this->tag . " as T "
                . "JOIN " . $this->table . " as P ON ( "
                .   "T.url_id = P.id "
                . ") "
                . "WHERE "
                .   "P.user_id = ? "
                . "GROUP BY T.name "
                . "ORDER BY P.created_at DESC"
                //. "ORDER BY cnt DESC"
                ;

        $query = $this->db->query($sql, array($userID));
        return $query->result();
    }

}

