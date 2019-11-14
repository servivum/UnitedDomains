<?php declare(strict_types=1);

namespace HadesArchitect\UnitedDomains;

class Response implements ResponseInterface
{
    /**
     * @var integer
     */
    protected $code;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $collection = [];

    public function __construct(int $code, string $description, array $properties = [])
    {
        $this->code        = $code;
        $this->description = $description;
        $this->properties  = $properties;

        // Create collectoin of properties
        $this->collection = $this->convertToCollection($properties);
    }

    /**
     * @inheritdoc
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    function isSuccessful(): bool
    {
        return $this->getCode() < 221;
    }

    /**
     * @inheritdoc
     */
    function isFailed(): bool
    {
        return $this->getCode() > 220;
    }

    /**
     * @inheritdoc
     */
    function hasProperty(string $name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * @inheritdoc
     */
    function countProperty(string $name): int
    {
        if (!$this->hasProperty($name)) {
            return 0;
        }

        return count($this->properties[$name]);
    }

    /**
     * @inheritdoc
     */
    function getProperty(string $name): ?array
    {
        if (!$this->hasProperty($name)) {
            return null;
        }

        return $this->properties[$name];
    }

    /**
     * @inheritdoc
     */
    function getSingleProperty(string $name)
    {
        if (!$this->hasProperty($name)) {
            return null;
        }

        return $this->properties[$name][0];
    }

    /**
     * @inheritdoc
     */
    function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return sprintf('%d: %s', $this->getCode(), $this->getDescription());
    }

    public function getCollection()
    {
        return $this->collection;
    }

    protected function convertToCollection($properties)
    {
        $data = [];
        if (!empty($properties)) {
            foreach($properties as $key => $propertyValue) {
                $excludeProperties = ['total', 'count', 'first', 'limit', 'last'];
                if (!in_array($key, $excludeProperties)) {
                    foreach ($propertyValue as $row => $value) {
                        $data[$row][$key] = $value;
                    }
                }
            }
        }

        return $data;
    }
}
