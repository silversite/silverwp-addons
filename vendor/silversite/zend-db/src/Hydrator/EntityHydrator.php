<?php
namespace SilverZF2\Db\Hydrator;

use SilverZF2\Db\Entity\Entity;
use Zend\Hydrator\HydratorInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;

/**
 *
 *
 *
 * @category    Zend Framework 2
 * @package     SilverZF2\Db
 * @subpackage  Hydrator
 * @author      Michal Kalkowski <michal.kalkowski at autentika.pl>
 * @copyright   SilverSite.pl (c) 2015
 * @version     1.0
 */
class EntityHydrator implements HydratorInterface
{
    protected $fields = [];

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function extract($object)
    {
        if ( ! ($object instanceof Entity)) {
            throw new InvalidArgumentException(
                sprintf('Expected a subclass of SilverZF2\Db\Entity\Entity, but got %s', get_class($object))
            );
        }

        return $object->toArray($this->fields);
    }

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        if ( ! ($object instanceof Entity)) {
            throw new InvalidArgumentException(
                sprintf('Expected a subclass of SilverZF2\Db\Entity\Entity, but got %s', get_class($object))
            );
        }

        $object->merge($data, true);

        return $object;
    }
}