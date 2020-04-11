<?php
declare(strict_types=1);

/**
 * Provider Interface
 * @category    Ticaje
 * @author      Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\AeSdk\Infrastructure\Interfaces\Provider\Signature;

use Ticaje\Contract\Patterns\Interfaces\Dto\DtoInterface;

interface SignerInterface
{
    /**
     * @param DtoInterface $dto
     * @return string
     */
    public function sign(DtoInterface $dto): string;
}
