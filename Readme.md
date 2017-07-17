# Unnamed Framework

This **Framework**, although does not have an actual name as of yet. Is the beginning work of several functions, and 
scripts compiled into one easy to use call. This framework is one of the simplest frameworks you'll ever use. This 
system allows you to build a complete system with one call on your index page. 

I wanted the ability to easily create new plugins simply by placing a directory in a user defined ETC folder and it
will _simply just work_.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

* PHP 5.4 or greater
* bcmath
* bz2
* curl
* date
* dom
* ereg
* exif
* gd
* mbstring
* mcrypt
* session
* xml
* xmlreader
* xmlrpc
* xmlwriter
* zip
* zlib

```
Give examples
```

### Installing

A step by step series of examples that tell you have to get a development env running

Say what the step will be

```
Give the example
```

### And coding style tests
I have created several unique functions that may be used to build quick applications without reinventing the wheel. All
functions are available throughout the entire system, and a document is currently being built for the most advanced
programmers to the most beginner.
  
I am hoping this framework will be expanded all of the world and built to be the best system available for everyone.

Framework Functions:

Numeric Functions:

```PHP
echo clean_number('4f32k91025'); # will output 43291025
echo decimal_to_fraction(0.125); # will output 1/8
echo fraction_to_decimal('1/8'); # will output 0.125
echo (is_whole_number(45) ? "TRUE" : "FALSE"); # will output TRUE
echo return_whole_number(45.34); # will output 45
echo return_decimal_number(45.34); # will output 0.34
echo ordinalize(3); # will output 3rd
echo parity(3); # will output 0
```
Address Functions:

```PHP
echo getDistanceBetweenPoints(39.103119, -84.512016, 36.850769, -76.285873); # Example is Cincinnati, OH to Norfolk, VA -- will output Array
Array ( [miles] => 474.044402345 [feet] => 2502954.44438 [yards] => 834318.148127 [kilometers] => 762.900514648 [meters] => 762900.514648 )

echo getAddressFromPoints (39.103119, -84.512016)# Example is Cincinnati, OH -- will output Array
Array ( [formatted_address] => 609 Walnut St, Cincinnati, OH 45202, USA [street_number_long] => 609 [street_number_short] => 609 [street_name_long] => Walnut Street [street_name_short] => Walnut St [street_type] => route [city_name_long] => Cincinnati [city_name_short] => Cincinnati [county_name_long] => Hamilton County [county_name_short] => Hamilton County [state_name_long] => Ohio [state_name_short] => OH [country_name_long] => United States [country_name_short] => US [zipcode_long] => 45202 [zipcode_short] => 45202 [zipcode_ext_long] => 1191 [zipcode_ext_short] => 1191 )

echo AddressToPoints ('10 Fountain Square, Cincinnati, OH 45202')# will output 39.1019474, -84.5123371
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [PHP](http://www.php.net) - The best server side programming environment

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Jessica Brown** - *Initial work* - [Personal Site](https://www.jbrowns.com)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* etc
