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
namespace Tmdb\Model;

use Tmdb\Model\Changes\Change;
use Tmdb\Model\Common\GenericCollection;

class Changes extends AbstractQuery {

    private $from = null;
    private $to   = null;
    private $page = null;

    /**
     * Set the from parameter
     *
     * @param \DateTime $date
     * @return $this
     */
    public function from(\DateTime $date)
    {
        $this->from = $date->format('Y-m-d');

        return $this;
    }

    /**
     * Set the to parameter
     *
     * @param \DateTime $date
     * @return $this
     */
    public function to(\DateTime $date)
    {
        $this->to = $date->format('Y-m-d');

        return $this;
    }

    /**
     * Set the page parameter
     *
     * @param int $page
     * @return $this
     */
    public function page($page = 1) {
        $this->page = (int) $page;

        return $this;
    }

    /**
     * Execute the current state
     *
     * @return GenericCollection
     */
    public function execute()
    {
        $collection = new GenericCollection();

        $response = $this->getClient()->getChangesApi()->getMovieChanges(array(
            'from' => $this->from,
            'to'   => $this->to,
            'page' => $this->page
        ));

        if (!empty($response)) {
            foreach($response['results'] as $change) {
                $collection->add(null, Change::fromArray($this->getClient(), $change));
            }
        }

        return $collection;
    }
}
