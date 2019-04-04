<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="date", type="datetime")
   * @Assert\DateTime()
   */
  private $date;

  /**
   * @ORM\Column(name="title", type="string", length=255)
   * @Assert\Length(min=10)
   */
  private $title;

  /**
   * @ORM\Column(name="author", type="string", length=255)
   * @Assert\Length(min=2)
   */
  private $author;

  /**
   * @ORM\Column(name="content", type="text")
   * @Assert\NotBlank()
   */
  private $content;

  /**
   * @var boolean
   * 
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;

  /**
   * @var \Datetime
   * 
   * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
   */
  private $updatedAt;

  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(name="slug", type="string", length=255, unique=true)
   */
  private $slug;

  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;

  /**
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
   * @Assert\Valid()
   */
  private $image;

  /**
   * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
   */
  private $categories;

  /**
   * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert")
   */
  private $applications;

  /**
   * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\AdvertSkill", mappedBy="advert")
   */
  private $advertSkills;


  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->applications = new ArrayCollection();
  }

  /**
   * Get id.
   *
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set date.
   *
   * @param \DateTime $date
   *
   * @return Advert
   */
  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  /**
   * Get date.
   *
   * @return \DateTime
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Set title.
   *
   * @param string $title
   *
   * @return Advert
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get title.
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set author.
   *
   * @param string $author
   *
   * @return Advert
   */
  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }

  /**
   * Get author.
   *
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * Set content.
   *
   * @param string $content
   *
   * @return Advert
   */
  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  /**
   * Get content.
   *
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Set published.
   *
   * @param bool $published
   *
   * @return Advert
   */
  public function setPublished($published)
  {
    $this->published = $published;

    return $this;
  }

  /**
   * Get published.
   *
   * @return bool
   */
  public function getPublished()
  {
    return $this->published;
  }

  /**
   * Set image.
   *
   * @param \OC\PlatformBundle\Entity\Image|null $image
   *
   * @return Advert
   */
  public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
  {
    $this->image = $image;

    return $this;
  }

  /**
   * Get image.
   *
   * @return \OC\PlatformBundle\Entity\Image|null
   */
  public function getImage()
  {
    return $this->image;
  }

  public function addCategory(Category $category)
  {
    $this->categories[] = $category;
  }

  public function removeCategory(Category $category)
  {
    $this->categories->removeElement($category);
  }

  /**
   * Get categories
   * 
   * @return ArrayCollection
   */
  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * Add application.
   *
   * @param \OC\PlatformBundle\Entity\Application $application
   *
   * @return Advert
   */
  public function addApplication(\OC\PlatformBundle\Entity\Application $application)
  {
    $this->applications[] = $application;

    $application->setAdvert($this);

    return $this;
  }

  /**
   * Remove application.
   *
   * @param \OC\PlatformBundle\Entity\Application $application
   *
   * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
   */
  public function removeApplication(\OC\PlatformBundle\Entity\Application $application)
  {
    return $this->applications->removeElement($application);
  }

  /**
   * Get applications.
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications()
  {
    return $this->applications;
  }

  /**
   * Set updatedAt.
   *
   * @param \Datetime $update
   *
   * @return Advert
   */
  public function setUpdatedAt($update)
  {
    $this->updatedAt = $update;

    return $this;
  }

  /**
   * Get updatedAt.
   *
   * @param \Datetime $update
   *
   * @return \Datetime
   */
  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

  /**
   * Get nbApplications.
   *
   * @return int
   */
  public function getNbApplications()
  {
    return $this->nbApplications;
  }

  public function increaseNbApplications()
  {
    $this->nbApplications++;
  }

  public function decreaseNbApplications()
  {
    $this->nbApplications--;
  }

  /**
   * Set nbApplications.
   *
   * @param int $nbApplications
   *
   * @return Advert
   */
  public function setNbApplications($nbApplications)
  {
    $this->nbApplications = $nbApplications;

    return $this;
  }

  /**
   * Set slug.
   *
   * @param string $slug
   *
   * @return Advert
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;

    return $this;
  }

  /**
   * Get slug.
   *
   * @return string
   */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
   * Add advertSkill.
   *
   * @param \OC\PlatformBundle\Entity\AdvertSkill $advertSkill
   *
   * @return Advert
   */
  public function addAdvertSkill(\OC\PlatformBundle\Entity\AdvertSkill $advertSkill)
  {
    $this->advertSkills[] = $advertSkill;

    return $this;
  }

  /**
   * Remove advertSkill.
   *
   * @param \OC\PlatformBundle\Entity\AdvertSkill $advertSkill
   *
   * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
   */
  public function removeAdvertSkill(\OC\PlatformBundle\Entity\AdvertSkill $advertSkill)
  {
    return $this->advertSkills->removeElement($advertSkill);
  }

  /**
   * Get advertSkills.
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getAdvertSkills()
  {
    return $this->advertSkills;
  }
}
