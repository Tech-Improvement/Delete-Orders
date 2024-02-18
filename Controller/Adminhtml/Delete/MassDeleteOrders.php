<?php

namespace TechImprovement\DeleteOrders\Controller\Adminhtml\Delete;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\CreditmemoRepository;
use Magento\Sales\Model\Order\InvoiceRepository;
use Magento\Sales\Model\Order\ShipmentRepository;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDeleteOrders extends Action
{
    /**
     * @var Filter
     */
    protected Filter $filter;
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;
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
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param InvoiceRepository $invoiceRepository
     * @param ShipmentRepository $shipmentRepository
     * @param CreditmemoRepository $creditmemoRepository
     */

    public function __construct(
        Context                  $context,
        Filter                   $filter,
        CollectionFactory        $collectionFactory,
        OrderRepositoryInterface $orderRepository,
        InvoiceRepository        $invoiceRepository,
        ShipmentRepository       $shipmentRepository,
        CreditmemoRepository     $creditmemoRepository
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->shipmentRepository = $shipmentRepository;
        $this->creditmemoRepository = $creditmemoRepository;
        parent::__construct($context);
    }

    /**
     * Delete order
     *
     * @return ResultInterface
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $deleted = 0;

        foreach ($collection as $order) {
            /* @var $order Order */
            if ($this->deleteOrderEntities($order)) {
                $deleted++;
            }
        }

        if ($deleted > 0) {
            $this->messageManager->addSuccessMessage(__('A total of %1 order(s) and related invoices, shipments, and credit memos have been deleted.', $deleted));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('sales/order/index');
    }

    /**
     * Delete order and related entities
     *
     * @param Order $order
     * @return bool
     */
    private function deleteOrderEntities(Order $order): bool
    {
        try {
            $this->deleteInvoices($order);
            $this->deleteShipments($order);
            $this->deleteCreditMemos($order);

            if ($order->canUnhold()) {
                $order->unhold();
            }

            $this->orderRepository->delete($order);

            return true;
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Could not delete order %1: %2', $order->getId(), $e->getMessage()));
            return false;
        }
    }

    /**
     * Delete invoices
     *
     * @param Order $order
     * @return void
     */

    private function deleteInvoices(Order $order): void
    {
        $invoices = $order->getInvoiceCollection();
        foreach ($invoices as $invoice) {
            $this->invoiceRepository->delete($invoice);
        }
    }

    /**
     * Delete shipments
     *
     * @param Order $order
     * @return void
     * @throws CouldNotDeleteException
     */
    private function deleteShipments(Order $order): void
    {
        $shipments = $order->getShipmentsCollection();
        foreach ($shipments as $shipment) {
            $this->shipmentRepository->delete($shipment);
        }
    }

    /**
     * Delete credit memos
     *
     * @param Order $order
     * @return void
     * @throws CouldNotDeleteException
     */
    private function deleteCreditMemos(Order $order): void
    {
        $creditmemos = $order->getCreditmemosCollection();
        foreach ($creditmemos as $creditmemo) {
            $this->creditmemoRepository->delete($creditmemo);
        }
    }
}
