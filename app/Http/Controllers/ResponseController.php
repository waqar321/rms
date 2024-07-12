<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;


class ResponseController extends Controller
{
    protected $_supported_formats = array(
        'xml' => 'application/xml',
        'json' => 'application/json',
        'jsonp' => 'application/javascript',
        'serialized' => 'application/vnd.php.serialized',
        'php' => 'text/plain',
        'html' => 'text/html',
        'csv' => 'application/csv',
        'pdf' => 'application/pdf'
    );

    function response($output,$code,$format = "json"){
        $format =    $this->find_Format(request());
        if ($format === 'json') {
            header('Content-Type: application/json');
            return response()->json($output, $code);
        } elseif ($format === 'xml') {
//            $xml = ArrayToXml::convert($output);
//            return response($xml, $code)->header('Content-Type', 'application/xml');

            $xml =  $this->convert_array_to_xml($output);
            return response($xml, $code)->header('Content-Type', 'application/xml');
        } else {
            // Handle other formats or provide an error message
            header('Content-Type: text/plain');
            echo 'Unsupported format';
        }
    }

    private function find_Format(Request $request)
    {
        // Find the position of the 'format' keyword in the URI segments
        $segments = $request->segments();

        foreach ($segments as $index => $segment) {
            if ($segment === 'format' && isset($segments[$index + 1])) {
                return $segments[$index + 1];
            }
        }

        // If 'format' is not found, default to position 3
        return "json";
    }

    function array_to_xml($data, &$xml)
    {
        foreach ($data as $key => $value) {

            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item'; // If the key is numeric, use 'item'
                }
                $subnode = $xml->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                if (is_numeric($key)) {
                    $key = 'item';
                }
                // Check if $value is a string before using htmlspecialchars
                if (is_string($value)) {
                    $xml->addChild($key, htmlspecialchars($value));
                } else {
                    // Handle non-string values accordingly (e.g., convert to string, skip, etc.)
                    // For example, you can convert non-string values to a string representation
                    $xml->addChild($key, htmlspecialchars(strval($value)));
                }
            }
        }
    }

    function convert_array_to_xml($input_array)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xml></xml>');
        $this->array_to_xml($input_array, $xml);

        return $xml->asXML();
    }



}
