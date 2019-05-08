<?php
namespace GeekDC\Sensitive\Facades;
use Illuminate\Support\Facades\Facade;
class Sensitive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sensitive';
    }
}