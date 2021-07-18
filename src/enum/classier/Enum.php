<?php


namespace apps\enum\classier;


use Exception;
use ReflectionException;

abstract class Enum
{

    /**
     * Default value
     * @var null
     */
    public const __default = null;

    /**
     * value
     * @var mixed|null
     */
    protected $value;

    /**
     * is strict
     * @var bool
     */
    protected $strict;

    /**
     * constants
     * @var array
     */
    protected $constants = [];

    /**
     * switch 如果是false 则停止继续往下匹配，如果是true，则继续匹配
     * @var bool
     */
    protected $thenState = true;

    /**
     * BaseEnum constructor.
     * @param null $initialValue
     * @param bool $strict
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct($initialValue = self::__default, bool $strict = true)
    {
        if ($initialValue instanceof Enum) $initialValue = $initialValue->value;

        $this->constants = Utils::getConstants($this);

        unset($this->constants['__default']);

        if ($initialValue === null) $initialValue = self::__default;

        if (!in_array($initialValue, $this->constants, $strict)) {
            throw new Exception("Value is not in enum " . __CLASS__);
        }

        $this->value = $initialValue;

        $this->strict = $strict;
    }

    /**
     * switch
     * @return $this
     * @throws Exception
     */
    public function then()
    {
        if (!$this->thenState) return $this;

        $parameters = func_get_args();

        if (count($parameters) < 2) throw new Exception('then parameters error');

        $callback = array_pop($parameters);

        if (!is_callable($callback)) throw new Exception('then callback error');

        $then = false;

        foreach ($parameters as $object) {

            $then = $this->equals($object);

            if ($then) break;
        }

        if (!$then) return $this;

        $result = call_user_func_array($callback, [$this]);

        $this->thenState = !($result === false);

        return $this;
    }

    /**
     * fetch
     * @return void
     */
    public function fetch()
    {
        $this->thenState = true;
    }

    /**
     * 检查两个是否相等
     * @param $object
     * @return bool
     */
    public function equals($object): bool
    {
        $value = $object instanceof Enum ? $object->value : $object;

        return $this->strict ? ($this->value === $value) : ($this->value == $value);
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * to string
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

}
