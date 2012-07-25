Yahoo! Finance Quotes Importer for Codeigniter

A Codeigniter controller is used to call methods in a model class to import Yahoo! finance data, specifically market quotes.

The code offers either CSV or YQL data imports. Yahoo Query Language offers 2 formats, JSON & XML, both are supported.

Example symbols are set in the config file (application/config/yahoo_quotes.php)

SQL for the import table is supplied. It combines all the fields from both the CSV and YQL services. 

If you only need a subset of these fields, the table could be cut down to suit. 

Unfortunately the 2 result sets (CSV, YQL) do not always share the same fields for the same data, subsequenly the table is
un-normalised and offered for example purposes only.

The code was developed with Codeigniter 2.1.2  

XML is imported using the XML2Array library (http://www.lalit.org/lab/convert-xml-to-array-in-php-xml2array)