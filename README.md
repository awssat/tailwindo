# Tailwindo

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awssat/tailwindo.svg?style=flat-square)](https://packagist.org/packages/awssat/tailwindo)
[![StyleCI](https://styleci.io/repos/110390721/shield?branch=master)](https://styleci.io/repos/110390721)
[![Build Status](https://img.shields.io/travis/awssat/tailwindo/master.svg?style=flat-square)](https://travis-ci.org/awssat/tailwindo)


<p align="center">
  <img src="https://pbs.twimg.com/media/DQ-mDgSX0AUpCPL.png">
</p>
                                                                         


This tool can convert Boostrap CSS classes in HTML code to equivalent Tailwind CSS classes, still not perfect but good as a helper tool.

## Media Coverage 
- [Laravel News: Convert your Bootstrap CSS to Tailwind with Tailwindo](https://laravel-news.com/tailwindo)
- [Laravel Arabic: تحويل صفحات Bootstrap إلى Tailwind مع حزمة Tailwindo](https://laravel-ar.com/article/37/%D8%AA%D8%AD%D9%88%D9%8A%D9%84-%D8%B5%D9%81%D8%AD%D8%A7%D8%AA-bootstrap-%D8%A5%D9%84%D9%89-tailwind-%D9%85%D8%B9-%D8%AD%D8%B2%D9%85%D8%A9-tailwindo)

## Installing `tailwindo` for CLI use

You can install the package via composer globally:

`$ composer global require awssat/tailwindo`

Then use it to convert a snippet, a file or a folder.

### Using the command

#### Possible Options
##### Convert a directory (just the files in this directory, it's not recursive)
```bash
$ tailwindo path/to/directory/ 
```
##### Recursively convert a directory
```bash
$ tailwindo path/to/directory/ --recursive=true
```
You can also use the short hand `-r true` instead of the full `--recursive=true`

##### Convert different file extensions
This will allow you to upgrade your `vue` files, `twig` files, and more!
```bash
$ tailwindo path/to/directory/ --extensions=vue,php,html
```
You can also use the short hand `-e vue,php,html` instead of the full `--extensions`

##### Overwrite the original files
_Please note this can be considered a destructive action as it will replace the orignal file and will not leave a copy of the original any where._
```bash
$ tailwindo path/to/directory/ --replace=true
```

##### Convert raw code
just CSS classes:

```bash
$ tailwindo 'alert alert-info'
```

Or html:

```bash
$ tailwindo '<div class="alert alert-info mb-2 mt-3">hi</div>'
```

### Convert a file
By default this will copy the code into a new file like file.html -> file.tw.html
```bash
$ tailwindo file.blade.php
```
This option works with the `--replace=true` option

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
