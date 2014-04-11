<?php

class Store_order_export_ext
{
    public $name = 'Store Order XML Export';
    public $version = '1.0.0';
    public $description = 'Saves new orders as XML to the filesystem';
    public $docs_url = 'https://exp-resso.com/docs';
    public $settings_exist = 'y';
    public $settings = array();

    public function __construct($settings = array())
    {
        $defaults = array();
        foreach (array_keys($this->settings()) as $key) {
            $defaults[$key] = null;
        }
        $this->settings = array_merge($defaults, $settings);
    }

    public function settings()
    {
        $settings = array();
        $settings['output_dir'] = './orders/';

        return $settings;
    }

    public function activate_extension()
    {
        $data = array(
            'class'     => __CLASS__,
            'method'    => 'store_order_complete_end',
            'hook'      => 'store_order_complete_end',
            'priority'  => 10,
            'settings'  => '',
            'version'   => $this->version,
            'enabled'   => 'y'
        );

        ee()->db->insert('extensions', $data);
    }

    /**
     * This hook is called after each order is "completed"
     * We use it to create an XML export and save it to the filesystem
     */
    public function store_order_complete_end($order)
    {
        // render the order as XML and save to disk
        $path = $this->output_dir().$order->id.'.xml';
        $xml = require __DIR__.'/views/order.php';

        // let's make the output prettier using DOM
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        file_put_contents($path, $dom->saveXML());
    }

    /**
     * Figure out the actual output location for order XML files
     *
     * @return string
     */
    public function output_dir()
    {
        if ('/' === substr($this->settings['output_dir'], 0, 1)) {
            // absolute output path
            $dir = $this->settings['output_dir'].'/';
        } else {
            // relative to system path
            $dir = APPPATH.'/../'.$this->settings['output_dir'].'/';
        }

        if (!is_dir($dir)) {
            @mkdir($dir);
            if (!is_dir($dir)) {
                show_error('Invalid output directory');
            }
        }

        return realpath($dir).'/';
    }
}
