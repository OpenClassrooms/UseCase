<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Cache;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\CacheItem;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheSpy extends ArrayAdapter
{
    /**
     * @var array<string, true>
     */
    public array $saved = [];

    /**
     * @var array<string, true>
     */
    public array $getted = [];

    public function save(CacheItemInterface $item): bool
    {
        $this->saved[$item->getKey()] = (new \ReflectionProperty($item, 'expiry'))->getValue($item);

        return parent::save($item);
    }

    public function getItem(mixed $key): CacheItem
    {
        $item = parent::getItem($key);

        $this->getted[$item->getKey()] = $item->isHit();

        return $item;
    }
}
