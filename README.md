# Expresso Store: Order Export

This is an example extension for Expresso Store. It uses the
[store_order_complete_end](https://exp-resso.com/docs/extension_hooks.html#store_order_complete_end) hook,
which is executed as each order is marked as "complete" in Store (generally when the payment is approved).

In this example orders are formatted as XML and saved to the filesystem, but it would be trivial to modify
the code to post orders to a remote service (for example), or to output JSON instead.

To adjust the XML output format, see the [views/order.php](https://github.com/expressodev/store_order_export/blob/master/system/expressionengine/third_party/store_order_export/views/order.php) file.
