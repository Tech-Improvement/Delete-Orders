<?php

namespace TechImprovement\DeleteOrders\Block\Adminhtml\Order;

class View extends \Magento\Sales\Block\Adminhtml\Order\View
{
    /**
     * Add delete order button
     *
     * @return void
     */
    protected function _construct(): void
    {
        parent::_construct();

        $orderId = $this->getOrderId();
        $url = $this->getUrl('techimprovement_deleteorders/order/delete', ['order_id' => $orderId]);

        $this->addButton(
            'delete_order',
            [
                'label' => __('Delete Order'),
                'class' => 'delete',
                'on_click' => sprintf("deleteConfirm('%s', '%s')", __('Are you sure you want to delete this order?'), $url),
                'sort_order' => 20,
            ]
        );
    }
}
