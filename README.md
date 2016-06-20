# Pico-Random-Page

A plugin for the flat file CMS [Pico](https://github.com/picocms/Pico). Using this plugin, you can open a random page
from your Pico site by using a special link such as `yoursite.com/random`.

You can optionally scope the link to only get a random page from within a folder. For example, the link
`yoursite.com/blog/random` will only choose from pages in the `blog` folder.

## Installation

Copy the file `00-PicoRandomPage.php` to the `plugins` subdirectory of your Pico installation directory. Now you should
be able to access e.g. yoursite.com/random or yoursite.com/subfolder/random and be redirected to a random page from the
folder in question.

## Excluding pages

You may have certain pages that you don't want to include as a possible result. You can specify these pages as an array
of strings in your config file in order to exclude them. Specify the pages you want to exclude by their paths relative
to the root of your site.

```
$config['random_page_excludes'] = [
	'index',
	'work/in/progress'
];
```