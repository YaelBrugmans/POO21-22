<?php


namespace App\Listener;


use App\Entity\Advert;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Query\Expr\Math;

class AdvertEntityListener {

    private $authors = ['Frederic', 'Jean', 'Marc', 'Yael', 'Sasuke2000', 'DarkArnaud'];

    public function prePersist(Advert $entity, LifecycleEventArgs $args) {
        $entity->setAuthor($this->authors[random_int(0, count($this->authors) -1)]);
    }

}
