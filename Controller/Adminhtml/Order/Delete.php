<?php

namespace TechImprovement\DeleteOrders\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\CreditmemoRepository;
use Magento\Sales\Model\Order\InvoiceRepository;
use Magento\Sales\Model\Order\ShipmentRepository;

class Delete extends Action
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;
    /**
     * @var InvoiceRepository
     */
    protected InvoiceRepository $invoiceRepository;
    /**
     * @var ShipmentRepository
     */
    protected ShipmentRepository $shipmentRepository;
    /**
     * @var CreditmemoRepository
     */
    protected CreditmemoRepository $creditmemoRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param InvoiceRepository $invoiceRepository
     * @param ShipmentRepository $shipmentRepository
     * @param CreditmemoRepository $creditmemoRepository
     */

    public function __construct(
        Context                  $context,
        OrderRepositoryInterface $orderRepository,
        InvoiceRepository        $invoiceRepository,
        ShipmentRepository       $shipmentRepository,
        CreditmemoRepository     $creditmemoRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->creditmemoRepository = $creditmemoRepository;
        parent::__construct($context);
    }

    /**
     * Delete order
     *
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(): void
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $order = $this->orderRepository->get($orderId);

        $invoices = $order->getInvoiceCollection();
        foreach ($invoices as $invoice) {
            $this->invoiceRepository->delete($invoice);
        }

        $shipments = $order->getShipmentsCollection();
        foreach ($shipments as $shipment) {
            $this->shipmentRepository->delete($shipment);
        }

        $creditmemos = $order->getCreditmemosCollection();
        foreach ($creditmemos as $creditmemo) {
            $this->creditmemoRepository->delete($creditmemo);
        }

        $this->orderRepository->delete($order);

        $this->_redirect('sales/order/index');
    }
}
