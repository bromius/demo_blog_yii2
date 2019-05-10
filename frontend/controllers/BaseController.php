<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Basic controller
 */
class BaseController extends Controller
{
    /**
     * JSON output
     * 
     * @param bool $status
     * @param mixed $data
     * @return string
     */
    public static function result($status, $data = null)
    {
        return json_encode([
            'result' => $status,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
    }
}
