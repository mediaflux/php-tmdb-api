<?php
/**
 * This file is part of the Tmdb PHP API created by Michael Roterman.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Tmdb
 * @author Michael Roterman <michael@wtfz.net>
 * @copyright (c) 2013, Michael Roterman
 * @version 0.0.1
 */
namespace Tmdb\Factory\Common;

use Tmdb\Common\ObjectHydrator;
use Tmdb\Model\Common\GenericCollection;

class GenericCollectionFactory {
    /**
     * {@inheritdoc}
     */
    public static function create(array $data = array(), $class)
    {
        return self::createCollection($data, $class);
    }

    /**
     * {@inheritdoc}
     */
    public static function createCollection(array $data = array(), $class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $collection = new GenericCollection();

        foreach($data as $item) {
            $collection->add(null, ObjectHydrator::hydrate(new $class(), $item));
        }

        return $collection;
    }
}