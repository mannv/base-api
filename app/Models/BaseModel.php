<?php

namespace App\Models;

use App\Providers\LoggerServiceProvider;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function createRecord($data = [])
    {
        try {
            return self::create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function updateRecord($data = [], $options = [])
    {
        try {
            return self::update($data, $options);
        } catch (\Exception $ex) {
            self::errorLog('Update record fail: ' . $ex->getMessage());
            return false;
        }
    }

    public static function deleteRecord($options = [])
    {
        try {
            return self::fill($options)->delete();
        } catch (\Exception $ex) {
            self::errorLog('Delete record fail: ' . $ex->getMessage());
            return false;
        }
    }

    public static function getDetail($id)
    {
        try {
            return self::findOrFail($id);
        } catch (\Exception $ex) {
            self::errorLog('get detail record fail: ' . $ex->getMessage());
            return false;
        }
    }

    public static function insertMultiRecord($values = [])
    {
        try {
            return self::insert($values);
        } catch (\Exception $ex) {
            self::errorLog('insert multi record fail: ' . $ex->getMessage());
            return false;
        }
    }

    public static function errorLog($message) {
        $logger = new LoggerServiceProvider();
        $logger->setClassIndex(4);
        $logger->error($message);
    }
}