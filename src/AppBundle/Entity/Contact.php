<?php

/**
 * Created by PhpStorm.
 * User: Geoffrey
 * Date: 16/08/2015
 * Time: 17:16.
 */

namespace AppBundle\Entity;

use Mremi\ContactBundle\Entity\Contact as BaseContact;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact.
 *
 * @ORM\Entity()

 * @ORM\Table(name="contact")
 */
class Contact extends BaseContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
}
