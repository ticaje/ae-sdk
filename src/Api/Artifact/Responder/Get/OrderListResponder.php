<?php
declare(strict_types=1);

/**
 * Api Class
 * @category    Ticaje
 * @author      Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\AeSdk\Api\Artifact\Responder\Get;

use Ticaje\Contract\Patterns\Interfaces\Pool\WorkerInterface;
use Ticaje\Contract\Patterns\Interfaces\Decorator\Responder\ResponseInterface as ContractResponseInterface;

use Ticaje\AeSdk\Api\Interfaces\ApiResponderInterface;
use Ticaje\AeSdk\Api\Artifact\Responder\Responder;

/**
 * Class OrderInfoResponder
 * @package Ticaje\AeSdk\Api\Artifact\Responder
 */
class OrderListResponder implements ApiResponderInterface, WorkerInterface
{
    use Responder;

    private $count;

    private $orders = [];

    /**
     * @inheritDoc
     */
    public function process(ContractResponseInterface $response): ApiResponderInterface
    {
        $content = json_decode($response->getContent());
        isset($content->error_response) ? $this->error($content->error_response) : $this->success($content->aliexpress_solution_order_get_response);
        return $this;
    }

    protected function success(\stdClass $response)
    {
        $data = $response->result;
        $itemsCount = $data->total_count;
        $message = $itemsCount ? "{$itemsCount} orders fetched successfully" : 'No orders found with such criteria';
        $this
            ->setSuccess(1)
            ->setCount($itemsCount)
            ->setOrders($itemsCount ? $data->target_list->order_dto : null)
            ->setCode(200)
            ->setMessage($message)
        ;
    }
}
