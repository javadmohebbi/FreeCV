<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Installation extends Model
{
    protected $table = 'installations';

    protected $fillable = ['finished'];


    public static function setEnvironmentValue($envKey, $envValue)
    {
        try{
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);

            $oldValue = strtok($str, "{$envKey}=");

            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

            $fp = fopen($envFile, 'w');
            fwrite($fp, $str);
            fclose($fp);

            return true;

        } catch (Exception $exception) {
            return false;
        }

    }


}
