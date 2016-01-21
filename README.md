stest
=====

Task
----

Show 3 tabs.
1. Parsed varnish log file showing top requested 5 hosts and top 5 requested files
2. Get rss-feed and display title, publication date of articles - newest first
3. Get json-feed and display data - newest first 


TDD
---
We will use phpspec do describe library classes responsible for generating tabs content.


Basic problems
--------------

1. varnishlog
We create 2 classes. 

VarnishLogParser is responsible for matching single line of log against regexps and return some type of parsed content eg. request url from that line
  
VarnishLogReader is used as data repository. We pass it parser and call read($path) method with file path as argument. It loads data into internal array. 
Then we can call methods like getTopHosts($limit). This reader is very simple and have some limitations. We load whole file into memory, and we parse every line for every method call.
  
2. Retrieve rss content from url

We create another reader class that is responsible for getting content from url.

3. Retrieve json content from url
 
We can reuse reader class from 2.

Architecture
------------

We use bootstrap as html/css framework. For javascript we use jQuery for simplicity.
Bower is used for frontend libraries management.

We have 2 data repos that are based on outside content. 
We shouldn't wait for requests to finish so we split every tab with its own api endpoint and use ajax to retrieve tabs.
First tab can be loaded with content so we use symfony's render in twig. That way we can always switch to javascript.
