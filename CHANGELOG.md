# 2.0.0
- :boom: **BC break**: now requires `oliverde8/php-etl-bundle` `^2.0`, `easycorp/easyadmin-bundle` `^5.0` and PHP `>=8.2`.
- :star2: Compatibility with EasyAdmin 5, Symfony 7/8 and PHP 8.4 (constructor promotion, `FormField::addFieldset`, native return types, `getUserIdentifier()`).
- :star2: V2 (typed PHP `ChainDefinitionInterface`) chains are now listed in the "New execution" form, alongside legacy YAML chains (via the `etl.chain_definition` tag).
- :wrench: Routing moved to native PHP attributes: `#[Route]` + `#[MapEntity]` on the download controller (dropped the abandoned `sensio/framework-extra-bundle` `@ParamConverter`), and `#[AdminRoute]` on the dashboard controller so it renders inside EasyAdmin's `AdminContext`.
- :wrench: Fixed the `code_editor` field template for EasyAdmin 5 (`ea()` accessor).
- :warning: The "run from the interface" flow for V2 chains requires the matching `oliverde8/php-etl-bundle` 2.0 fix that stores a string definition for object-based (V2) chain definitions.

# 1.1.0
- :star2: Support for phpEtlBundle 1.1 was added.

# 1.0.0 
- :confetti_ball: :tada: First stable release :tada: :confetti_ball:
- :star2: Added support for php etl 1.0 stable release.
- :star2: Added support for symfony 6
- :wrench: Download of ETL file execution will now work with even big files. (Not limited by memory)

# 1.0.0 Alpha #2

- :star2: Split chain execution into2 public function for more flexibility.
- :star2: Each execution has dedicated folder with it's logs.
- :star2: You can see the logs of the execution in the interface.
- :star2: Added a json editor/viewer to improve usability.
- :star2: You can download all files used during an execution from the interface.
- :star2: Dashboard allow you to monitor & see the executions.
- :star2: User can queue chain executions from the interface
- :star2: Added `etl-clean_old_executions` chain to cleanup old executions.
- :wrench: Fixed deprecation on console commands.
- :wrench: Various fixes and improvements.

# 1.0.0 Alpha #1
- :confetti_ball: :tada: First release :tada: :confetti_ball: