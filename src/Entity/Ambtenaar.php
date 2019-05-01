<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ActivityLogBundle\Entity\Interfaces\StringableInterface;

/**
 * Ambtenaar
 * 
 * Een werknemer van een gemeente, overheid of andere aan common ground deelnemende organisatie.
 * 
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Common Ground
 * @subpackage  Ambtenaar
 *  
 *  @ApiResource( 
 *  collectionOperations={
 *  	"get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/ambtenaren",
 *  		"openapi_context" = {
 * 				"summary" = "Haalt een verzameling van ambtenaren op"
 *  		}
 *  	},
 *  	"post"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/ambtenaren",
 *  		"openapi_context" = {
 * 					"summary" = "Maak een ambtenaar aan"
 *  		}
 *  	}
 *  },
 * 	itemOperations={
 *     "get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/ambtenaren/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Haalt een specifieke ambtenaar op"
 *  		}
 *  	},
 *     "put"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/ambtenaren/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Vervang een specifieke ambtenaar"
 *  		}
 *  	},
 *     "delete"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/ambtenaren/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Verwijder een specifieke ambtenaar"
 *  		}
 *  	},
 *     "log"={
 *         	"method"="GET",
 *         	"path"="/ambtenaren/{id}/log",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Logboek inzien",
 *         		"description" = "Geeft een array van eerdere versies en wijzigingen van dit ambtenaren object",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	},
 *             	"responses" = {
 *         			"200" = {
 *         				"description" = "Een overzicht van versies"
 *         			},	
 *         			"400" = {
 *         				"description" = "Ongeldige aanvraag"
 *         			},
 *         			"404" = {
 *         				"description" = "Ambtenaar niet gevonden"
 *         			}
 *            	}            
 *         }
 *     },
 *     "revert"={
 *         	"method"="POST",
 *         	"path"="/ambtenaren/{id}/revert/{version}",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Versie terugdraaid",
 *         		"description" = "Herstel een eerdere versie van dit ambtenaren object. Dit is een destructieve actie die niet ongedaan kan worden gemaakt",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	},
 *             	"responses" = {
 *         			"202" = {
 *         				"description" = "Teruggedraaid naar eerdere versie"
 *         			},	
 *         			"400" = {
 *         				"description" = "Ongeldige aanvraag"
 *         			},
 *         			"404" = {
 *         				"description" = "Ambtenaar niet gevonden"
 *         			}
 *            	}            
 *         }
 *     }
 *  }
 * )
 * @ORM\Entity
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"identificatie", "bronOrganisatie"},
 *     message="De identificatie dient uniek te zijn voor de bronOrganisatie"
 * )
 */

class Ambtenaar implements StringableInterface
{
	/**
	 * Het identificatie nummer van deze Ambtenaar <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 *
	 * @var int|null
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", options={"unsigned": true})
	 * @Groups({"read", "write"})
	 * @ApiProperty(iri="https://schema.org/identifier")
	 */
	private $id;
	
	/**
	 * De unieke identificatie van dit object binnen de organisatie die dit object heeft gecreeerd. <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 *
	 * @var string
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 40,
	 *     nullable=true
	 * )
	 * @Assert\Length(
	 *      max = 40,
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="6a36c2c4-213e-4348-a467-dfa3a30f64aa",
	 *             "description"="De unieke identificatie van dit object de organisatie die dit object heeft gecreeerd.",
	 *             "maxLength"=40
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $identificatie;

	/**
	 * De organisatie waartoe deze Ambtenaar behoort.
	 *
	 * @var \App\Entity\Organisatie
	 * @ORM\ManyToOne(targetEntity="\App\Entity\Organisatie", cascade={"persist", "remove"}, inversedBy="ambtenaren")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 *
	 */
	public $bronOrganisatie;
	
	/**
	 * URL-referentie naar het afbeeldings document.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van deze persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $afbeelding;
	
	/**
	 * URL-referentie naar het film document
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van dit persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $film;
	
	/**
	 * De naam van deze Ambtenaar <br /><b>Schema:</b> <a href="https://schema.org/givenName">https://schema.org/givenName</a>a>
	 *
	 * @var string
	 *
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "De naam moet tenminste {{ limit }} karakters lang zijn",
     *      maxMessage = "De naam kan niet langer dan {{ limit }} karakters zijn")
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "example"="John"
     *         }
     *     }
	 * )
	 */
	public $voornamen;
	
	/**
	 * Voorvoegsel van de achternaam <br /><b>Schema:</b> <a href="https://schema.org/givenName">https://schema.org/givenName</a>
	 *
	 * @var string
	 *
	 * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255,
	 *     nullable = true,
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="van der"
	 *         }
	 *     }
	 * )
	 **/
	public $voorvoegselGeslachtsnaam;
	
