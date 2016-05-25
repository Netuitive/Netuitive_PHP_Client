Netuitive PHP Client
=====================

The [Netuitive](https://www.netuitive.com) PHP Client is a library that will allow a StatsD server to interface with your PHP application and create metrics to help monitor the performance of the application. It is designed to work with the [Netuitive Agent and the Netuitive StatsD server](https://github.com/Netuitive/omnibus-netuitive-agent).

For more information on monitoring your PHP applications with Netuitive, see our [help docs](https://help.netuitive.com/Content/Misc/Datasources/Netuitive/integrations/php.htm), or contact Netuitive support at [support@netuitive.com](mailto:support@netuitive.com).

Using the Netuitive PHP Client
-------------------------------

1. Download the client library.

1. Place the library in the same location as your PHP application(s).

1. Require the Netuitive PHP Client library.
        
        include 'StatsD_Client.php';
