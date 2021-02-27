<?php

namespace App\Helpers;

use DB;
use Exception;

class ModelIncremental
{
	protected static $sequences = ['admin', 'product', 'user'];
    /**
     * [generateIncrementId description].
     *
     * @param [type] $seqenceName [description]
     *
     * @return [type] [description]
     */
    public static function generateIncrementId($seqenceName)
    {
        if (!in_array($seqenceName, self::$sequences)) {
            throw new Exception('Model sequence does not exist.');
        }

        $increment = collect(DB::select("SELECT nextval('".$seqenceName."_sequence')"))->first();

        if (empty($increment)) {
            throw new Exception('Model sequence does not exist.');
        }

        $incrementId = $increment->nextval;

        return $incrementId;
    }
}
