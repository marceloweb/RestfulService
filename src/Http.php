<?php

namespace RestfulService;

class Http
{
    public $header;
    public $body;
    public $ch;
    public $endpoint;
    public $fields;
    public $headers;

    public static function post($endpoint, $headers, $fields, $getHeader = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($getHeader) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (!is_null($headers)) {
            foreach ($headers as $header) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
            }
        }

        $server_output = curl_exec($ch);
        curl_close($ch);

        return ( $server_output );
    }

    public static function put($endpoint, $headers, $fields, $getHeader = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if ($getHeader) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (!is_null($headers)) {
            foreach ($headers as $header) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
            }
        }

        $server_output = curl_exec($ch);
        curl_close($ch);

        return ( $server_output );
    }

    public static function get($endpoint, array $headers, $getHeader = false)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if ($getHeader) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (!is_null($headers)) {
            foreach ($headers as $header) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
            }
        }
        $server_output = curl_exec($ch);
        
        curl_close($ch);
        return ( $server_output );
    }

    public static function delete($endpoint, array $headers, $getHeader = false)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if (!is_null($headers)) {
            foreach ($headers as $header) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
            }
        }

        if ($getHeader) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        $server_output = curl_exec($ch);
        curl_close($ch);
	
	return ( $server_output );
    }

    public static function json($endpoint, $headers, array $fields, $getHeader = false)
    {
        $fields = json_encode($fields);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        if ($getHeader) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (!is_null($headers)) {
            foreach ($headers as $header) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
            }
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($fields)));

        $server_output = curl_exec($ch);
        curl_close($ch);

        return ( $server_output );
    }

    public static function parseHeaders(array $headers)
    {
        $head = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
                    $head['reponse_code'] = intval($out[1]);
                }
            }
	}

        return $head;
    }
    
    public static function getHeaderCode($data)
    {
        if (is_string($data)) {
            list($data, $body) = explode("\r\n\r\n", $data, 2);
        }
        $parsedHeader = Http::parseHeaders(explode("\r\n", $data));

        return $parsedHeader['reponse_code'];
    }

}
