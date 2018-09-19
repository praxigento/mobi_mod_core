<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2018
 */

namespace Test\Praxigento\Core\Api\Web\Customer\Get\ById;

use Praxigento\Core\Api\Web\Customer\Get\ById\Response as AnObject;

include_once(__DIR__ . '/../../../../../phpunit_bootstrap.php');

class ResponseTest
    extends \Praxigento\Core\Test\BaseCase\Unit
{

    public function test_convert()
    {
        /* create object & convert it to 'JSON'-array */
        $obj = new AnObject();

        $data = new \Praxigento\Core\Api\Service\Customer\Get\ById\Response();
        $data->setEmail('email');
        $data->setId(8);
        $data->setNameFirst('first');
        $data->setNamelast('last');
        $obj->setData($data);

        /** @var \Magento\Framework\Webapi\ServiceOutputProcessor $output */
        $output = $this->manObj->get(\Magento\Framework\Webapi\ServiceOutputProcessor::class);
        $json = $output->convertValue($obj, AnObject::class);

        /* convert 'JSON'-array to object */
        /** @var \Magento\Framework\Webapi\ServiceInputProcessor $input */
        $input = $this->manObj->get(\Magento\Framework\Webapi\ServiceInputProcessor::class);
        $data = $input->convertValue($json, AnObject::class);
        $this->assertNotNull($data);
    }
}