<?php


namespace model;


class Zone
{
    private $id;
    private $name;
    private $updateTime;

    /**
     * Zone constructor.
     * @param int $id
     * @param string $name
     * @param int|null $updateTime
     */
    public function __construct(int $id, string $name, ?int $updateTime = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->updateTime = $updateTime;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime(?int $updateTime): void
    {
        $this->updateTime = $updateTime;
    }
}
