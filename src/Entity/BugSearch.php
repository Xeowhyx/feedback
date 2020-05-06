<?php

namespace App\Entity;


class BugSearch
{
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|\DateTime
     */
    private $date;

    /**
     * @var null|Os
     */
    private $os;

    /**
     * @var null|Location
     */
    private $location;

    /**
     * @var null|Priority
     */
    private $priority;

    /**
     * @var null|Severity
     */
    private $severity;

    /**
     * @var null|State
     */
    private $state;

    private $orderBy;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return BugSearch
     */
    public function setName(?string $name): BugSearch
    {
        $this->name = $name;
        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }


    /**
     * @param null|\DateTime $date
     * @return BugSearch
     */

    public function setDate(\DateTimeInterface $date): BugSearch
    {
        $this->date = $date;

    }



    public function getOs(): ?Os
    {
        return $this->os;
    }

    /**
     * @param Os|null $os
     * @return BugSearch
     */

    public function setOs(Os $os): BugSearch
    {
        $this->os = $os;
        return $this;
    }

    /**
     * @return Location|null
     */

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     * @return BugSearch
     */
    public function setLocation(Location $location): BugSearch
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Priority|null
     */
    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    /**
     * @param Priority|null $priority
     * @return BugSearch
     */
    public function setPriority(Priority $priority): BugSearch
    {
        $this->priority = $priority;
        return $this;
    }


    public function getSeverity(): ?Severity
    {
        return $this->severity;
    }

    /**
     * @param Severity|null $severity
     * @return BugSearch
     */
    public function setSeverity(Severity $severity): BugSearch
    {
        $this->severity = $severity;
        return $this;
    }

    public function setOrderBy(bool $b){
        $this->orderBy = $b;
        return $this;
    }

    public function getOrderBy(){
        return $this->orderBy;
    }


    public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * @param State|null $state
     * @return BugSearch
     */
    public function setState(State $state): BugSearch
    {
        $this->state = $state;
        return $this;
    }

    public function _toString()
    {
        return $this->name;
    }
}