<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function getByCategory(\Club\ShopBundle\Entity\Category $category, $limit=10, $page = 0)
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->where('c.id = :category')
            ->andWhere('p.active = true')
            ->andWhere('p.status = :status')
            ->orderBy('p.priority', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('category', $category)
            ->setParameter('status', \Club\ShopBundle\Entity\Product::ACTIVE);

        return new \Doctrine\ORM\Tools\Pagination\Paginator($qb, false);
    }

    public function getUsersByProduct(\Club\ShopBundle\Entity\Product $product)
    {
        return $this->_em->createQueryBuilder()
            ->select('op, o, u')
            ->from('ClubShopBundle:OrderProduct', 'op')
            ->join('op.order', 'o')
            ->join('o.user', 'u')
            ->where('op.product = :product')
            ->orderBy('o.id', 'DESC')
            ->setParameter('product', $product->getId())
            ->getQuery()
            ->getResult();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', \Club\ShopBundle\Entity\Product::ACTIVE)
            ->getQuery()
            ->getResult();
    }

    public function getActive($limit = 10)
    {
        return $this->createQueryBuilder('p')
            ->where('p.status = :status')
            ->andWhere('p.active = true')
            ->orderBy('p.priority', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('status', \Club\ShopBundle\Entity\Product::ACTIVE)
            ->getQuery()
            ->getResult();
    }

    public function getPaginator($limit = 10, $page = 0)
    {
        $offset = ($page < 1) ? 1 : ($page-1)*$limit;

        $qb = $this->createQueryBuilder('p')
            ->where('p.status = :status')
            ->andWhere('p.active = true')
            ->orderBy('p.priority', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('status', \Club\ShopBundle\Entity\Product::ACTIVE);

        return new \Doctrine\ORM\Tools\Pagination\Paginator($qb, false);
    }

}
