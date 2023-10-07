<?php


namespace App\Traits;

use Carbon\Carbon;
use phpseclib3\File\X509;
use App\Models\Client\Cev;
use ParagonIE\ConstantTime\Base32;
use ParagonIE\ConstantTime\Base64;
use Illuminate\Support\Facades\Http;
use Milon\Barcode\Facades\DNS2DFacade;
use Illuminate\Support\Facades\Validator;


trait FormatData
{
    /**
     * @param $size
     * @return int
     */
    function getLength($size)
    {
        $tailles = [
            "16" => [
                "capacite_octet" => 114,
                "taille_message_c40" => 42
            ],
            "17.6" => [
                "capacite_octet" => 144,
                "taille_message_c40" => 87
            ],
            "19.2" => [
                "capacite_octet" => 174,
                "taille_message_c40" => 132
            ],
            "20.8" => [
                "capacite_octet" => 204,
                "taille_message_c40" => 177
            ],
            "25.6" => [
                "capacite_octet" => 280,
                "taille_message_c40" => 291
            ],
            "28.8" => [
                "capacite_octet" => 368,
                "taille_message_c40" => 423
            ],
            "32" => [
                "capacite_octet" => 456,
                "taille_message_c40" => 555
            ],
            "35.2" => [
                "capacite_octet" => 576,
                "taille_message_c40" => 733
            ],
            "38.4" => [
                "capacite_octet" => 696,
                "taille_message_c40" => 915
            ],
            "41.6" => [
                "capacite_octet" => 816,
                "taille_message_c40" => 1095
            ],
            "48" => [
                "capacite_octet" => 1050,
                "taille_message_c40" => 1446
            ],
            "52.8" => [
                "capacite_octet" => 1304,
                "taille_message_c40" => 1827
            ],
            "57.6" => [
                "capacite_octet" => 1558,
                "taille_message_c40" => 2208
            ]
        ];
        if (array_key_exists($size, $tailles)) {
            $length = $tailles[$size];
            return ($length);
        } else {
            echo ("Ooops il se pourrait que la taille du code datamatrix specifie ne correspond a aucune taille disponible.");
            return false;
        }
        // $validator->fails();
    }
    public function encodeC40($input)
    {
        // Table de substitution C40
        $substitutionTable = [
            "\0" => "Λ",
            "\1" => "0",
            "\2" => "1",
            "\3" => "2",
            "\4" => "3",
            "\5" => "4",
            "\6" => "5",
            "\7" => "6",
            "\10" => "7",
            "\11" => "8",
            "\12" => "9",
            "\13" => "A",
            "\14" => "B",
            "\15" => "C",
            "\16" => "D",
            "\17" => "E",
            "\20" => "F",
            "\21" => "G",
            "\22" => "H",
            "\23" => "I",
            "\24" => "J",
            "\25" => "K",
            "\26" => "L",
            "\27" => "M",
            "\30" => "N",
            "\31" => "O",
            " " => " ",
            "!" => "!",
            "\"" => "\"",
            "#" => "#",
            "$" => "$",
            "%" => "%",
            "&" => "&",
            "'" => "'",
            "(" => "(",
            ")" => ")",
            "*" => "*",
            "+" => "+",
            "," => ",",
            "-" => "-",
            "." => ".",
            "/" => "/",
            ":" => ":",
            ";" => ";",
            "<" => "<",
            "=" => "=",
            ">" => ">",
            "?" => "?",
            "@" => "@",
            "[" => "[",
            "\\" => "\\",
            "]" => "]",
            "^" => "^",
            "_" => "_",
            "`" => "`",
            "{" => "{",
            "|" => "|",
            "}" => "}",
            "~" => "~",
            "\127" => "Æ",
            "\129" => "a",
            "\131" => "c",
            "\135" => "e",
            "\137" => "g",
            "\141" => "i",
            "\143" => "k",
            "\145" => "m",
            "\147" => "o",
            "\151" => "q",
            "\153" => "s",
            "\155" => "u",
            "\157" => "w",
            "\159" => "y",
            "\161" => "!",
            "\163" => "#",
            "\165" => "%",
            "\167" => "'",
            "\171" => "+",
            "\173" => "-",
            "\175" => "/",
            "\177" => "1",
            "\181" => "3",
            "\183" => "5",
            "\185" => "7",
            "\187" => "9",
            "\189" => ";",
            "\191" => "=",
            "\193" => "?",
            "\195" => "A",
            "\197" => "C",
            "\199" => "E",
            "\201" => "G",
            "\203" => "I",
            "\205" => "K",
            "\207" => "M",
            "\209" => "O",
            "\211" => "Q",
            "\213" => "S",
            "\215" => "U",
            "\217" => "W",
            "\219" => "Y",
            "\221" => "[",
            "\223" => "]",
            "\225" => "_",
            "\227" => "a",
            "\229" => "c",
            "\231" => "e",
            "\233" => "g",
            "\235" => "i",
            "\237" => "k",
            "\239" => "m",
            "\241" => "o",
            "\243" => "q",
            "\245" => "s",
            "\247" => "u",
            "\251" => "w",
            "\253" => "y",
            "\255" => "{",
            "\257" => "}",
            "\261" => "¡",
            "\263" => "£",
            "\265" => "¥",
            "\267" => "§",
            "\271" => "¿",
            "\273" => "À",
            "\275" => "Ä",
            "\277" => "È",
            "\301" => "Ë",
            "\303" => "Î",
            "\305" => "Ñ",
            "\307" => "Ô",
            "\311" => "Ö",
            "\313" => "Ù",
            "\315" => "Ü",
            "\317" => "ß",
            "\321" => "à",
            "\323" => "ä",
            "\325" => "è",
            "\327" => "ë",
            "\331" => "î",
            "\333" => "ñ",
            "\335" => "ô",
            "\337" => "ö",
            "\341" => "ù",
            "\343" => "ü",
            "\345" => "˘",
            "\347" => "˛",
            "\351" => "ˇ",
            "\353" => "˙",
            "\355" => "˚",
            "\357" => "˝",
            "\361" => "˛",
            "\363" => "ˇ",
            "\365" => "˙",
            "\367" => "˚",
            "\371" => "˝",
            "\373" => "˛",
            "\375" => "ˇ",
            "\377" => "˙",
            "\142" => "b",
            "\144" => "d",
            "\146" => "f",
            "\150" => "h",
            "\152" => "j",
            "\154" => "l",
            "\156" => "n",
            "\160" => "p",
            "\162" => "r",
            "\164" => "t",
            "\166" => "v",
            "\170" => "x",
            "\172" => "z",
            "\174" => "0",
            "\176" => "2",
            "\200" => "4",
            "\202" => "6",
            "\204" => "8",
            "\206" => "A",
            "\210" => "C",
            "\212" => "E",
            "\214" => "G",
            "\216" => "I",
            "\220" => "K",
            "\222" => "M",
            "\224" => "O",
            "\226" => "Q",
            "\230" => "S",
            "\232" => "U",
            "\234" => "W",
            "\236" => "Y",
            "\240" => "[",
            "\242" => "]",
            "\244" => "_",
            "\246" => "a",
            "\250" => "c",
            "\252" => "e",
            "\254" => "g",
            "\256" => "i",
            "\260" => "k",
            "\262" => "m",
            "\264" => "o",
            "\266" => "q",
            "\270" => "s",
            "\272" => "u",
            "\274" => "w",
            "\276" => "y",
            "\300" => "{",
            "\302" => "}",
            "\304" => "¡",
            "\306" => "£",
            "\310" => "¥",
            "\312" => "§",
            "\314" => "¿",
            "\316" => "À",
            "\320" => "Ä",
            "\322" => "È",
            "\324" => "Ë",
            "\326" => "Î",
            "\330" => "Ñ",
            "\332" => "Ô",
            "\334" => "Ö",
            "\336" => "Ù",
            "\340" => "Ü",
            "\342" => "ß",
            "\344" => "à",
            "\346" => "ä",
            "\350" => "è",
            "\352" => "ë",
            "\354" => "î",
            "\356" => "ñ",
            "\360" => "ô",
            "\362" => "ö",
            "\364" => "ù",
            "\366" => "ü",
            "\370" => "˘",
            "\372" => "˛",
            "\374" => "ˇ",
            "\376" => "˙",
        ];

        $encodedData = '';

        foreach (str_split($input) as $char) {
            if (array_key_exists($char, $substitutionTable)) {
                // Utiliser la substitution si le caractère est dans la table
                $encodedData .= $substitutionTable[$char];
            } elseif ($char === '<RS>') {
                // Encodage du caractère spécial <RS>
                $encodedData .= '...'; // Remplacez par le code C40 correspondant
            } elseif ($char === '<GS>') {
                // Encodage du caractère spécial <GS>
                $encodedData .= '...'; // Remplacez par le code C40 correspondant
            } elseif ($char === '<US>') {
                // Encodage du caractère spécial <US>
                $encodedData .= '...'; // Remplacez par le code C40 correspondant
            } else {
                // Utiliser le caractère directement s'il n'est pas dans la table
                $encodedData .= $char;
            }
        }

        return $encodedData;
    }
    /**
     * @param $champs
     * @return string
     */
    function trim_end($string)
    {
        return rtrim($string, " ");
    }
    function makeDiff($date)
    {
        $date = Carbon::parse($date);
        $difference = $date->diffInDays(Carbon::create(2000, 1, 1));
        return str_pad(dechex($difference), 4, '0', STR_PAD_LEFT);
        // $validator->fails();
    }

