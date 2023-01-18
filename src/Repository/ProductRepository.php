<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Summary of findWithSearch
     * Requete qui me permet de récupérer les produits en fonction de la recherche de l'utilisateur
     * @return Product[]
     */
    public function findWithSearch(Search $search) // On créer la requete
    {
        $query = $this
            ->createQueryBuilder("p") // méthode numero 1 pour créer une requete
            ->select("c", "p") // on choisit "Catégory" ("c") et "Product" ("p")
            ->join("p.category", "c"); // on fait la jointure entre nos produits et nos catégories

        if (!empty($search->categories)) { // Si l'utilisateur renseigne des catégories a rechercher tu fais la suite
            $query = $query
                ->andWhere("c.id IN (:categories)") // on lui passe un parametre ici :categories
                ->setParameter("categories", $search->categories); // on lui dit a quoi correspond categories
        }

        if (!empty($search->string)) { // Si l'utilisateur renseigne du texte a rechercher tu fais la suite
            $query = $query
                ->andWhere("p.name LIKE :string")
                ->setParameter("string", "%{$search->string}%"); // permet la recherche approximative du mot
        }

        return $query->getQuery()->getResult(); // on veut retourner les resultats
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
