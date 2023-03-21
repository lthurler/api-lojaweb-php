<?php

function generateJWT($dados)
{
    //Application Key
    $key = KEY; // loja - exemplo -> sha256

    //Header Token
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    //Payload - Content
    $payload = [
        'exp' => (new DateTime("now"))->getTimestamp(), //tempo em segundos a partir de 1/1/1970
        'uid' => $dados->id_usuario,

        'email' => $dados->email,
        'name' => $dados->nome,
        'foto_perfil' => $dados->foto,
        'ultimo_login' => (new DateTime("now"))->getTimestamp(),
    ];

    //JSON
    $header = json_encode($header);
    $payload = json_encode($payload);

    //Base 64
    $header = base64_encode($header);
    $payload = base64_encode($payload);

    //Sign
    $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
    $sign = base64_encode($sign);

    //Token
    $token = $header . '.' . $payload . '.' . $sign;

    return $token;
}

function validJWT($token)
{
    if ($token == null) return false;

    $key = KEY;

    $token =  str_replace(["Bearer", " "], "", $token);

    $partes = explode(".", $token);

    $header = $partes[0];
    $payload = $partes[1];
    $sign = $partes[2];

    $signVerfi = base64_encode(hash_hmac('sha256', $header . "." . $payload, $key, true));

    if ($sign === $signVerfi) {
        //$header = json_encode(base64_decode($header));
        $payload = json_encode(base64_decode($payload));
        return $payload;
    }
    return false;
}
