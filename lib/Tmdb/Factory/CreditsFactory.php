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
namespace Tmdb\Factory;

use Tmdb\Exception\NotImplementedException;
use Tmdb\HttpClient\HttpClient;
use Tmdb\Model\Genre;
use Tmdb\Model\Credits as Credits;
use Tmdb\Model\Person;

/**
 * Class CreditsFactory
 * @package Tmdb\Factory
 */
class CreditsFactory extends AbstractFactory
{
    /**
     * @var TvSeasonFactory
     */
    private $tvSeasonFactory;

    /**
     * @var TvEpisodeFactory
     */
    private $tvEpisodeFactory;

    /**
     * @var PeopleFactory
     */
    private $peopleFactory;

    /**
     * Constructor
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->tvSeasonFactory  = new TvSeasonFactory($httpClient);
        $this->tvEpisodeFactory = new TvEpisodeFactory($httpClient);
        $this->peopleFactory    = new PeopleFactory($httpClient);

        parent::__construct($httpClient);
    }

    /**
     * @param array $data
     *
     * @return Genre
     */
    public function create(array $data = [])
    {
        $credits = new Credits();

        if (array_key_exists('media', $data)) {

            $credits->setMedia(
                $this->hydrate($credits->getMedia(), $data['media'])
            );

            if (array_key_exists('seasons', $data['media'])) {
                $episodes = $this->getTvSeasonFactory()->createCollection($data['media']['seasons']);
                $credits->getMedia()->setSeasons($episodes);
            }

            if (array_key_exists('episodes', $data['media'])) {
                $episodes = $this->getTvEpisodeFactory()->createCollection($data['media']['episodes']);
                $credits->getMedia()->setEpisodes($episodes);
            }
        }

        if (array_key_exists('person', $data)) {
            $person = $this->getPeopleFactory()->create($data['person']);

            if ($person instanceof Person) {
                $credits->setPerson($person);
            }
        }

        return $this->hydrate($credits, $data);
    }

    /**
     * @throws NotImplementedException
     */
    public function createCollection(array $data = [])
    {
        throw new NotImplementedException(
            'Credits are usually obtained through the PeopleFactory,
            however we might add a shortcut for that here.'
        );
    }

    /**
     * @param  \Tmdb\Factory\TvEpisodeFactory $tvEpisodeFactory
     * @return $this
     */
    public function setTvEpisodeFactory($tvEpisodeFactory)
    {
        $this->tvEpisodeFactory = $tvEpisodeFactory;

        return $this;
    }

    /**
     * @return \Tmdb\Factory\TvEpisodeFactory
     */
    public function getTvEpisodeFactory()
    {
        return $this->tvEpisodeFactory;
    }

    /**
     * @param  \Tmdb\Factory\TvSeasonFactory $tvSeasonFactory
     * @return $this
     */
    public function setTvSeasonFactory($tvSeasonFactory)
    {
        $this->tvSeasonFactory = $tvSeasonFactory;

        return $this;
    }

    /**
     * @return \Tmdb\Factory\TvSeasonFactory
     */
    public function getTvSeasonFactory()
    {
        return $this->tvSeasonFactory;
    }

    /**
     * @param  \Tmdb\Factory\PeopleFactory $peopleFactory
     * @return $this
     */
    public function setPeopleFactory($peopleFactory)
    {
        $this->peopleFactory = $peopleFactory;

        return $this;
    }

    /**
     * @return \Tmdb\Factory\PeopleFactory
     */
    public function getPeopleFactory()
    {
        return $this->peopleFactory;
    }
}
