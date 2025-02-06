<?php 
namespace App\Helpers;

class VoucherSingleton
{
    private static $instance;
    private $voucherId;

    private function __construct()
    {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new VoucherSingleton();
        }

        return self::$instance;
    }

    public function setVoucherId($id)
    {
        $this->voucherId = $id;
    }

    public function getVoucherId()
    {
        return $this->voucherId;
    }
}
