<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 15:29
 */

namespace App\GraphQL\Mutations;

class MutationData
{
    /**
     * Value of input argument
     * @var array $input
     */
    private $input = [];
    /**
     * Values of output attributes
     * @var array $attributes
     */
    private $attributes = [];

    /**
     * MutationItem constructor.
     * @param array $input
     */
    public function __construct(array $input = [])
    {
//        foreach ($input as $key => $value) {
//            if (!is_string($key)) {
//                throw new GraphqlException('Key of input data must be string');
//            }
//            $this->input[$key] = is_array($value) ? static::build($value) : $value;
//        }
        $this->input = $input;
    }

    /**
     * @param array $input
     * @return array|static
     */
    public static function build(array $input)
    {
        if ($input !== [] && self::isSimpleArray($input)) {
            $data = [];
            foreach ($input as $item) {
                $data[] = new static($item);
            }
            return $data;
        }

        return new static($input);
    }

    private static function isSimpleArray($array): bool
    {
        $keys = array_keys($array);
        return $keys === array_keys($keys);
    }

    /**
     * @return array
     */
    public function getInput(): array
    {
        return $this->input;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        // todo: throw an exception if key doesn't exist
        return $this->attributes[$name] /*?? $this->vars[$name]*/ ?? $this->input[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        unset($this->attributes[$name]);
    }
}
