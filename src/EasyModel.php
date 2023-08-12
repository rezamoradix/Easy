<?php

namespace Rey\Easy;

/**
 * EasyModel
 */
trait EasyModel
{
    protected static $instance = null;
    
    /**
     * instance
     *
     * @return static
     */
    public static function instance()
    {
        return self::$instance ?? (self::$instance = new self);
    }

    /**
     * short instance
     *
     * @return static
     */
    public static function i()
    {
        return self::instance();
    }

    // static methods
    public static function fetch($id)
    {
        return self::instance()->where('id', $id)->first();
    }

    public static function fetchObject($id)
    {
        return self::instance()->where('id', $id)->get()->getRowObject();
    }

    public static function fetchByUUID($uuid)
    {
        return self::instance()->where('uuid', $uuid)->first();
    }

    public static function getAll()
    {
        return self::instance()->findAll();
    }

    public static function getAllObject()
    {
        return self::instance()->get()->getResult();
    }

    public static function deleteById($id)
    {
        return self::instance()->delete($id);
    }

    public function existsBy(array $filters)
    {
        return $this->where($filters)->countAllResults() > 0;
    }



    // static methods: insert, update, delete

    public static function put($data)
    {
        return self::instance()->insert($data);
    }
    


    // Specific methods
    public function findByPermalink($permalink)
    {
        return $this->where('permalink', $permalink)->first();
    }

    public function ofUser($user_id)
    {
        return $this->where('user_id', $user_id)->find();
    }

    public function ofUserLatest($user_id)
    {
        return $this->where('user_id', $user_id)->latest()->find();
    }

    public function latest()
    {
        return $this->orderBy('created_at', 'DESC');
    }
}
