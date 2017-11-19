# Tailwindo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/tailwindo.svg?style=flat-square)](https://packagist.org/packages/awssat/tailwindo)
[![StyleCI](https://styleci.io/repos/110390721/shield?branch=master)](https://styleci.io/repos/110390721)
[![Build Status](https://img.shields.io/travis/awssat/tailwindo/master.svg?style=flat-square)](https://travis-ci.org/awssat/tailwindo)


This tool can convert Boostrap CSS classes in HTML code to equivalent Tailwind CSS classes, still not perfect but good as a helper tool.


## Using the command line

You can install the package via composer globally:

`$ composer global require awssat/tailwindo`

Then use it to convert a snippet, a file or a folder.

### Convert a code
just CSS classes:

```bash
$ tailwindo 'alert alert-info'
```

Or html:

```bash
$ tailwindo '<div class="alert alert-info mb-2 mt-3">hi</div>'
```

### Convert a file (in a new file like file.html -> file.tw.html)
```bash
$ tailwindo file.blade.php
```

### Convert a folder (only php and html files will be converted to new files)
```bash
$ tailwindo path/to/folder`
```

## Using the package

You can install the package via composer locally in your project folder:

```bash 
$ composer require awssat/tailwindo
```

Then use it like this: 

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