	/**
	 * De achternaam van deze Ambtenaar <br /><b>Schema:</b> <a href="https://schema.org/familyName">https://schema.org/familyName</a>
	 *
	 * @var string
	 *
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 5,
	 *      max = 255,
	 *      minMessage = "De naam moet tenminste {{ limit }} karakters lang zijn",
	 *      maxMessage = "De naam kan niet langer dan {{ limit }} karakters zijn")
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *             "minLength"=5,
	 *             "maxLength"=255,
	 *             "type"="string",
	 *             "example"="Doe"
	 *         }
	 *     }
	 * )
	 */
	public $geslachtsnaam;
	
	/**	 * 
	 * De aanhef van deze Ambtenaar <br /> Moet altijd Dhr. of Mvr. zijn.
	 * 
	 * @var string
	 * 
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255,
	 *     nullable = true
	 * )
	 *  @Assert\Choice(
     *     choices = { "Dhr.", "Mvr." },
     *     message = "Kies Dhr. of Mvr."
     * )
	 * @Groups({"read", "write"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "enum"={"Dhr.", "Mvr."},
     *             "example"="Dhr."
     *         }
     *     }
     * )
	 */
	public $aanhef;
	
	/**
	 * Een samenvattende tekst over deze ambtenaar  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
     * @Gedmo\Translatable
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Your first name must be at least {{ limit }} characters long",
	 *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "minLength"=25,
	 *             "maxLength"=2000,
	 *             "example"="Deze prachtige locatie is zeker het aanbevelen waard"
	 *         }
	 *     }
	 * )
	 **/
	public $samenvatting;
		
	/**
	 * Een beschrijvende tekst over deze Ambtenaar  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
     * @Gedmo\Translatable
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Your first name must be at least {{ limit }} characters long",
	 *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
	 *             "minLength"=25,
	 *             "maxLength"=2000,
     *             "example"="John is de leukste trouw ambtenaar uit uw gemeente en omstreken"
     *         }
     *     }
	 * )
	 */
	public $beschrijving;
		
	/**
	 * De taal waarin de informatie van deze Ambtenaar is opgesteld <br /><b>Schema:</b> <a href="https://www.ietf.org/rfc/rfc3066.txt">https://www.ietf.org/rfc/rfc3066.txt</a>
	 *
	 * @var string Een Unicode language identifier, ofwel RFC 3066 taalcode.
	 *
     * @Gedmo\Versioned
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 2
	 * )
	 * @Assert\Language
	 * @Groups({"read", "write"})
	 * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "example"="NL"
     *         }
     *     }
     * )
	 */
	public $taal = 'nl';	
			
	/**
	 * Het tijdstip waarop deze entiteit is aangemaakt
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="create")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime"
	 * )
	 * @Groups({"read"})
	 */
	public $registratiedatum;
	
	/**
	 * Het tijdstip waarop deze entiteit voor het laatst is gewijzigd.
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="update")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime", 
	 *     nullable	= true
	 * )
	 * @Groups({"read"})
	 */
	public $wijzigingsdatum;
	
	/**
	 * De contactpersoon voor deze ambtenaar.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="Contactpersoon",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van dit persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $contactPersoon;
	
	/**
	 * @return string
	 */
	public function toString(){
		// If there is a voorvoegselGeslachtsnaam we want to add a save between voorvoegselGeslachtsnaam and geslachtsnaam;
		$voorvoegselGeslachtsnaam = $this->voorvoegselGeslachtsnaam;
		if($voorvoegselGeslachtsnaam){$voorvoegselGeslachtsnaam=$voorvoegselGeslachtsnaam.' ';}
		// Lets render the name
		return "{$this->voornamen} {$voorvoegselGeslachtsnaam}{$this->geslachtsnaam}";
	}
	
	/**
	 * Vanuit rendering perspectief (voor bijvoorbeeld logging of berichten) is het belangrijk dat we een entiteit altijd naar string kunnen omzetten.
	 */
	public function __toString()
	{
		return $this->toString();
	}
	
	
	public function getId(): ?int
	{
		return $this->id;
	}
	
	/**
	 * Add Product
	 *
	 * @param  \App\Entity\Product $product
	 * @return Order
	 */
	public function addProduct(\App\Entity\Product $product)
	{
		$this->products[] = $product;
		
		return $this;
	}
	
	/**
	 * Remove Product
	 *
	 * @param \App\Entity\Product $product
	 */
	public function removeProduct(\App\Entity\Product $product)
	{
		$this->products->removeElement($product);
	}
	
	/**
	 * Get Product
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getProducts()
	{
		return $this->products;
	}
	
}
