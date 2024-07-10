# GenDiff

### Statuses:
[![Maintainability](https://api.codeclimate.com/v1/badges/a846fa012b388f03784d/maintainability)](https://codeclimate.com/github/Ivan-Lysenko/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/a846fa012b388f03784d/test_coverage)](https://codeclimate.com/github/Ivan-Lysenko/php-project-48/test_coverage)

### Description
A PHP console application to compare JSON and YAML files, displaying differences in data.

### System requires
   [PHP](https://www.php.net/) 7+

### Installation
```sh
git clone https://github.com/abstract-point/GenDiff.git
cd GenDiff
make install
```   
### Using

```sh
./bin/gendiff [--format <fmt>] path/to/first_file path/to/second_file
```
Available formats: `plain` `stylish` `json` (default `stylish`)

#### How GenDiff work with .json files
[![asciicast](https://asciinema.org/a/b2f2qWR3jVG4umuvUqmBloq52.svg)](https://asciinema.org/a/b2f2qWR3jVG4umuvUqmBloq52)

#### How GenDiff work with .yaml files

[![asciicast](https://asciinema.org/a/ThBvPoVis9VKHIWAs74G98jmz.svg)](https://asciinema.org/a/ThBvPoVis9VKHIWAs74G98jmz)

#### How GenDiff display result in Stylish style

[![asciicast](https://asciinema.org/a/6H565cTXzDsp1lVgAkibTssgE.svg)](https://asciinema.org/a/6H565cTXzDsp1lVgAkibTssgE)

#### How GenDiff display result in Plain style

[![asciicast](https://asciinema.org/a/kziWrAlA8RDgu2b8QuOlTO0WP.svg)](https://asciinema.org/a/kziWrAlA8RDgu2b8QuOlTO0WP)

#### How DiffChecker display result in JSON style

[![asciicast](https://asciinema.org/a/xQH6HVpi1qUkwBAwZbpIQIbLE.svg)](https://asciinema.org/a/xQH6HVpi1qUkwBAwZbpIQIbLE)
