# Tailwindo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/tailwindo.svg?style=flat-square)](https://packagist.org/packages/awssat/tailwindo)
[![StyleCI](https://styleci.io/repos/110390721/shield?branch=master)](https://styleci.io/repos/110390721)
[![Build Status](https://img.shields.io/travis/awssat/tailwindo/master.svg?style=flat-square)](https://travis-ci.org/awssat/tailwindo)


This tool can convert Boostrap CSS classes in HTML code to equivalent Tailwind CSS classes, still not perfect but good as a helper tool.


## Using the command line

You can install the package via composer globally:

`$ composer global require awssat/tailwindo`

Then use it like to convert a snippet, a file or a folder.

### convert a code
`$ tailwindo 'alert alert-info'`
`$ tailwindo '<div class="alert alert-info mb-2 mt-3">hi</div>'`

### convert a file (in a new file like file.html -> file.tw.html)
`$ tailwindo file.blade.php`

### convert a folder (only php and html files will be converted to new files)
`$ tailwindo path/to/folder`

## Using the package

You can install the package via composer locally in your project folder:

`$ composer require awssat/tailwindo`

then use it like this: 

```php
use Awssat\Tailwindo\Converter;

$input = '<div class="alert alert-danger">hi</div>'; //BootstrapCSS code

$output = (new Converter)
            ->setContent($input)
            ->convert()
            ->get(); // gets converted code
```


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.