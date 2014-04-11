# Expresso Store: Order Export extension

This is an example extension for Expresso Store. It uses the
[store_order_complete_end](https://exp-resso.com/docs/extension_hooks.html#store_order_complete_end) hook,
which is executed as each order is marked as "complete" in Store (generally when the payment is approved).

In this example orders are formatted as XML and saved to the filesystem, but it would be trivial to modify
the code to post orders to a remote service (for example).
