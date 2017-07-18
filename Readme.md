# Unnamed Framework
-- PLEASE NOTE: I started this Framework on Sunday, July 16th, 2017 as a way to help build complete systems. Please keep
that in mind when you are looking over the code, and documentation. I do not have any contributors to assist with this
project. If you would like to contribute, please contact me, I will add your information to the credits. I will soon
start a complete Usergroup, plugin repository, and documentation system on a website once this project gets traction. If 
you have any commits, please don't hesitate to leave a commit, or contact me.

This **Framework**, although does not have an actual name as of yet. Is the beginning work of several functions, and 
scripts compiled into one easy to use call. This framework is one of the simplest frameworks you'll ever use. This 
system allows you to build a complete system with one call on your index page. 

There is no MVC method built into this Framework, this is a simple system that allows you to have several code snippets
to give your coding more functionality with the ability to reuse code.

I wanted the ability to easily create new plugins simply by placing a directory in a user defined ETC folder and it
will _simply just work_. Plugins can be enabled or disabled simply by changing the load variable in the config file 
located inside the plg_ directory to false.

For example:
```PHP
$config = array(
	"LOAD"=>"TRUE",
	"NAME"=>"SYSTEM",
	"VERSION"=>"1.4.2"
);
```

## Getting Started

Take a look at the Wiki... There is much gooder info there!
