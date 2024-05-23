<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus\Query\Filter\Fields;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\Directus\Query\Interfaces\FieldInterface;

/**
 * Relational field filter.
 * See: https://docs.directus.io/reference/filter-rules.html#relational
 */
class RelationalField implements FieldInterface
{

    private array $field = [];

    /**
     * @param string $field (Field name in dot notation)
     * @param string $operator (Filter operator constant)
     * @param mixed $value
     */
    public function __construct(string $field, string $operator, mixed $value)
    {
        $this->field[$field] = [
            $operator => $value
        ];
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return Arr::undot($this->field);
    }

}