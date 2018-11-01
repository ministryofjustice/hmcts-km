# IMB Members website

This is a WordPress project used by IMB for its IMB Members website.

This website is used by IMB members as a reference manual to support them in their role, as well as to keep up to date with the latest news from IMB.

## User Accounts

The following WordPress user roles are in use:

- **Admin/Editor:** able to manage website content
- **Subscriber:** able to view website content

Anonymous users cannot view the website – users must login before seeing content.

## Requirements

- PHP >= 7.1
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- Docker & docker-compose - [Install](https://www.docker.com/docker-mac)
- Dory (docker proxy for local development) - [Install](https://github.com/FreedomBen/dory)
- To build CSS/JS assets locally, you'll also need:
  - node 10 – known to work on node v10.4.1 (npm v6.1.0)
  - bower
  - gulp

## Getting Started

1. Clone this repo to your local machine.

    ```bash
    git clone git@github.com:ministryofjustice/wp-imbmembers.git .
    rm -rf .git
    ```

2. Create a `.env` file by copying from `.env.example`:

    ```bash
    cp .env.example .env
    ```

    The `SERVER_NAME` variable should be `imbmembers.docker`. The website will be accessible at http://imbmembers.docker when run using `docker-compose` and `dory`.

    Generate keys and salts to replace the dummy values.

3. Build the project locally. This will install composer dependencies on your local filesystem.

    ```bash
    make build
    ```

    If you experience any errors at this point, it may be due to being unable to access the private composer repository. [More details here](#private-composer-repository).

4. Start the dory proxy, if it's not already running.

    ```bash
    dory up
    ```

    If you get an error message when trying to start dory, make sure you have docker running.

5. Build and run the docker image.

    ```bash
    make run
    ```

6. Once the docker image has built and is running, you should be able to access the running container by going to http://imbmembers.docker.

    You will need to run through the WordPress installation wizard in your browser.

    The WordPress admin area will be accessible at `/wp/wp-admin`.

## Tests

### Code linting

PHP CodeSniffer is used to maintain a consistent PHP code style throughout the project.

To run PHP CodeSniffer, run the following command from the main project directory:

```
vendor/bin/phpcs
```

Some syntax errors can be fixed automatically. This can be achieved using the command:

```
vendor/bin/phpcbf
```

### Feature tests

[Behat](http://behat.org/) feature tests exist in the `features/` directory. These are used to test functionality of the website which differs from standard 'out of the box' WordPress functionality. They aren't comprehensive, but they do capture much of the behaviour expected from the website.

1. Run the application locally.

    ```bash
    make run
    ```
2. Seed the database so that it's in the state expected by the test suite.

    **Warning!** This will reset your local database, so be sure to take a backup if you want to keep it.

    ```
    docker-compose exec wordpress features/seed-database.sh
    ```

    This command will execute the `features/seed-database.sh` script in the running docker container.
3. Run the test suite with command:

    ```
    vendor/bin/behat
    ```

#### Testing JavaScript functionality

The default Behat driver does not support JavaScript execution. This works fine for the existing tests. However, if JavaScript functionality needs to be tested, it's possible to use a Google Chrome driver to facilitate those tests.

Feature tests requiring JavaScript must be tagged with `@javascript`.

Google Chrome must be running with remote debugging enabled in order for these tests to run. On macOS, this can be done by running:

```
/Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222
```

**Note:** if Chrome is already running, you must quit it before running the above command. Otherwise this command will just open a new window in the currently running instance of Chrome, which won't have remote debugging enabled.

## Composer + WordPress plugins

The installation of WordPress core and plugins is managed by composer.

See `composer.json` for the required packages.

Plugins in the [WordPress plugin repository](https://wordpress.org/plugins/) are available from [WordPress Packagist](https://wpackagist.org/) (wpackagist).

Premium and custom plugins used by MOJ are available in the private composer repository [composer.wp.dsd.io](https://composer.wp.dsd.io).

### WordPress Packagist plugins

Wpackagist plugins are named by their slug on the WordPress plugin repository, prefixed with the vendor `wpackagist-plugin`.

Some examples:

| Plugin name | WordPress plugin URL                         | URL slug      | package name                      |
| ----------- | -------------------------------------------- | ------------- | --------------------------------- |
| Akismet     | https://wordpress.org/plugins/akismet/       | akismet       | `wpackagist-plugin/akismet`       |
| Hello Dolly | https://wordpress.org/plugins/hello-dolly/   | hello-dolly   | `wpackagist-plugin/hello-dolly`   |
| Yoast SEO   | https://wordpress.org/plugins/wordpress-seo/ | wordpress-seo | `wpackagist-plugin/wordpress-seo` |

#### Example: Installing Akismet plugin

Run the following command:

```
composer require "wpackagist-plugin/akismet" "*"
```

This will install the latest version of [Akismet](https://wordpress.org/plugins/akismet/) using the corresponding [wpackagist package](https://wpackagist.org/search?q=akismet).

### Private composer repository

The private composer repository [composer.wp.dsd.io](https://composer.wp.dsd.io) contains premium and custom WordPress plugins.

Access to this repository is restricted. Refer to internal documentation for further details.

## WP-CLI

The [WordPress CLI](https://wp-cli.org/) is a useful tool for running commands against your WordPress installation.

To use WP-CLI, your docker container must already be running. (This will probably be running in a separate terminal session/tab.)

1. Run:

    ```bash
    make bash
    ```

    A bash session will be opened in the running container.

2. The WP-CLI will be available as `wp`.

    For example, to list all users in the install:

    ```bash
    wp user list
    ```

## Email delivery

When running locally for development, emails sent by WordPress are not delivered. Instead they are captured by [mailcatcher](https://mailcatcher.me/).

To see emails, go to http://mail.imbmembers.docker.

This will load a webmail-like interface and display all emails that WordPress has sent.

## Make commands

There are several `make` commands configured in the `Makefile`. These are mostly just convenience wrappers for longer or more complicated commands.

| Command           | Descrption                                                                                                                                                                                           |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `make build`      | Run the build script to install application dependencies and build theme assets. This will typically involve installing composer packages and compiling SASS stylesheets.                            |
| `make clean`      | A less destructive version of `make deep-clean`. This will remove untracked & ignored files, but preserve the `.env` file and media uploads directory.                                               |
| `make deep-clean` | Alias of `git clean -xdf`. Restore the git working copy to its original state. This will remove uncommitted changes and ignored files.                                                               |
| `make run`        | Alias of `docker-compose up`. Launch the application locally using `docker-compose`.                                                                                                                 |
| `make bash`       | Open a bash shell on the WordPress docker container. The [WP-CLI](https://wp-cli.org/) is accessible as `wp`. The application must already be running (e.g. via `make run`) before this can be used. |
| `make test`       | Run tests on the application. Out of the box this will run PHP CodeSniffer (code linter).                                                                                                            |

## Bedrock

This project is based on Bedrock. Therefore, much of the Bedrock documentation will be applicable.

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
