#Ping-Pong Game Tracker
##About
A CakePHP application to track games of table tennis. Designed to allow my office to track our games of table tennis at lunchtimes.  

Allows adding of a list of players and their relevant departments and will save matches, allow generation of stats and simple rankings.  

This is an ongoing project and is not supported. Feel free to contribute and I welcome code review if anything doesn't look right, please raise an issue or fork and send a pull request.

##Requirements
* [CakePHP](http://cakephp.org/) 2.2.4+
* [MySQL 5]()

##Installation
###Get the code
You can download and unzip the site into a folder.  
**OR**  
Clone the repository `git clone git@bitbucket.org:davidyell/ping-pong-tracker.git`

###Database
You can create the database schema using the Cake shell.  

Inside your `/app` folder run, `Console/cake schema create`

##What's not included
The system does not include any admin interface, login or cms. If you want to add this, then feel free to add it yourself. You can bake out basic admin, [using the Cake shell](http://book.cakephp.org/2.0/en/console-and-shells/code-generation-with-bake.html).

##Branch strategy
Development and issues should be developed in the `dev` branch before being merged into `master`. `master` should remain clean, stable and bug free.

##License
<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Ping-Pong Tracker</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://paperninja.co.uk/" property="cc:attributionName" rel="cc:attributionURL">David Yell</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.<br />Based on work at <a xmlns:dct="http://purl.org/dc/terms/" href="https://bitbucket.org/davidyell/ping-pong-tracker" rel="dct:source">https://bitbucket.org/davidyell/ping-pong-tracker</a>.