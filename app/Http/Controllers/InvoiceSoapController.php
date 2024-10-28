<?php

namespace App\Http\Controllers;

class InvoiceSoapController extends Controller
{
    public function getInvoices()
    {
        try {
            $wsdl = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL';

            $client = new \SoapClient($wsdl, [
                'trace'      => 1,
                'exceptions' => true,
            ]);

            // Parámetro de entrada: código ISO del país (por defecto 'CO')
            $countryCode = 'CO';

            // Parámetros que se enviarán al servicio
            $params = [
                'sCountryISOCode' => $countryCode,
            ];

            $response = $client->__soapCall('CountryName', [$params]);

            // Obtener el XML de la solicitud enviada
            $requestXml = $client->__getLastRequest();

            // Obtener el XML de la respuesta recibida
            $responseXml = $client->__getLastResponse();

            $countryName = $response->CountryNameResult;

            return response()->json([
                'countryCode' => $countryCode,
                'countryName' => $countryName,
                'requestXml'  => $requestXml,
                'responseXml' => $responseXml
            ]);
        } catch (\SoapFault $e) {
            // Manejar errores específicos de SOAP
            return response()->json([
                'message' => 'SOAP Error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Manejar otros errores
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
