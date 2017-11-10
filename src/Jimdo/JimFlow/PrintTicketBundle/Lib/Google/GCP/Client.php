<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP;

use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\ClientInterface;

class Client
{

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return \Buzz\Message\Response
     */
    public function getPrinterList()
    {
        $response = $this->client->get('https://www.google.com/cloudprint/search');
        $this->assertRequestIsSuccessful($response);

        $json = $this->getJson($response);

        return $json['printers'];
    }

    /**
     * @param $printerId
     * @return mixed
     */
    public function getPrinterInformation($printerId)
    {
        return $this->client->get('https://www.google.com/cloudprint/printer?printerid=' . $printerId);
    }

    /**
     * @param $printerId
     * @param array $configuration
     * @return array
     */
    public function submitPrintJob($printerId, array $configuration)
    {
        //XXX Default ticket for our Epson needs to replaced with some kind of configuration
        $ticket = '{
  "version": "1.0",
  "print": {
    "vendor_ticket_item": [
      {
        "id": "psk:PageInputBin",
        "value": "epns200:Back"
      },
      {
        "id": "psk:PageMediaType",
        "value": "psk:Plain"
      },
      {
        "id": "psk:PageScaling",
        "value": "psk:None"
      }
    ],
    "color": {
      "vendor_id": "psk:Color",
      "type": 0
    },
    "duplex": {
      "type": 0
    },
    "page_orientation": {
      "type": 2
    },
    "copies": {
      "copies": 1
    },
    "dpi": {
      "horizontal_dpi": 300,
      "vertical_dpi": 300,
      "vendor_id": "epns200:Level2"
    },
    "fit_to_page": {
      "type": 1
    },
    "media_size": {
      "width_microns": 101600,
      "height_microns": 152400,
      "is_continuous_feed": false,
      "vendor_id": "psk:NorthAmerica4x6"
    },
    "reverse_order": {
      "reverse_order": false
    }
  }
}';
        //XXX Use mime
        $data = array(
            'printerid' => $printerId,
            'content' => base64_encode($configuration['content']),
            'contentType' => $configuration['mime'],
            'ticket' => $ticket,
            'title' => 'Ticket',
            'tag' => 'ticket',
            'contentTransferEncoding' => 'base64'
        );

        $response = $this->client->post('https://www.google.com/cloudprint/submit', array(), $data);
        $this->assertRequestIsSuccessful($response);

        return $this->getJson($response);
    }

    /**
     * @param \Buzz\Message\Response $response
     * @throws \Exception
     * @return array
     */
    private function getJson(\Buzz\Message\Response $response)
    {
        $json = json_decode($response->getContent(), true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new \Exception('Huh, could not parse JSON :( : ' . $response->getContent());
        }

        return $json;
    }

    /**
     * @param \Buzz\Message\Response $response
     * @throws \InvalidArgumentException
     */
    private function assertRequestIsSuccessful(\Buzz\Message\Response $response)
    {
        $data = json_decode($response->getContent(), true);

        if (!$response->isSuccessful() || !isset($data['success']) || $data['success'] != "true") {
            //XXX Invent Exception fitting here
            throw new \InvalidArgumentException($response->getContent());
        }
    }

}
