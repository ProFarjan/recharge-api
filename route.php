<?php

include_once 'Lib.php';
$lib = new Lib();

function postRequest () {
    global $lib;
    if (isset($_POST) && !empty($_POST)) {
        extracted($lib);
    }
}

function getRequest () {
    global $lib;
    if (isset($_GET) && !empty($_GET['table'])) {
        if ($res = $lib->get($_GET)) {
            if (!array_key_exists('status', $res)) {
                echo (json_encode([
                    'status' => 'success',
                    'message' => $res
                ]));
            } else {
                echo (json_encode([
                    'status' => 'failure',
                    'message' => $res
                ]));
            }
        } else {
            echo (json_encode([
                'status' => 'failure',
                'message' => 'data not found!'
            ]));
        }
    }
}

function deleteRequest() {
    global $lib;
    if (isset($_GET) && !empty($_GET['table'])) {
        if ($res = $lib->delete($_GET)) {
            if (!array_key_exists('status', $res)) {
                echo (json_encode([
                    'status' => 'success',
                    'message' => $res
                ]));
            } else {
                echo (json_encode([
                    'status' => 'failure',
                    'message' => $res
                ]));
            }
        } else {
            echo (json_encode([
                'status' => 'failure',
                'message' => 'data not found!'
            ]));
        }
    }
}
function putRequest() {
    global $lib;
    $putData = putDecode();
    if (isset($_GET) && !empty($_GET['table']) && count($putData) > 0) {
        if ($res = $lib->update($putData, $_GET)) {
            if (!array_key_exists('status', $res)) {
                echo (json_encode([
                    'status' => 'success',
                    'message' => $res
                ]));
            } else {
                echo (json_encode([
                    'status' => 'failure',
                    'message' => $res
                ]));
            }
        } else {
            echo (json_encode([
                'status' => 'failure',
                'message' => 'data not found!'
            ]));
        }
    }
}

/**
 * @param Lib $lib
 */
function extracted(Lib $lib)
{
    if ($res = $lib->save($_POST, $_GET)) {
        if (!array_key_exists('status', $res) && $res['status'] == 'success') {
            echo(json_encode([
                'status' => 'success',
                'message' => $res
            ]));
        } else {
            echo(json_encode([
                'status' => 'failure',
                'message' => $res
            ]));
        }
    } else {
        echo(json_encode([
            'status' => 'failure',
            'message' => 'data is not valid!'
        ]));
    }
}

function putDecode () {
    $raw_data = file_get_contents('php://input');
    $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

    $parts = array_slice(explode($boundary, $raw_data), 1);
    $data = array();

    foreach ($parts as $part) {
        // If this is the last part, break
        if ($part == "--\r\n") break;

        // Separate content from headers
        $part = ltrim($part, "\r\n");
        list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

        // Parse the headers list
        $raw_headers = explode("\r\n", $raw_headers);
        $headers = array();
        foreach ($raw_headers as $header) {
            list($name, $value) = explode(':', $header);
            $headers[strtolower($name)] = ltrim($value, ' ');
        }

        // Parse the Content-Disposition to get the field name, etc.
        if (isset($headers['content-disposition'])) {
            $filename = null;
            preg_match(
                '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                $headers['content-disposition'],
                $matches
            );
            list(, $type, $name) = $matches;
            isset($matches[4]) and $filename = $matches[4];

            // handle your fields here
            switch ($name) {
                // this is a file upload
                case 'userfile':
                    file_put_contents($filename, $body);
                    break;

                // default for all other files is to populate $data
                default:
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                    break;
            }
        }
    }

    return $data;
}