    /**
     * @param $champs
     * @return array
     */
    function getCertData($cert)
    {
        // $certString = "MIICYzCCAgmgAwIBAgIJALwJ6BLBxoymMAoGCCqGSM49BAMCMF8xCzAJBgNVBAYTAkJKMQswCQYDVQQIDAJMVDEQMA4GA1UEBwwHQ290b25vdTEUMBIGA1UECgwLUVVBTElUWUNPUlAxDDAKBgNVBAsMA0NFVjENMAsGA1UEAwwEQkowMDAeFw0yMzA5MTUwNzI1MjJaFw0yNTA5MTQwNzI1MjJaMFYxDTALBgNVBAMMBFBZSEUxGjAYBgNVBAsMEU9yZ2FuaXNhdGlvbiBVbml0MRUwEwYDVQQKDAxPcmdhbmlzYXRpb24xEjAQBgNVBAYTCXVuZGVmaW5lZDBZMBMGByqGSM49AgEGCCqGSM49AwEHA0IABHtLe9gNCnzkxTH4ItEoKYfyw0dNyrB6n7zol7BXauMqFDjrcE8yrptqlJYp88uhnbCeSQuvJoQLaLWI1+JxiyOjgbYwgbMwDgYDVR0PAQH/BAQDAgeAMB0GA1UdDgQWBBQGpTp1H1V4rwzRP3SRev5Ef1+iUzAfBgNVHSMEGDAWgBRQ18clrJ6a3XMEGcVqXImwhLNXLjAvBgNVHR8EKDAmMCSgIqAghh5odHRwOi8vY3JsLmNzYWNldi9DUkwvQ1NDQS5jcmwwMAYDVR0lBCkwJwYLKwYBBAGON49lAQEGCysGAQQBjjePZQECBgsrBgEEAY43j2UBAzAKBggqhkjOPQQDAgNIADBFAiEA0htDAbJw6u9uc6/SD4U89TvdEMty/Q1W7tscka7Uy9gCIGEvDbM1Lm57GIcm0wSszwB9LWrKmntny7SwgAjigpEAMIICYzCCAgmgAwIBAgIJALwJ6BLBxoymMAoGCCqGSM49BAMCMF8xCzAJBgNVBAYTAkJKMQswCQYDVQQIDAJMVDEQMA4GA1UEBwwHQ290b25vdTEUMBIGA1UECgwLUVVBTElUWUNPUlAxDDAKBgNVBAsMA0NFVjENMAsGA1UEAwwEQkowMDAeFw0yMzA5MTUwNzI1MjJaFw0yNTA5MTQwNzI1MjJaMFYxDTALBgNVBAMMBFBZSEUxGjAYBgNVBAsMEU9yZ2FuaXNhdGlvbiBVbml0MRUwEwYDVQQKDAxPcmdhbmlzYXRpb24xEjAQBgNVBAYTCXVuZGVmaW5lZDBZMBMGByqGSM49AgEGCCqGSM49AwEHA0IABHtLe9gNCnzkxTH4ItEoKYfyw0dNyrB6n7zol7BXauMqFDjrcE8yrptqlJYp88uhnbCeSQuvJoQLaLWI1+JxiyOjgbYwgbMwDgYDVR0PAQH/BAQDAgeAMB0GA1UdDgQWBBQGpTp1H1V4rwzRP3SRev5Ef1+iUzAfBgNVHSMEGDAWgBRQ18clrJ6a3XMEGcVqXImwhLNXLjAvBgNVHR8EKDAmMCSgIqAghh5odHRwOi8vY3JsLmNzYWNldi9DUkwvQ1NDQS5jcmwwMAYDVR0lBCkwJwYLKwYBBAGON49lAQEGCysGAQQBjjePZQECBgsrBgEEAY43j2UBAzAKBggqhkjOPQQDAgNIADBFAiEA0htDAbJw6u9uc6/SD4U89TvdEMty/Q1W7tscka7Uy9gCIGEvDbM1Lm57GIcm0wSszwB9LWrKmntny7SwgAjigpEA";
        $x509 = new X509();
        $decodedCert = $x509->loadX509($cert);
        return (["serialNumber" => $decodedCert['tbsCertificate']['subject']['rdnSequence'][0][0]['value']['utf8String'], "caId" => $decodedCert['tbsCertificate']['issuer']['rdnSequence'][5][0]['value']['utf8String']]);
    }

