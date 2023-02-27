Clean Architecture in a PHP application
===

COPYRIGHT DISCLAIMER
---

This application is based on the example [application](https://kevinsmith.io/modern-php-without-a-framework/) by
Kevin Smith.
Here is the related [GitHub repository](https://github.com/kevinsmith/no-framework) containing the original source
code.
Please, consult the copyright and licence notices distributed with the orignal code by Kevin Smith.

General
---

The idea is to build a relatively simple PHP application but without using any framework. I followed closely the
recipe given in a wonderful and very detailed [article](https://kevinsmith.io/modern-php-without-a-framework/) by 
Kevin Smith. 

In addition, the application is so structured as to illustrate the most important principles of Clean Architecture and
Use Case driven development. The application itself is a variation of a Hello World, but with a following additions:

- greetings are displayed randomly
- greeting messages are persisted in a local database
- each greeting has an author associated with it
- an authenticated user can edit the author of any greeting

There is an excellent video by [Nicolas De Boose](https://www.youtube.com/watch?v=LTxJFQ6xmzM) explaining benefits
of using Clean Architecture specifically for PHP development. I highly recommend it.

Illustrated principles:
---

1. Hexagonal or "Ports and Adapters" architecture
2. All dependencies are directed towards the core, "outside-in"
3. Core is completely independent of the infrastructure
4. Clean Architecture based on explicit use cases
5. DDD modeling: Entities, Value Objects
6. Immutable objects
7. Repository pattern
8. Testable core
9. Domain exceptions hierarchy

Running:
---

- Requires PHP 8.1 or later
- See `\ExampleApp\Infrastructure\Application\AppConfig::$props` global array for configurations
- Run a development server from the IDE:
```
> php.exe -S localhost:8080 -t public/
```
- Application should be available at `localhost:8080`

Clean Architecture metrics
---

There is a wonderful project by Valeriy Chetkov on GitHib: [php-clean-architecture](https://github.com/Chetkov/php-clean-architecture).
It allows to measure how "clean" the architecture of an application is according to the well-defined  metrics. To run 
the script you can execute the following command from the root directory of the project:

```
> php.exe .\vendor\bin\phpca-build-reports .\phpca-config.php
```

To visualize report, simply open the generated `phpca-reports/index.html` in the browser.

References:
---

1. [Kevin Smith, "Modern PHP Without a Framework"](https://github.com/kevinsmith/no-framework)
2. [Kevin Smith, GitHub](https://github.com/kevinsmith/no-framework)
3. [La clean architecture : pourquoi ? Comment ? Pour qui ? - Nicolas DE BOOSE - AFUP Day 2020 Lille](https://www.youtube.com/watch?v=LTxJFQ6xmzM)
4. [Robert. C. Martin, Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
5. [Herberto Graça, Ports and Adapters Architecture](https://herbertograca.com/2017/09/14/ports-adapters-architecture/)
6. [Valeriy Chetkov, PHP Clean Architecture](https://github.com/Chetkov/php-clean-architecture)
7. [Valeriy Chetkov, article on habr.com](https://habr.com/ru/post/504590/), only available in Russian
