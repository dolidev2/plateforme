<?php


namespace App\DataFixture;


use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\Dossier;
use App\Entity\Fournisseur;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->loadService($manager);
        $this->loadFournisseur($manager);
        $this->loadClient($manager);
        $this->loadDossier($manager);
        $this->loadDevis($manager);

    }

    public function loadClient(ObjectManager $manager){

        for ($i=1; $i <= 10 ; $i++){

            $client = new Client();
            $client->setNomClient("Client $i");
            $client->setCreatedAt(new \DateTimeImmutable());
            $client->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($client);
        }
        $manager->flush();
    }
    public function loadService(ObjectManager $manager){


            $service = new Service();
            $service->setNomService('Informatique');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());
            $this->addReference('service', $service);
            $manager->persist($service);

            $service = new Service();
            $service->setNomService('Marketing');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($service);

            $service = new Service();
            $service->setNomService('Technique');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($service);

            $service = new Service();
            $service->setNomService('Commercial');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($service);

            $service = new Service();
            $service->setNomService('PAO');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($service);

            $service = new Service();
            $service->setNomService('Direction');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($service);

            $service = new Service();
            $service->setNomService('Comptabilité');
            $service->setCreatedAt(new \DateTimeImmutable());
            $service->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($service);

            $manager->flush();
    }
    public function loadFournisseur(ObjectManager $manager){


        for ($i=1; $i <= 10 ; $i++){
            $four = new Fournisseur();
            $four->setNomFournisseur("FournisseurManager $i");
            $four->setCreatedAt(new \DateTimeImmutable());
            $four->setUpdatedAt(new \DateTimeImmutable());
            $this->addReference("four_$i",$four);
            $manager->persist($four);
        }
        $manager->flush();
    }

    public function loadDossier(ObjectManager $manager){

        $service = $this->getReference('service');
        for ($i=1; $i <= 10 ; $i++){
            $dossier = new Dossier();
            $dossier->setNomDossier("Dossier $i");
            $dossier->setService($service);
            $dossier->setType('Externe');
            $dossier->setClient("Client $i");
            $dossier->setStatut('0');
            $dossier->setCout(100000);
            $dossier->setVente(120000);
            $dossier->setCreatedAt(new \DateTimeImmutable());
            $dossier->setUpdatedAt(new \DateTimeImmutable());
            $this->addReference("dossier_$i",$dossier);

            $manager->persist($dossier);
        }
        $manager->flush();
    }

    public function loadDevis(ObjectManager $manager){



        for ($i=1; $i <= 10 ; $i++){

            $dossier = $this->getReference("dossier_$i");
            $four = $this->getReference("four_$i");
            $devis = new Devis();
            $devis->setNomDevis("Devis $i");
            $devis->setDossier($dossier);
            $devis->setFournisseur($four);
            $devis->setCreatedAt(new \DateTimeImmutable());
            $devis->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($devis);
        }
        $manager->flush();
    }


}