<h1><strong>Delete Orders Module for Magento 2</strong></h1>
<p>The "<strong>Delete Orders</strong>" module for Magento 2 allows store administrators to delete orders directly from the Magento admin panel. This feature is particularly useful for removing test orders or any orders that are no longer needed, helping maintain a clean and organized order management system.</p>
<h2>Features</h2>
<ul>
<li><strong>Mass Delete Orders</strong>: Delete multiple orders at once from the order grid in the admin panel.</li>
<li><strong>Delete Individual Order</strong>: Delete specific orders from the order view page.</li>
<li><strong>Comprehensive Deletion</strong>: Along with the order, related invoices, shipments, and credit memos are also deleted.</li>
<li><strong>ACL Control</strong>: Access control to restrict the deletion feature to specific admin roles.</li>
<li><strong>Enable/Disable Module</strong>: Flexibility to enable or disable the module from the admin configuration.</li>
</ul>
<h2><strong>Installation</strong></h2>
<h3>Via Composer</h3>
<ol>
<li>Run the following command in your Magento root directory:</li>
</ol>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">composer require techimprovement/module-delete-orders
</code></strong></div>
</div>
<ol start="2">
<li>Enable the module:</li>
</ol>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento module:<span class="hljs-built_in">enable</span> TechImprovement_DeleteOrders
</code></strong></div>
</div>
<ol start="3">
<li>Upgrade the database:</li>
</ol>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento setup:upgrade
</code></strong></div>
</div>
<ol start="4">
<li>Clear the cache:</li>
</ol>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento cache:clean
</code></strong></div>
</div>
<h3>Manually</h3>
<ol>
<li>Download the module's ZIP file and extract it.</li>
<li>Create a folder path <strong><code>app/code/TechImprovement/DeleteOrders</code></strong> in your Magento root directory and copy the extracted files there.</li>
<li>Run the following commands in your Magento root directory:</li>
</ol>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento module:<span class="hljs-built_in">enable</span> TechImprovement_DeleteOrders
</code></strong></div>
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento setup:upgrade
</code></strong></div>
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento cache:clean
</code></strong></div>
</div>
<h2><strong>Configuration</strong></h2>
<ol>
<li>Navigate to <code><strong>Stores &gt; Configuration &gt; TechImprovement &gt; Delete Orders</strong></code> in your Magento admin panel.</li>
<li>Enable the module and configure it according to your needs.</li>
</ol>
<h2><strong>Usage</strong></h2>
<ul>
<li>To delete individual orders, open the order view page and click on the "Delete Order" button.</li>
<li>To mass delete orders, select the orders from the order grid, choose the "Delete Order(s)" action from the mass action dropdown, and submit.</li>
</ul>
<h2><strong>Compatibility</strong></h2>
<p>This module is tested and compatible with Magento CE, EE versions 2.4.6.x.</p>
<h2><strong>Uninstallation</strong></h2>
<p>To uninstall the module, run the following command:</p>
<div class="dark bg-gray-950 rounded-md">
<div class="p-4 overflow-y-auto"><strong><code class="!whitespace-pre hljs language-bash">php bin/magento module:uninstall TechImprovement_DeleteOrders
</code></strong></div>
</div>
<h2><strong>Support</strong></h2>
<p>For any issues or feature requests, please contact the module developer at <a title="info@techimprovement.com" href="mailto:info@techimprovement.com">info@techimprovement.com</a>.</p>
