<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorieRonde = new Categorie();
        $categorieRonde->setLibelle("rondes");
        $manager->persist($categorieRonde);

        $categorieTriangle = new Categorie();
        $categorieTriangle->setLibelle("triangles");
        $manager->persist($categorieTriangle);

        $categorieCarree = new Categorie();
        $categorieCarree->setLibelle("carrées");
        $manager->persist($categorieCarree);

        $manager->flush();

        $produitRougeCarre = new Produit();
        $produitRougeCarre->setLibelle("gommettes rouges carrées");
        $produitRougeCarre->setTarif(22);
        $produitRougeCarre->setIdCategorie($categorieCarree);
        $manager->persist($produitRougeCarre);

        $produitVertCarre = new Produit();
        $produitVertCarre->setLibelle("gommettes vert carrées");
        $produitVertCarre->setTarif(20);
        $produitVertCarre->setIdCategorie($categorieCarree);
        $manager->persist($produitVertCarre);

        $produitBleuCarre = new Produit();
        $produitBleuCarre->setLibelle("gommettes bleu carrées");
        $produitBleuCarre->setTarif(43);
        $produitBleuCarre->setIdCategorie($categorieCarree);
        $manager->persist($produitBleuCarre);

        $produitBleuRond = new Produit();
        $produitBleuRond->setLibelle("gommettes bleu rondes");
        $produitBleuRond->setTarif(52);
        $produitBleuRond->setIdCategorie($categorieRonde);
        $manager->persist($produitBleuRond);

        $manager->flush();

        $tag1 = new Tag();
        $tag1->setLibelle("gommettes");
        $manager->persist($tag1);

        $tag2 = new Tag();
        $tag2->setLibelle("rouge");
        $manager->persist($tag2);

        $tag3 = new Tag();
        $tag3->setLibelle("bleu");
        $manager->persist($tag3);

        $tag4 = new Tag();
        $tag4->setLibelle("rondes");
        $manager->persist($tag4);

        $manager->flush();
    }
}
