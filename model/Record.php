<?php


namespace model;


class Record
{
    private $id;
    private $type;
    private $name;
    private $content;
    private $ttl;
    private $prio;
    private $weight;
    private $port;

    public const TYPES = ['A', 'AAAA', 'MX', 'ANAME', 'CNAME', 'NS', 'TXT', 'SRV'];

    /**
     * Record constructor.
     * @param int $id
     * @param string $type
     * @param string $name
     * @param string $content
     * @param int $ttl
     * @param int|null $prio
     * @param int|null $weight
     * @param int|null $port
     */
    public function __construct(
        int $id,
        string $type,
        string $name,
        string $content,
        int $ttl = 600,
        ?int $prio = null,
        ?int $weight = null,
        ?int $port = null
    )
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
        $this->ttl = $ttl;
        $this->prio = $prio;
        $this->weight = $weight;
        $this->port = $port;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @param int $ttl
     */
    public function setTtl(int $ttl): void
    {
        $this->ttl = $ttl;
    }

    /**
     * @return int|null
     */
    public function getPrio(): ?int
    {
        return $this->prio;
    }

    /**
     * @param int|null $prio
     */
    public function setPrio(?int $prio): void
    {
        $this->prio = $prio;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     */
    public function setWeight(?int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     */
    public function setPort(?int $port): void
    {
        $this->port = $port;
    }
}
