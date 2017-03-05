<p align="center"><img src="http://cdn.bulbagarden.net/upload/thumb/a/a6/678Meowstic.png/250px-678Meowstic.png"></p>

*Note: Meowstic is still in early development. It not functional yet.*

## About

Meowstic is a collection of Laravel helper scripts I use often for my projects.

Instead of having to maintain separate sh files in each repo, I decided to make it into a composer package instead.

## Installation

`$ composer global require wavehack/meowstic`

## Usage

### Convert

```
$ cd path/to/project
$ meowstic convert
```

Converts a traditional Laravel project directory structure to a more sophisticated layout I use for my projects.

The basic gist of it is that source code now resides in `src/`, Artisan in `bin/` and moves the directories `bootstrap`, `config`, `database`, `resources`, `routes` and `storage` to a new `app/`.

This command is only tested on a fresh Laravel project. It might produce unwanted results on a bigger existing codebase.

More specifically:

- Creates a `bin/` directory and moves `artisan` from the project root to there.
- Moves source code from `app/` to `src/`.
- Creates a `src/Application.php` with the path overrides.
- Creates an `app/` directory and puts in the following directories normally in the root of the project:
  - `bootstrap`
  - `config`
  - `database`
  - `resources`
  - `routes`
  - `storage`
- Changes the following files to fix paths:
  - `app/bootstrap/app.php` (including using our own `Application` class override)
  - `app/bootstrap/autoload.php`
  - `app/config/view.php` for our new views path
  - `bin/artisan`
  - `src/Console/Kernel.php` for our new console routes path
  - `src/Providers/BroadcastServiceProvider.php` for our new channel routes path
  - `src/Providers/RouteServiceProvider.php` for our new api and web routes path
  - `composer.json` for changing the psr-4 autoload path from app/ to src/

*todo: more info*

### Init

*todo*

### Deploy

*todo*

## License

Meowstic is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
