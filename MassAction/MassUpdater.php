<?php

namespace Pim\Bundle\CustomEntityBundle\MassAction;

use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Mass action updater
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MassUpdater
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected $doctrine;

    /**
     * Constructor
     *
     * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Mass updates entities
     *
     * @param string $class
     * @param array  $data
     * @param array  $ids
     */
    public function updateEntities(string $class, array $data, array $ids): void
    {
        $qb = $this->doctrine->getManager()->createQueryBuilder()
            ->update($class, 'o')
            ->where('o.id IN (:ids)')
            ->setParameter('ids', $ids);
        foreach ($data as $key => $value) {
            $qb->set("o.$key", ":$key")->setParameter(":$key", $value);
        }

        $qb->getQuery()->execute();
    }
}