    /**
     * @param $champs
     * @return array
     */
    function makeEntete($data, $type, $certData)
    {

        $entete = "DC" . $data['version'] . $certData['caId'] . $certData['serialNumber'] . $this->makeDiff($data['date_emission']) . $this->makeDiff($data['date_creation']) . $type;
        // $entete = "DC" . $data['version'] . 'BJOO' . '0001' . $this->makeDiff($data['date_emission']) . $this->makeDiff($data['date_creation']) . $type;
        // echo ($entete);
        return $entete;
        // $validator->fails();
    }

    /**
     * @param $champs
     * @return array
     */
    function makePubEntete($data, $type, $certData)
    {
        $entete = "DC" . '02' . $certData['caId'] . $certData['serialNumber'] . $this->makeDiff($data['date_emission']) . $this->makeDiff($data['date_creation']) . $type;
        // $entete = "DC" . $data['version'] . 'BJOO' . '0001' . $this->makeDiff($data['date_emission']) . $this->makeDiff($data['date_creation']) . $type;
        // echo ($entete);
        return $entete;
        // $validator->fails();
    }


    /**
     * @param $champs
     * @return array
     */
    function makeMessage($data, $attributes, $length)
    {
        $obligatoires = [];
        $obligatoiresFixe = [];
        $facultatifs = [];
        $message = '';
        $sepArray = array("<GS>", "<RS>");
        $sepStrArray = array("GS", "RS");
        $obligatoiresVariables = [];
        $taille_message_c40 = $length['taille_message_c40'];
        foreach ($attributes as $key => $value) {
            if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'F') {
                if (array_key_exists($value['libelle'], $data))
                $array1 = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                else
                    $array1 = ["value" => "NA", "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($facultatifs, $array1);
            } else if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O' || $value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O*') {
                // if($value['contrainte'] !== null){
                if (array_key_exists($value['libelle'], $data))
                $array = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                else
                    $array = ["value" => "NA", "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($obligatoires, $array);
                // }
            }
        }
        $valfixes = '';
        $valvariables = '';
        foreach ($obligatoires as $key => $value) {
            if ($value['taille_max'] !== null && $value['taille_min'] !== null) {
                if ($value['taille_max'] === $value['taille_min']) {
                    // if($value['contrainte'] !== null){
                    $valfixes .= $this->trim_end($value['value']);
                    array_push($obligatoiresFixe, $value);
                    // }
                } else {
                    $valvariables .= $this->trim_end($value['value']);
                    array_push($obligatoiresVariables, $value);
                }
            }
        }
        $newLength = mb_strlen($valfixes, 'utf-8') + 2 * count($obligatoiresFixe);
        //Verifier si l'on a la possibilite d'encoder les valeurs fixes
        if ($newLength <= $taille_message_c40) {
            // echo ("equallll");
            foreach ($obligatoiresFixe as $key => $value) {
                $message .=
                    $value['code'] . strtoupper($this->trim_end($value['value']));
            }
            $nombrerestant = count($obligatoiresVariables);
            // echo ("restant" . $valvariables . "\n");
            if (mb_strlen($valvariables, 'utf-8') + 2 * count($obligatoiresVariables) > $taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) {
                echo ("Oooopppss \n");
                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager la qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
            } else {
                // echo ("Encodage restant \n");
                echo (mb_strlen(str_replace($sepArray, $sepStrArray, $message)) . "   " . $taille_message_c40 . "\n");
                foreach ($obligatoiresVariables as $key => $value) {
                    //S'il s'agit du dernier element des valeurs variables et que la taille du message est inferieure a la taille totale
                    if ($key === count($obligatoiresVariables) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                        //Si le champ est encodable sans etre tronque
                        if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)))) {
                            $message .=
                                $value['code'] . strtoupper($this->trim_end($value['value']));
                        } //sinon on verifie sil peut etre tronque
                        else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) > 4) {
                            $message .=
                                $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                        } else {
                            echo ("Oooopppss \n");
                            return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager la qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                        }
                        //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                    } else if ($key !== count($obligatoiresVariables) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                        //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                        if (mb_strlen($value['value']) === 2 && mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] !== mb_strlen($value["value"])) {
                            $message .=
                                $value['code'] . strtoupper($this->trim_end($value['value'])) . "<GS>";
                        } else
                            //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] === mb_strlen($value["value"])) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value']));
                            } //sinon on verifie sil peut etre tronque
                            else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 8) {
                                $message .=
                                    $value['code'] . $this->trim_end(substr($value['value'], 0, 4)) . "<RS>";
                            } else {
                                echo ("Oooopppss $message \n");
                                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                            }
                    } else {
                        echo ("Oooopppss $message \n");
                        return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                    }
                }
                //S'il ya toujours de l'espace on passe aux elements facultatifs
                if (mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                    // echo ("encore du tafff broo  $taille_message_c40" . mb_strlen(str_replace($sepArray, $sepStrArray, $message)) . " \n");

                    foreach ($facultatifs as $key => $value) {
                        //S'il s'agit du dernier element des valeurs facultatives et que la taille du message est inferieure a la taille totale
                        if ($key === count($facultatifs) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)))) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value']));
                            }
                            //sinon on verifie sil peut etre tronque
                            else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 4) {
                                $message .=
                                    $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                            }
                            //  else {
                            //     for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray,$sepStrArray,$message)); $i++) {
                            //         $message .= ' ';
                            //     }
                            // }
                            //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                        } else if ($key !== count($facultatifs) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] !== mb_strlen($value["value"])) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value'])) . "<GS>";
                            } else
                                //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                                if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] === mb_strlen($value["value"])) {
                                    $message .=
                                        $value['code'] . strtoupper($this->trim_end($value['value']));
                                }
                                //sinon on verifie si l'espace restant peut contenir le message tronque
                                else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 4) {
                                    $message .=
                                        $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                                }
                            //  else {
                            //     for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray,$sepStrArray,$message)); $i++) {
                            //         $message .= ' ';
                            //     }
                            // }
                        } else if ($taille_message_c40 === mb_strlen(str_replace($sepArray, $sepStrArray, $message))) {
                            return ['error' => false, 'message' => $message];
                        } else {
                            for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)); $i++) {
                                $message .= ' ';
                            }
                        }
                    }
                }
            }
            //encode
        } else {
            return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
            //reduce
        }
        return ['error' => false, 'message' => $message];
    }

    /**
     * @param $champs
     * @return array
     */
    function makePublicMessage($data, $attributes, $length)
    {
        $obligatoires = [];
        $obligatoiresFixe = [];
        $facultatifs = [];
        $message = '';
        $sepArray = array("<GS>", "<RS>");
        $sepStrArray = array("GS", "RS");
        $obligatoiresVariables = [];
        $taille_message_c40 = $length['taille_message_c40'];
        foreach ($attributes as $key => $value) {
            if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'F') {
                if (array_key_exists($value['libelle'], $data))
                    $array1 = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                else
                    $array1 = ["value" => "NA", "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($facultatifs, $array1);
            } else if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O' || $value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O*') {
                // if($value['contrainte'] !== null){
                if (array_key_exists($value['libelle'], $data))
                    $array = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                else
                    $array = ["value" => "NA", "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($obligatoires, $array);
                // }
            }
        }
        $valfixes = '';
        $valvariables = '';
        foreach ($obligatoires as $key => $value) {
            if ($value['taille_max'] !== null && $value['taille_min'] !== null) {
                if ($value['taille_max'] === $value['taille_min']) {
                    // if($value['contrainte'] !== null){
                    $valfixes .= $this->trim_end($value['value']);
                    array_push($obligatoiresFixe, $value);
                    // }
                } else {
                    $valvariables .= $this->trim_end($value['value']);
                    array_push($obligatoiresVariables, $value);
                }
            }
        }
        $newLength = mb_strlen($valfixes, 'utf-8') + 2 * count($obligatoiresFixe);
        //Verifier si l'on a la possibilite d'encoder les valeurs fixes
        if ($newLength <= $taille_message_c40) {
            // echo ("equallll");
            foreach ($obligatoiresFixe as $key => $value) {
                $message .=
                    $value['code'] . strtoupper($this->trim_end($value['value']));
            }
            $nombrerestant = count($obligatoiresVariables);
            // echo ("restant" . $nombrerestant . "\n");
            if (mb_strlen($valvariables, 'utf-8') + 2 * count($obligatoiresVariables) > $taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) {
                echo ("Oooopppss \n");
                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager la qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
            } else {
                // echo ("Encodage restant \n");
                // echo (mb_strlen(str_replace($sepArray, $sepStrArray, $message)) . "   " . $taille_message_c40 . "\n");
                foreach ($obligatoiresVariables as $key => $value) {
                    //S'il s'agit du dernier element des valeurs variables et que la taille du message est inferieure a la taille totale
                    if ($key === count($obligatoiresVariables) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                        //Si le champ est encodable sans etre tronque
                        if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)))) {
                            $message .=
                                $value['code'] . strtoupper($this->trim_end($value['value']));
                        } //sinon on verifie sil peut etre tronque
                        else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) > 4) {
                            $message .=
                                $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                        } else {
                            echo ("Oooopppss \n");
                            return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager la qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                        }
                        //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                    } else if ($key !== count($obligatoiresVariables) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                        //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                        if (mb_strlen($value['value']) === 2 && mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] !== mb_strlen($value["value"])) {
                            $message .=
                                $value['code'] . strtoupper($this->trim_end($value['value'])) . "<GS>";
                        } else
                            //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] === mb_strlen($value["value"])) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value']));
                            } //sinon on verifie sil peut etre tronque
                            else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 8) {
                                $message .=
                                    $value['code'] . $this->trim_end(substr($value['value'], 0, 4)) . "<RS>";
                            } else {
                                echo ("Oooopppss $message \n");
                                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                            }
                    } else {
                        echo ("Oooopppss $message \n");
                        return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                    }
                }
                //S'il ya toujours de l'espace on passe aux elements facultatifs
                if (mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                    // echo ("encore du tafff broo  $taille_message_c40" . mb_strlen(str_replace($sepArray, $sepStrArray, $message)) . " \n");

                    foreach ($facultatifs as $key => $value) {
                        //S'il s'agit du dernier element des valeurs facultatives et que la taille du message est inferieure a la taille totale
                        if ($key === count($facultatifs) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)))) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value']));
                            }
                            //sinon on verifie sil peut etre tronque
                            else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 4) {
                                $message .=
                                    $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                            }
                            //  else {
                            //     for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray,$sepStrArray,$message)); $i++) {
                            //         $message .= ' ';
                            //     }
                            // }
                            //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                        } else if ($key !== count($facultatifs) - 1 && mb_strlen(str_replace($sepArray, $sepStrArray, $message)) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] !== mb_strlen($value["value"])) {
                                $message .=
                                    $value['code'] . strtoupper($this->trim_end($value['value'])) . "<GS>";
                            } else
                                //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                                if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message))) && $value["taille_max"] === mb_strlen($value["value"])) {
                                    $message .=
                                        $value['code'] . strtoupper($this->trim_end($value['value']));
                                }
                                //sinon on verifie si l'espace restant peut contenir le message tronque
                                else if ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) >= 4) {
                                    $message .=
                                        $value['code'] . $this->trim_end(substr($value['value'], 0, ($taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)) - 4))) . "<RS>";
                                }
                            //  else {
                            //     for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray,$sepStrArray,$message)); $i++) {
                            //         $message .= ' ';
                            //     }
                            // }
                        } else if ($taille_message_c40 === mb_strlen(str_replace($sepArray, $sepStrArray, $message))) {
                            return ['error' => false, 'message' => $message];
                        } else {
                            for ($i = 0; $i <= $taille_message_c40 - mb_strlen(str_replace($sepArray, $sepStrArray, $message)); $i++) {
                                $message .= ' ';
                            }
                        }
                    }
                }
            }
            //encode
        } else {
            return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
            //reduce
        }
        return ['error' => false, 'message' => $message];
    }

    /**
     * @param $champs
     * @return array
     */
    function makeAnnexe($data, $rules, $errorMessage)
    {
        $validator = Validator::make($data, $rules);
        $errors = $validator->errors();

        return $errors;
        // $validator->fails();
    }

    function signData($data, $worker)
    {
        // echo ($worker);
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = [
            "data" => $data
        ];
        $response = Http::withHeaders($headers)->post("http://3.140.125.122:8080/signserver/rest/v1/workers/$worker/process", $body);
        // $response = Http::withHeaders($headers)->post("http://3.140.125.122:8080/signserver/rest/v1/workers/CMSSigner/process", $body);
        // $validator = Validator::make($data, $rules);
        // $errors = $validator->errors();
        if ($response->getStatusCode() === 200) {
            // La requête a réussi
            $response = json_decode($response->getBody());
        } else {
            // La requête a échoué
            echo $response->getStatusCode();
            echo($worker);
        }
        return ["cert" => $response->signerCertificate, "signature" => $response->data];
        // $validator->fails();
    }

    function mmTopx($mm)
    {
        // 1=21.17
        // n=mm
        return $mm / 21.17;
    }

    function svg_to_base64($svg_data)
    {

        // Check if the input is valid
        if (!is_string($svg_data)) {
            return response()->json([
                'error' => 'Invalid input',
            ], 422);
        }

        // Convert the SVG data to a base64 string
        $base64_string = base64_encode($svg_data);

        // Add the header to the base64 string
        $base64_string = "data:image/svg+xml;base64," . $base64_string;

        // Return the base64 string
        return $base64_string;
    }

    /**
     * @param $champs
     * @return array
     */
    function encode($data, $type, $attributes, $size)
    {
        $jsonData=$data;
        $user = auth()->user();
        $user_id = $user['client']['id'];
        $sepArray = array("<GS>", "<RS>", "<US>");
        $sepStrArray = array("GS", "RS", "US");
        $length = $this->getLength($size);
        if ($length) {
            $message = $this->makeMessage($data, $attributes, $length);
            if ($message['error']) {
                return ['error' => true, 'message' => 'Une erreur est survenue'];
            } else {
                $signature = $this->signData($message['message'],
                    // 'ECEV-PubSigner1'
                $data['worker']
            );
                $certData = $this->getCertData($signature['cert']);
                $entete = $this->makeEntete($data, $type, $certData);
                $signature = $this->signData($entete . $message['message'],
                // 'ECEV-PubSigner1'
                $data['worker']
            );
                $data = $signature['signature'];
                // $espace_signature = Base32::encode(Base64::decode(rtrim($data, '=')));
                $c40_data = $entete . $message['message'] . "<US>" . $data;
                $pxSize = $this->mmTopx($size);
                $svgcev = DNS2DFacade::getBarcodeSVG($c40_data, 'DATAMATRIX', $pxSize, $pxSize);
                // $svgcev = DNS2DFacade::getBarcodeSVG($c40_data, 'DATAMATRIX', $pxSize, $pxSize);
                Cev::create([
                    'client_id' => $user_id,
                    'status' => "SUCCESS",
                    'type_document_id' => $type,
                    'c40data' => $c40_data,
                    'json_data' => json_encode($jsonData),
                ]);
                $base64Encoded = $this->svg_to_base64($svgcev);
                return ['error' => false, 'message' => $base64Encoded];
            }
        } else {
            Cev::create([
                'client_id' => $user_id,
                'status' => "ERROR",
                'type_document_id' => $type,
                'c40data' => "",
                'json_data' => "",
            ]);
            return ['error' => true, 'message' => 'Il se pourrait que la taille du CEV selectionnee ne convienne pas a la taille de l\'information a encoder'];
        }
        // $validator->fails();
    }

    /**
     * @param $champs
     * @return array
     */
    function encodepublic($data, $type, $attributes, $size)
    {
        $jsonData=$data;
        $length = $this->getLength($size);
        if ($length) {
            $message = $this->makePublicMessage($data, $attributes, $length);
            if ($message['error']) {
                return ['error' => true, 'message' => 'Une erreur est survenue'];
            } else {
                $signature = $this->signData($message['message'], 'ECEV-PubSigner1');
                $certData = $this->getCertData($signature['cert']);
                $entete = $this->makePubEntete($data, $type, $certData);
                $signature = $this->signData($entete . $message['message'], 'ECEV-PubSigner1');
                $data = $signature['signature'];
                // $espace_signature = Base32::encode(Base64::decode(rtrim($data, '=')));
                $espace_signature = $data;
                $c40_data = $entete . $message['message'] . "<US>" . $espace_signature;
                $pxSize = $this->mmTopx($size);
                $svgcev = DNS2DFacade::getBarcodeSVG($c40_data, 'DATAMATRIX', $pxSize, $pxSize);
                $base64Encoded = $this->svg_to_base64($svgcev);
                Cev::create([
                    'client_id' => 1,
                    'status' => "SUCCESS",
                    'type_document_id' => $type,
                    'c40data' => $c40_data,
                    'json_data' => json_encode($jsonData),
                ]);
                return ['error' => false, 'message' => $c40_data];
            }
        } else {
            Cev::create([
                'client_id' => 1,
                'status' => "ERROR",
                'type_document_id' => $type,
                'c40data' => "",
                'json_data' => "",
            ]);
            return ['error' => true, 'message' => 'Il se pourrait que la taille selectionnee ne convienne pas a la taille des information a ecoder'];
        }
        // $validator->fails();
    }
}
