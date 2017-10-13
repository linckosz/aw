DEEZER test By Bruno Martin (September 14th, 2017)
==============

Server machine Operating system
--------------
The application has been developed and tested on the following system (LNMP):
   - CentOS 6.9 (64bit)
   - nginx 1.10.2
   - MariaDB Server 10.2.6
   - Server API FPM/FastCGI
   - PHP 7.0.20
   - PHP Modules<br />
bcmath bz2 calendar Core ctype curl date dba dom enchant exif fileinfo filter ftp gd geoip gettext hash iconv igbinary imagick imap interbase intl json json_post ldap libxml maxminddb mbstring mcrypt memcache memcached mongodb msgpack mysqli mysqlnd OAuth openssl pcntl pcre PDFlib PDO PDO_Firebird pdo_mysql pdo_sqlite Phar pinyin posix pspell readline recode Reflection session shmop SimpleXML snmp soap sockets SPL sqlite3 ssh2 standard sysvmsg sysvsem sysvshm tidy tokenizer uploadprogress wddx xdebug xdiff xml xmlreader xmlrpc xmlwriter xsl Zend OPcache zip zlib Xdebug Zend OPcache

Test machine Operating system
--------------
All tests have been done using the following environment.<br />
Even if the code has been thought cross-compatible, it needs to be tested on other browsers.
   - Windows 8.1 (64-bit) English
   - Google Chrome Version 60.0.3112.113 (Official Build) (64-bit)

Installation
--------------
1. NGINX
   - The file '/_INSTALLATION/app.conf' contains the nginx configuration needed.
   - Make sure to adapt those files according to your server, especially pathes.
   - Include the path to this file into your nginx confguration file.

2. SSL<br />
SSL for the domain brunoaw.tk are available here:
   - '/_INSTALLATION/ssl.crt'
   - '/_INSTALLATION/ssl.key'

3. LINUX permission<br />
Launch a LINUX bash command to insure all permissions are setup correctly.<br />
Need to go the the root directory of the application first.
```
# cd /path_to
# sh /_INSTALLATION/permission root
# yum install realpath
# service nginx restart
```

NOTE
--------------
It should be pretty obvious, but I'd prefer to remind that this code structure is not production-ready, it's only for candidature purpose.<br />
Since user authentication was not allowed, I just used a API key to secure the communication.<br />
Here are some advantages of this super-light MVC Framework:
   - We can load only the bundles we need for a specific request (only if we want, this can help to have one singular code to maintain for frontend and backend, it can help to save time).
   - Can insert PHP variables inside HTML code like twig does.
   - Any JS file, CSS file, or picture modified will be automatically refreshed on client side, the application recognize the modification timestamp of each file, no need manual operation from the developer (for example, no need to hardly code '/images/toto.png?v=2').
   - All Errors, JS and PHP, are stored in the directories '/logs/js' and '/logs/php'.
   - By using the method '/libs/Watch::php()', we can watch PHP variables, data are stored in the directory '/logs'.
<br />
<br />
<br />
<br />
<br />
<br />
--------------

Subject: Design and develop an HTML5/JS app allowing the user to answer a quiz and display the results
==============
Main features:
   - Select a quiz (in a list of quizzes)
   - Answer the questions
   - Display the result
   - Display the previous results (store locally in a file or a variable, no need to use a database)


Demo page
--------------
https://brunoaw.tk


Conclusion
==============
Thank you for taking the time to consider my candidature as a Senior Developer.<br />
I wish that you will be able to see the skills you are looking for in this source code.

Regards,

Bruno Martin
