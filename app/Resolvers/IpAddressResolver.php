<?php
namespace App\Resolvers;

use Illuminate\Support\Facades\Request;

class IpAddressResolver implements \OwenIt\Auditing\Contracts\IpAddressResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): string
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip=$_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            $ip=$_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            $ip=$_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            $ip=$_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            $ip=$_SERVER["REMOTE_ADDR"];
        } 
        return $ip;
    }
}