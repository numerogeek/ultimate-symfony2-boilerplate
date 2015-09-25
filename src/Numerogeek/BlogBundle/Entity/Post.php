<?php

namespace Numerogeek\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Post.
 *
 * @ORM\Entity(repositoryClass="Numerogeek\BlogBundle\Repository\PostRepository")
 * @Vich\Uploadable
 * @ORM\Table(name="post")
 */
class Post
{
    const NUM_ITEMS = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    use TimestampableEntity;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ajoutez un extrait à votre post.")
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $publishedAt;

    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     *
     * @Assert\File(
     *     maxSize = "2M",
     *     maxSizeMessage = "Merci de sélectionner un fichier inférieur à 2Mo.",
     *     mimeTypes = {"image/gif", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier au format jpg, png, gif"
     * )
     * @Vich\UploadableField(mapping="post_cover", fileNameProperty="coverName")
     */
    protected $cover;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255,  name="cover_name", nullable=true)
     */
    protected $coverName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $online;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="Category"
     * )
     */
    private $category;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setPublishedAt(new \DateTime());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCover()
    {
        return $this->cover;
    }

    /*
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
    *
    */
    public function setCover(File $cover = null)
    {
        if (null != $cover) {
            $this->cover = $cover;
            //Trick : if we change only the cover, the entity does not fire the persist.

            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function getCoverName()
    {
        return $this->coverName;
    }

    public function setCoverName($coverName)
    {
        $this->coverName = $coverName;
    }

    /**
     * @return mixed
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * @param mixed $online
     */
    public function setOnline($online)
    {
        $this->online = $online;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
