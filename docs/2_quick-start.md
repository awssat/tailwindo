---
prev: 2_installation
next: false
---

# Quick Start

## Convert a whole directory 
just the files in a directory, it's not recursive
```bash
tailwindo path/to/directory/ 
```
## Recursively convert a whole directory 
```bash
tailwindo path/to/directory/ --recursive=true
```
You can also use the short hand `-r true` instead of the full `--recursive=true`

## Convert different file extensions
This will allow you to upgrade your `vue` files, `twig` files, and more!
```bash
tailwindo path/to/directory/ --extensions=vue,php,html
```
You can also use the short hand `-e vue,php,html` instead of the full `--extensions`

## Overwrite the original files
```bash
tailwindo path/to/directory/ --replace=true
```
::: tip
Please note this can be considered a destructive action as it will replace the original file and will not leave a copy of the original any where.
:::


## Convert one file
By default this will copy the code into a new file like file.html -> file.tw.html
```bash
tailwindo file.blade.php
```
This option works with the `--replace=true` option too.

## Convert raw code (a snippet of code)
just CSS classes:

```bash
tailwindo 'alert alert-info'
```

Or html:

```bash
tailwindo '<div class="alert alert-info mb-2 mt-3">hi</div>'
```

## Extract changes to a single CSS file
 Extract changes as components to a separate css file (tailwindo-components.css).

```bash
tailwindo --components=true  path/to/directory/ 
```

For example if you have a file called demo.html and contains:
```html
<div class="alert alert-info mb-2 mt-3">Love is a chemical reaction, soul has nothing to do with it.</div>
```

and runs:
```bash
tailwindo --components=true demo.html
```

then Tailwindo will not change demo.html and create a CSS file called 'tailwindo-components.css' that contains: 
```
.alert {
	@apply relative px-3 py-3 mb-4 border rounded;
}
.alert-info {
	@apply bg-teal-200 bg-teal-300 bg-teal-800;
}
```

This will let you keep older markup unchanged and you can just add the new extract components to your main css file.


### Supported Frameworks
You can specify what CSS framework your code is written in, by using`framework` option in the command line. 

#### Currently we support these frameworks: 
- Bootstrap


```bash
tailwindo --framework=bootstrap demo.html
```