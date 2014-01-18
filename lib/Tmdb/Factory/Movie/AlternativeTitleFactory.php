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
namespace Tmdb\Factory\Movie;

use Tmdb\Factory\AbstractFactory;
use Tmdb\Model\Common\GenericCollection;
use Tmdb\Model\Movie\AlternativeTitle;

class AlternativeTitleFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public static function create(array $data = array())
    {
        $title = new AlternativeTitle();

        return $title->hydrate($data);
    }

    /**
     * {@inheritdoc}
     */
    public static function createCollection(array $data = array())
    {
        $collection = new GenericCollection();

        foreach($data as $item) {
            $collection->add(null, self::create($item));
        }

        return $collection;
    }
}