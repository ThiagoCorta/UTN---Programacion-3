<?php

class Response {
    public static $res;
    public static function constructResponse($status, $body){
        self::$res = new stdClass();
        self::$res->status = $status;
        self::$res->body = $body;
        return json_encode(self::$res);
    }

}