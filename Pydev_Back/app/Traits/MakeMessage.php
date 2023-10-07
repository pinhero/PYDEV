<?php


namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use phpseclib3\File\X509;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ParagonIE\ConstantTime\Base32;
use ParagonIE\ConstantTime\Base64;

trait MakeMessage
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
     * @return array
     */
    function makeDiff($date)
    {
        $date = Carbon::parse($date);
        $difference = $date->diffInDays(Carbon::create(2000, 1, 1));
        return dechex($difference);
        // $validator->fails();
    }

    /**
     * @param $champs
     * @return array
     */
    function getCertData($cert)
    {
        $certString = "MIIDlzCCAn+gAwIBAgIIOdPbElQbJhcwDQYJKoZIhvcNAQELBQAwTDEWMBQGA1UEAwwNRFNTIFN1YiBDQSAxMTEQMA4GA1UECwwHVGVzdGluZzETMBEGA1UECgwKU2lnblNlcnZlcjELMAkGA1UEBhMCU0UwHhcNMTYwMzAzMDgyNTA0WhcNMzYwMjI3MDgyNTA0WjBKMRQwEgYDVQQDDAtzaWduZXIwMDAwMzEQMA4GA1UECwwHVGVzdGluZzETMBEGA1UECgwKU2lnblNlcnZlcjELMAkGA1UEBhMCU0UwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCyFKqwwiHS2o4PO3zovqC+jGuIELnja1iAlg/hyrRp28mF6BOGVaKE6ZzbQIMmmICRz+EeqXN1W8gyCEh6T2qN3QvXTAF9mrrUI3hG4Xn/Davgsln8saRE0zt45yy47dPq5YofYJWWIdW/6qssiX+ApcPqthCQfkgraUSagS/Reqy0WT/A2lwKh147GB9+MxhheskQIPaKQasOpI7vGfzey+GnkHPsfU21irS2nC8uzv6hd0G6hNYUEmJtIh9/5WebMoMiGFq1sydTtZp7pJilfPyxrAkHXEwMUEEMcVlE/ISCoKMttnLMUT/F00cHesU4D2yNl6gcSjpMj4Q/iF+hAgMBAAGjfzB9MB0GA1UdDgQWBBQ2/WY3Ln7tdUmDrTyvtvSZwBg8YzAMBgNVHRMBAf8EAjAAMB8GA1UdIwQYMBaAFBxgQUremK3l1gOK6GaCqX6w8gKHMA4GA1UdDwEB/wQEAwIF4DAdBgNVHSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwQwDQYJKoZIhvcNAQELBQADggEBAIUh6kkCMc0Fs6U+Sw6Ns0Yd28Fb5SM//nE6mq3mf1SD4lAyChVrFvlqMZJaqeJlkVeHc9E+KCE5bX1r2iGC8rnE9DuItI0pKMrgFt4cbSbDwgovnTrkiIhuqP2pjdhmrHtlLqZBR8e16c4xGSn6XWKJ8vPzx2AJl7MY3sY3Z4aPckBFNjG1lzH1inq5WM/+WaLghOQQngaXeU+SWpoAM7cUjB8Uyjf2Qr2GerI4AZZJMuC6BuvMdFMyXX78l7c9qmvK9Bre+SFKdtcMAgnglLzu0lyPHPwYL0R+pwc5dFOJipafxeqeHGpkZTXMsdMn6f1USRznlGbRWru68/XOOFU=";
        $x509 = new X509();
        $decodedCert = $x509->loadX509($certString);
        // print_r($decodedCert);
        return (["serialNumber" => $decodedCert['tbsCertificate']['subject']['rdnSequence'][0][0]['value']['utf8String'], "caId" => $decodedCert['tbsCertificate']['issuer']['rdnSequence'][0][0]['value']['utf8String']]);
    }

    /**
     * @param $champs
     * @return array
     */
    function makeEntete($data, $type, $certData)
    {

        $entete = "DC" . $data['version'] . $certData['caId'] . $certData['serialNumber'] . $this->makeDiff($data['date_emission']) . $this->makeDiff($data['date_creation']) . $type;
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
        $msglength = 0;
        $obligatoiresVariables = [];
        $taille_message_c40 = $length['taille_message_c40'];
        foreach ($attributes as $key => $value) {
            if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'F') {
                $array1 = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($facultatifs, $array1);
            } else if ($value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O' || $value['contrainte'] !== null && $value['contrainte']['contrainte'] === 'O*') {
                // if($value['contrainte'] !== null){
                $array = ["value" => $data[$value['libelle']], "code" => $value['code'], "taille_min" => $value['taille_min'], "taille_max" => $value['taille_max']];
                array_push($obligatoires, $array);
                // }
            }
        }
        // return $errors;
        // $validator->fails();
        $nombredechamps = 0;
        $concatenation = '';
        foreach ($obligatoires as $key => $value) {
            $nombredechamps += 1;
            $concatenation .= $value['value'];
        }
        $actualLength = mb_strlen($concatenation, 'utf-8') + 4 * $nombredechamps;
        //Verifier la taille des donnees a encoder est superieur a la taille totale
        if ($actualLength > $length['taille_message_c40']) {
            echo ('suppppppppp');
            $valfixes = '';
            $valvariables = '';
            foreach ($obligatoires as $key => $value) {
                if ($value['taille_max'] !== null && $value['taille_min'] !== null) {
                    if ($value['taille_max'] === $value['taille_min']) {
                        // if($value['contrainte'] !== null){
                        $valfixes .= $value['value'];
                        array_push($obligatoiresFixe, $value);
                        // }
                    } else {
                        $valvariables .= $value['value'];
                        array_push($obligatoiresVariables, $value);
                    }
                }
            }
            $newLength = mb_strlen($valfixes, 'utf-8') + 2 * count($obligatoiresFixe);
            //Verifier si l'on a la possibilite d'encoder les valeurs fixes
            if ($newLength <= $taille_message_c40) {
                echo ("equallll");
                foreach ($obligatoiresFixe as $key => $value) {
                    $message .=
                        $value['code'] . strtoupper($value['value']);
                    $msglength = mb_strlen($message);
                }
                $nombrerestant = count($obligatoiresVariables) - 1;
                echo ("restant" . $nombrerestant . "\n");
                if (mb_strlen($valvariables, 'utf-8') + 2 * count($obligatoiresVariables) > $taille_message_c40 - $msglength) {
                    echo ("Oooopppss \n");
                    return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                } else {
                    echo ("Encodage restant \n");
                    echo (mb_strlen($message) . "   " . $taille_message_c40 . "\n");
                    foreach ($obligatoiresVariables as $key => $value) {
                        //S'il s'agit du dernier element des valeurs fixes et que la taille du message est inferieure a la taille totale
                        if ($key === count($obligatoiresVariables) - 1 && mb_strlen($message) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque
                            if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message))) {
                                $message .=
                                    $value['code'] . strtoupper($value['value']);
                            } else {
                                echo ("Oooopppss \n");
                                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                            }
                            //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                        } else if ($key !== count($obligatoiresVariables) - 1 && mb_strlen($message) < $taille_message_c40) {
                            //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                            if (mb_strlen($value['value']) === 2 && mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message)) && $value["taille_max"] !== mb_strlen($value["value"])) {
                                $message .=
                                    $value['code'] . strtoupper($value['value']) . "<GS>";
                            } else
                                //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                                if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message)) && $value["taille_max"] === mb_strlen($value["value"])) {
                                    $message .=
                                        $value['code'] . strtoupper($value['value']);
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
                    if (mb_strlen($message) < $taille_message_c40) {
                        echo ("encore du tafff broo  $taille_message_c40" . mb_strlen($message) . " \n");

                        foreach ($facultatifs as $key => $value) {
                            //S'il s'agit du dernier element des valeurs facultatives et que la taille du message est inferieure a la taille totale
                            if ($key === count($facultatifs) - 1 && mb_strlen($message) < $taille_message_c40) {
                                //Si le champ est encodable sans etre tronque
                                if (mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message))) {
                                    $message .=
                                        $value['code'] . strtoupper($value['value']);
                                }
                                //sinon on verifie si l'espace restant peut contenir le message tronque
                                else if ($taille_message_c40 - $msglength > 7) {
                                    $message .=
                                        $value['code'] . substr($value['value'], 0, 3) . "<RS>";
                                } else {
                                    for ($i = 0; $i <= $taille_message_c40 - $msglength; $i++) {
                                        $message .= ' ';
                                    }
                                }
                                //Sil ne s'agit pas du dernier element a encoder et que toujours la taille du message st inferieur a la taille totale
                            } else if ($key !== count($facultatifs) - 1 && mb_strlen($message) < $taille_message_c40) {
                                //Si le champ est encodable sans etre tronque et qu'il n'a pas encore atteint sa valeur maximale
                                if (mb_strlen($value['value']) === 2 && mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message)) && $value["taille_max"] !== mb_strlen($value["value"])) {
                                    $message .=
                                        $value['code'] . strtoupper($value['value']) . "<GS>";
                                } else
                                    //S'il a atteint sa valeur maximale mais qu'il reste encodable sans etre tronque
                                    if (mb_strlen($value['value']) === 2 && mb_strlen($value['value']) + 2 <= ($taille_message_c40 - mb_strlen($message)) && $value["taille_max"] === mb_strlen($value["value"])) {
                                        $message .=
                                            $value['code'] . strtoupper($value['value']);
                                    }
                                    //sinon on verifie si l'espace restant peut contenir le message tronque
                                    else if ($taille_message_c40 - $msglength > 7) {
                                        $message .=
                                            $value['code'] . substr($value['value'], 0, 3) . "<RS>";
                                    } else {
                                        for ($i = 0; $i <= $taille_message_c40 - $msglength; $i++) {
                                            $message .= ' ';
                                        }
                                    }
                            } else if ($taille_message_c40 === mb_strlen($message)) {
                                echo ("OOOUUUUFFFF $message\n");
                                return $message;
                            }
                        }
                    }
                }
                //encode
            } else {
                return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                //reduce
            }
        } else {
            //Taille du contenu inferieur a la taille limite
            $msglength = 0;
            foreach ($obligatoires as $key => $value) {
                //Si le message est dans la marge
                if ($msglength <= $taille_message_c40) {
                    //Si le contenu est dans la marge
                    if (mb_strlen($value['value']) + 2 <= $taille_message_c40 - $msglength) {
                        if (mb_strlen($value['value']) <= $value['taille_max']) {
                            $message .=
                                $value['code'] . strtoupper($value['value']) . "<GS>";
                            $msglength = mb_strlen($message);
                        } else if (mb_strlen($value['value']) === $value['taille_max']) {
                            $message .=
                                $value['code'] . strtoupper($value['value']);
                            $msglength = mb_strlen($message);
                        }
                    } else {
                        //si le champ est trop grand
                        // $nombrerestant = count($obligatoires) - ($key + 1);
                        // if ($nombrerestant * 6 > $taille_message_c40 - $msglength) {
                        //     //si l'espace restant est insuffisant
                        //     return ['error'=>true,'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                        // } else {
                        //     if ($key === count($obligatoires) - 1 && $taille_message_c40 - $msglength >= 4) {
                        //         $message .=
                        //             $value['code'] . substr($value['value'], 0, $taille_message_c40 - $msglength - 4) . "<RS>";
                        //     } else if ($key !== count($obligatoires) - 1 && $taille_message_c40 - $msglength >= 4) {
                        //         $message .=
                        //             $value['code'] . strtoupper($value['value']) . "<GS>";
                        //     } else {
                        //         //si l'espace restant est insuffisant
                        //         return ['error'=>true,'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                        //     }
                        // }
                        return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                    }
                } else {
                    echo ("erreurrrr");
                }
            }
            if (mb_strlen($message) < $taille_message_c40) {
                // echo ("encore du tafff broo \n");
                // echo ($taille_message_c40 . "\n");
                // print_r($facultatifs);
                // foreach ($facultatifs as $key => $value) {
                //     echo ("$key \n");
                //     if ($key === count($facultatifs) - 1) {
                //         $message .=
                //             $value['code'] . substr($value['value'], 0, mb_strlen($value['value'])-($taille_message_c40 - $msglength - 4)) . "<RS>";
                //     } else {
                //         $message .=
                //             $value['code'] . strtoupper($value['value']) . "<GS>";
                //     }
                // }
                foreach ($facultatifs as $key => $value) {
                    // echo (mb_strlen($message) . " message " . $message . "\n");
                    if ($key === count($facultatifs) - 1 && mb_strlen($message) < $taille_message_c40) {
                        if (mb_strlen($value['value']) <= ($taille_message_c40 - mb_strlen($message))) {
                            $message .=
                                $value['code'] . strtoupper($value['value']);
                        } else if ($taille_message_c40 - $msglength > 7) {
                            $message .=
                                $value['code'] . substr($value['value'], 0, 3) . "<RS>";
                        }
                    } else if ($key !== count($obligatoiresVariables) - 1 && mb_strlen($message) < $taille_message_c40) {
                        $message .=
                            $value['code'] . strtoupper($value['value']) . "<GS>";
                    } else if (mb_strlen($message) === $taille_message_c40) {
                        echo ("$message \n");
                        // return ['error'=>true,'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                    } else {
                        return ['error' => true, 'message' => "Nous ne pouvons pas encoder ce contenu sans endomager le qualite du contenu veuillez augmenter la taille de votre CEV ou reduire la longueur de vos donnees"];
                    }
                }
            }
            if (mb_strlen($message) < $taille_message_c40) {
                for ($i = 0; $i <= $taille_message_c40 - $msglength; $i++) {
                    $message .= ' ';
                }
            }
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
        $response = Http::withHeaders($headers)->post("http://192.168.7.23:8080/signserver/rest/v1/workers/$worker/process", $body);
        // $response = Http::withHeaders($headers)->post("http://192.168.7.23:8080/signserver/rest/v1/workers/CMSSigner/process", $body);
        // $validator = Validator::make($data, $rules);
        // $errors = $validator->errors();
        if ($response->getStatusCode() === 200) {
            // La requête a réussi
            $response = json_decode($response->getBody());
        } else {
            // La requête a échoué
            echo $response->getStatusCode();
        }
        return ["cert" => $response->signerCertificate, "signature" => $response->data];
        // $validator->fails();
    }

    /**
     * @param $champs
     * @return array
     */
    function encode($data, $type, $attributes, $size)
    {
        function base32_encode_crockford($data)
        {
            $chars = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
            $paddingChar = '=';
            $padding = 0;
            $encoded = '';
            $buffer = 0;
            $bufferSize = 0;

            foreach (str_split($data) as $byte) {
                $buffer <<= 8;
                $buffer |= ord($byte);
                $bufferSize += 8;

                while ($bufferSize >= 5) {
                    $encoded .= $chars[($buffer >> ($bufferSize - 5)) & 0x1F];
                    $bufferSize -= 5;
                }
            }

            if ($bufferSize > 0) {
                $buffer <<= (5 - $bufferSize);
                $encoded .= $chars[$buffer & 0x1F];
                $padding = (8 - $bufferSize) / 5;
            }

            while ($padding > 0) {
                $encoded .= $paddingChar;
                $padding--;
            }

            return $encoded;
        }

        $length = $this->getLength($size);
        if ($length) {
            $message = $this->makeMessage($data, $attributes, $length);
            if ($message['error']) {
                return ['error' => true, 'message' => 'Une erreur est survenue'];
            } else {
                $signature = $this->signData($message['message'], $data['worker']);
                $certData = $this->getCertData($signature['cert']);
                $entete = $this->makeEntete($data, $type, $certData);
                // $c40_data = $entete."<US>".$message. $signature['signature'];
                // echo($c40_data);
                // return $c40_data;
                $data = $signature['signature'];
                // echo(Base32::encode(Base64::decode(rtrim($data,'='))));
                echo(rtrim($data,'=')."\n");
                echo (Base32::encode(Base64::decode($data)) . "\n");
                // print_r ($message);
            }
        } else {
            return ['error' => true, 'message' => 'Une erreur est survenue'];
        }
        // $validator->fails();
    }
}
