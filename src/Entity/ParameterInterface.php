<?php

namespace Kematjaya\SerialNumberBundle\Entity;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface ParameterInterface 
{
    const CODE_SECURITY = 'security';
    const COLUMN_SECURITY_NUMBER = 'serial_number';
    
    public function getCode(): ?string;

    public function setCode(string $code): self;

    public function getName(): ?string;

    public function setName(string $name): self;

    public function getDescription(): ?string;

    public function setDescription(?string $description): self;

    public function getValue(): ?array;

    public function setValue(array $value): self;
}
