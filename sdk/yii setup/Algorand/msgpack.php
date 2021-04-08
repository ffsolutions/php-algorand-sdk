<?php
namespace App\Algorand;

class msgpack
{
    private const UTF8_REGEX = '/\A(?: [\x00-\x7F]++  | [\xC2-\xDF][\x80-\xBF]  |  \xE0[\xA0-\xBF][\x80-\xBF]  | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  |  \xED[\x80-\x9F][\x80-\xBF]   |  \xF0[\x90-\xBF][\x80-\xBF]{2}  | [\xF1-\xF3][\x80-\xBF]{3}   |  \xF4[\x80-\x8F][\x80-\xBF]{2} )*+\z/x';

    private $fDStrBin=true;
    private $fFStr=true;
    private $fDArrMap=true;
    private $fFArr=true;
    private $fFF32=true;
    private $tmrs = [];

    public function p($value){

        if (is_int($value)) {
            return $this->pInt($value);
        }

        if (is_string($value)) {
            if ('' === $value) {
                return $this->fFStr || $this->fDStrBin ? "\xa0" : "\xc4\x00";
            }
            if ($this->fFStr) {
                return $this->pStr($value);
            }
            if ($this->fDStrBin && preg_match(self::UTF8_REGEX, $value)) {
                return $this->pStr($value);
            }

            return $this->pBin($value);
        }

        if (is_array($value)) {

            if ([] === $value) {
                return $this->fDArrMap || $this->fFArr ? "\x90" : "\x80";
            }

            if ($this->fDArrMap) {

                if (!isset($value[0]) && !array_key_exists(0, $value)) {
                    return $this->pMap($value);
                }

                return array_values($value) === $value
                    ? $this->pArray($value)
                    : $this->pMap($value);
            }

            return $this->fFArr ? $this->pArray($value) : $this->pMap($value);
        }

        if (is_null($value)) {
            return "\xc0";
        }

        if (is_bool($value)) {
            return $value ? "\xc3" : "\xc2";
        }

        if (is_float($value)) {
            return $this->pFloat($value);
        }

        if ($this->tmrs) {
            foreach ($this->tmrs as $transformer) {
                if (!is_null($packed = $transformer->p($this, $value))) {
                    return $packed;
                }
            }
        }

        if ($value instanceof Ext) {
            return $this->pExt($value->type, $value->data);
        }
    }

    public function pNil(){
        return "\xc0";
    }

    public function pBool($bool){
        return $bool ? "\xc3" : "\xc2";
    }

    public function pInt($int){

        if ($int >= 0) {

            if ($int <= 0x7f) {
                return chr($int);
            }

            if ($int <= 0xff) {
                return "\xcc".chr($int);
            }

            if ($int <= 0xffff) {
                return "\xcd".chr($int >> 8).chr($int);
            }

            if ($int <= 0xffffffff) {
                return pack('CN', 0xce, $int);
            }

            return pack('CJ', 0xcf, $int);
        }

        if ($int >= -0x20) {
            return chr(0xe0 | $int);
        }

        if ($int >= -0x80) {
            return "\xd0".chr($int);
        }

        if ($int >= -0x8000) {
            return "\xd1".chr($int >> 8).chr($int);
        }

        if ($int >= -0x80000000) {
            return pack('CN', 0xd2, $int);
        }

        return pack('CJ', 0xd3, $int);
    }

    public function pFloat($float){
        return $this->fFF32
            ? "\xca".pack('G', $float)
            : "\xcb".pack('E', $float);
    }

    public function pFloat32($float){
        return "\xca".pack('G', $float);
    }

    public function pFloat64($float){
        return "\xcb".pack('E', $float);
    }

    public function pStr($str){
        $length = strlen($str);

        if ($length < 32) {
            return chr(0xa0 | $length).$str;
        }

        if ($length <= 0xff) {
            return "\xd9".chr($length).$str;
        }

        if ($length <= 0xffff) {
            return "\xda".chr($length >> 8).chr($length).$str;
        }

        return pack('CN', 0xdb, $length).$str;

    }

    public function pBin($str){

        $length = strlen($str);

        if ($length <= 0xff) {
            return "\xc4".\chr($length).$str;
        }

        if ($length <= 0xffff) {
            return "\xc5".chr($length >> 8).chr($length).$str;
        }

        return pack('CN', 0xc6, $length).$str;

    }

    public function pArray($array){

        $data = $this->pArrayHeader(count($array));

        foreach ($array as $val) {
            $data .= $this->p($val);
        }

        return $data;

    }

    public function pArrayHeader($size){

        if ($size <= 0xf) {

            return chr(0x90 | $size);

        }

        if ($size <= 0xffff) {

            return "\xdc".chr($size >> 8).chr($size);

        }

        return pack('CN', 0xdd, $size);

    }

    public function pMap($map){
        $data = $this->pMapHeader(count($map));

        if ($this->fFStr) {

            foreach ($map as $key => $val) {

                $data .= is_string($key) ? $this->pStr($key) : $this->pInt($key);
                $data .= $this->p($val);

            }

            return $data;
        }

        if ($this->fDStrBin) {
            foreach ($map as $key => $val) {

                $data .= is_string($key)
                    ? (preg_match(self::UTF8_REGEX, $key) ? $this->pStr($key) : $this->pBin($key))
                    : $this->pInt($key);

                $data .= $this->p($val);
            }

            return $data;
        }

        foreach ($map as $key => $val) {

            $data .= is_string($key) ? $this->pBin($key) : $this->pInt($key);

            $data .= $this->p($val);
        }

        return $data;
    }

    public function pMapHeader($size){

        if ($size <= 0xf) {

            return chr(0x80 | $size);

        }

        if ($size <= 0xffff) {

            return "\xde".chr($size >> 8).chr($size);

        }

        return pack('CN', 0xdf, $size);

    }

    public function pExt($type, $data){

        $length = strlen($data);

        switch ($length) {

            case 1: return "\xd4".chr($type).$data;
            case 2: return "\xd5".chr($type).$data;
            case 4: return "\xd6".chr($type).$data;
            case 8: return "\xd7".chr($type).$data;
            case 16: return "\xd8".chr($type).$data;

        }

        if ($length <= 0xff) {

            return "\xc7".chr($length).chr($type).$data;

        }

        if ($length <= 0xffff) {

            return pack('CnC', 0xc8, $length, $type).$data;

        }

        return pack('CNC', 0xc9, $length, $type).$data;
    }
}
?>
