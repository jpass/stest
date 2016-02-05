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
I use phpspec do describe library classes responsible for generating tabs content.


Basic problems
--------------

1. varnishlog
We have 2 classes. 

VarnishLogParser is responsible for matching single line of log against regexps and return some type of parsed content eg. request url from that line
  
VarnishLogReader is used as data repository. We pass it parser and call read($path) method with file path as argument. It loads data into internal array. 
Then we can call methods like getTopHosts($limit). 

This reader is very simple and have some limitations. We load whole file into memory, and we parse every line for every method call. 
We can improve it with putting parsed logs into sql/nosql database and use it to generate top lists.
  
2. Retrieve rss content from url

We create another reader class that is responsible for getting content from url and sorting retrieved articles.

3. Retrieve json content from url
 
We read content from url and return it as json response type. Sorting is done on frontend.


Architecture
------------

I use bootstrap as html/css framework. For javascript jQuery will do the job.
Bower is used for frontend libraries management.

For backend i chose symfony framework 2.8, as it is my favorite.
To keep it simple everything is put into single controller.

We have 2 data sources that are based on remote content. 
User shouldn't wait for requests to finish so i split every tab with its own api endpoint and use ajax to retrieve tabs.

First tab can be preloaded with content so we use symfony render in twig. That way we can always switch to javascript.

Comments
--------

I do not parse articles dates for displaying. On phpside we could use simple DateTime with format or Carbon. 
Dates from json feed are more human friendly, but we could still re-parse them and display using Date Format library or something similar.
