# tailwindo

This package contains a class that can convert Boostrap CSS classes in HTML code to equivalent Tailwind CSS classes.

```php
use Abdumu\Tailwindo\Converter;

$input = '<div class="alert alert-danger">hi</div>'; //BootstrapCSS code

$output = (new Converter)
            ->setContent($input)
            ->convert()
            ->get(); // gets converted code
```


