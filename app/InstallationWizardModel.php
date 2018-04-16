<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class InstallationWizardModel extends Model
{
    public static function setEnvironmentValue($envKey, $envValue)
    {
        try{

            $envFile = app()->environmentFilePath();


            $str = file_get_contents($envFile);

            $oldValue = strtok($str, "{$envKey}=");

            //$str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

            $str = preg_replace('~^'.$envKey.'=.*$~m', $envKey.'='.$envValue, $str);


            //var_dump($envKey . ' => ' . $oldValue . ' => ' . $envValue);

            $fp = fopen($envFile, 'w');
            fwrite($fp, $str);
            fclose($fp);

            return true;

        } catch (Exception $exception) {

            return false;
        }

    }
}
