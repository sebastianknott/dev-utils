# Development Utilities of Sebastian Knott

... or in short DUSK (Yeah. That's how I roll) is a tool set for my personal development projects. It helps me get
 things of the ground rather quick and keeps things hassle free and automated. I try to keep things civil, so it
  SHOULD work with php >= 7.2, but I will focus on running up-to-date versions of PHP. 
 
 ## Whats included?
 
 Here comes a short list of stuff you can find here.
 
 ### Unit Tests Tools
  
  For UnitTest I personally prefer the obvious.
  
 * [phpunit/phpunit](https://packagist.org/packages/phpunit/phpunit)
 * [mockery/mockery](https://packagist.org/packages/mockery/mockery)
 * [phake/phake](https://packagist.org/packages/phake/phake)
 * [hamcrest/hamcrest-php](https://packagist.org/packages/hamcrest/hamcrest-php)
 * [sebastianknott/hamcrest-object-accessor](https://packagist.org/packages/sebastianknott/hamcrest-object-accessor)
 * [infection/infection](https://packagist.org/packages/infection/infection)
 
 #### DevUtilsTestCase
 
 I included a new base class for unit tests called `DevUtilsTestCase`. This class will have an instance of faker and
  my personal `SystemUnderTestFactory`. Additionally the global functions of mockery and hamcrest are accessible in
   your test class. 
  ```php
 <?php
 
 use Mockery\MockInterface;
 use SebastianKnott\DevUtils\Test\Infrastructure\DevToolsTestCase;
 
 class ExampleTest extends DevToolsTestCase
 {
     public function testExample(){
         // Build your subject with mocked dependencies. There is
         // also a method for all you phake fans out there ^^
         $subjectBundle = self::$factory
             ->buildSutWithMockery(Example::class);
 
         // Access your subject by getting it from the bundle.
         $subject = $subjectBundle->getSubject();
 
         // Access the corresponding mocked constructor parameters
         // by name with array notation.
         /** @var MockInterface $firstParameter */
         $firstParameter = $subjectBundle['firstParameterName'];
 
         // Notice that you can access hamcrest functions globally
         // (e.g. `startsWith`)
         $firstParameter->shouldReceive('myTest')
             ->with(startsWith('bla'));
 
         // ... and faker stands by for your disposal
         $result = $subject->runMyStuff(self::$faker->address);
 
         assertThat($result, is(boolValue()));
     }
 }
 ```

### Deployer

I wrote two rather unusual recipes for deployer.

#### Recipe staticCodeAnalysis

This recipe contains targets for the tools found under Code Quality Tools.

dep \<command\> | What it does
------------  | -------------
sca              | Static Code Analysis - runs all sca commands in order
sca:lint         | Check for syntax errors
sca:phpcpd       | Check for copy/paste violations
sca:phpcs        | Runs Code Sniffer with my coding-standard
sca:phpcs:fix    | Runs Code Sniffer in fix mode
sca:phpmd        | Check for messy code
sca:phpstan      | Check for messy code with phpstan
sca:psalm        | Check for messy code with vimeos psalm

#### Recipe unitTest

This recipe contains targets for phpunit and infection to run efficiently.

dep \<command\> | What it does
------------  | -------------
test:infection   | Runs infections for phpunit. Has a dependency on test:phpunit
test:phpunit     | Runs phpunit tests
 
### Composer Libraries I like
 
There is a list of tools I really love and install sooner or later anyway.
 
* [bamarni/composer-bin-plugin](https://packagist.org/packages/bamarni/composer-bin-plugin) A great tool to install
  composer packages who expose binaries in vendor/bin without dependency problems.
* [davidrjonas/composer-lock-diff](https://packagist.org/packages/davidrjonas/composer-lock-diff) This little helper
 compares two composer.lock files and prints out the diff in easy to understand table.
* [dealerdirect/phpcodesniffer-composer-installer](https://packagist.org/packages/dealerdirect/phpcodesniffer-composer-installer) Installs Code Sniffer standards directly to Code sniffer. No path wrangling anymore.
* [fzaninotto/faker](https://packagist.org/packages/fzaninotto/faker) This tool generates any kind of lorem ipsum you
 may want.
* [infection/infection](https://packagist.org/packages/infection/infection) Puts your unit tests under the
 microscope and makes you a better programmer
* [mockery/mockery](https://packagist.org/packages/mockery/mockery) Mock stuff with eas.
* [mockery/mockery](https://packagist.org/packages/mockery/mockery) Mock stuff with eas.

### Code Quality Tools

All the tools I need with configurations compatible to each other.

* [squizlabs/php_codesniffer](https://packagist.org/packages/squizlabs/php_codesniffer)
* [vimeo/psalm](https://packagist.org/packages/vimeo/psalm)
* [sebastian/phpcpd](https://packagist.org/packages/sebastian/phpcpd)
* [phpstan/phpstan](https://packagist.org/packages/phpstan/phpstan)
* [phpmd/phpmd](https://packagist.org/packages/phpmd/phpmd)

For now everything is just a scaffold for things to come. Everything is stitched together by deployer. A simple `dep
 sca` should execute all tools.
 
Included with phpcs comes my own coding-standard. A pretty mellow mix between slevomats coding-standard and PSR-12.