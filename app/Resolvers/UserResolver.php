<?php
namespace App\Resolvers;
use Auth;


class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve()
    {
        
        return Auth::check() ? Auth::user() : null;
    }
}