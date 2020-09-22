# An unofficial PHP implementation of JsonLogic

### Usage

- For an one-time logic to data use case, the `apply` function is enough:

    ```php
    echo \JsonLogic\JsonLogic::apply($rule, $data);
    ```

- For a rule runs tons times, e.g. find matched records in daily logs:

    ```php
    $rule = \JsonLogic\JsonLogic::rule($rule);

    var_dump(
        array_filter($logs, function ($log) use ($rule) {
            return $rule->process($log);
        })
    );
    ```
