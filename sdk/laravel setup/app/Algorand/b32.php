<?php
namespace App\Algorand;

class b32 {

    const  ALBT = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=';

    const  B2HEXP = '/[^A-Z2-7]/';

    const  MAPP = ['=' => 0b00000,'A' => 0b00000,'B' => 0b00001,'C' => 0b00010,'D' => 0b00011,'E' => 0b00100,'F' => 0b00101,'G' => 0b00110,'H' => 0b00111,'I' => 0b01000,'J' => 0b01001,'K' => 0b01010,'L' => 0b01011,'M' => 0b01100,'N' => 0b01101,'O' => 0b01110,'P' => 0b01111,'Q' => 0b10000,'R' => 0b10001,'S' => 0b10010,'T' => 0b10011,'U' => 0b10100,'V' => 0b10101,'W' => 0b10110,'X' => 0b10111,'Y' => 0b11000,'Z' => 0b11001,'2' => 0b11010,'3' => 0b11011,'4' => 0b11100,'5' => 0b11101,'6' => 0b11110,'7' => 0b11111,];

    public static function encode($string) {

        if ('' === $string) { return '';  }

        $encoded = '';

        $n = $bitLen = $val = 0;

        $len = strlen($string);

        $string .= str_repeat(chr(0), 4);

        $chars = (array) unpack('C*', $string, 0);

        while ($n < $len || 0 !== $bitLen) {

            if ($bitLen < 5) { $val = $val << 8;   $bitLen += 8; $n++; $val += $chars[$n]; }

            $shift = $bitLen - 5; $encoded .= ($n - (int)($bitLen > 8) > $len && 0 == $val) ? '=' : static::ALBT[$val >> $shift]; $val = $val & ((1 << $shift) - 1); $bitLen -= 5;

        }

        return $encoded;
    }

    public static function decode($base32String) {

        $base32String = strtoupper($base32String); $base32String = preg_replace(static::B2HEXP, '', $base32String);

        if ('' === $base32String || null === $base32String) { return ''; }

        $decoded = ''; $len = strlen($base32String); $n = 0; $bitLen = 5; $val = static::MAPP[$base32String[0]];

        while ($n < $len) {

            if ($bitLen < 8) { $val = $val << 5; $bitLen += 5; $n++; $pentet = $base32String[$n] ?? '=';

                if ('=' === $pentet) { $n = $len; }

                $val += static::MAPP[$pentet];

                continue;

            }

            $shift = $bitLen - 8; $decoded .= chr($val >> $shift); $val = $val & ((1 << $shift) - 1); $bitLen -= 8;

        }
        return $decoded;
    }
}
?>
