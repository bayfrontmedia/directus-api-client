<?php /** @noinspection PhpUnused */

namespace Bayfront\Directus\Query\Fields;

use Bayfront\Directus\Query\Interfaces\FieldInterface;

class LogicalOperator implements FieldInterface
{

    private string $operator;
    private array $fields = [];

    /**
     * @param string $operator (Logical operator constant)
     */
    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    /**
     * Get operator.
     *
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * Add relational field.
     *
     * @param RelationalField $field
     * @return $this
     */
    public function field(RelationalField $field): self
    {
        $this->fields[] = $field->get();
        return $this;
    }

    /**
     * Get all relational fields for this operator.
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return [
            $this->operator => $this->getFields()
        ];
    }
}