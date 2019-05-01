<?php
// src/Entity/Apllicatie.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ActivityLogBundle\Entity\Interfaces\StringableInterface;

use App\Controller\UserController;
/**
 * Een applicatie die is geidentificeerd en geautoriceerd om namens een organisatie wijzigingen uit te voeren
 *
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Commen Ground
 *
 *  @ApiResource(
 *  collectionOperations={
 *  	"get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/users",
 *  		"openapi_context" = {
 *  		}
 *  	},
 *     "register"={
 *         "method"="POST",
 *         "path"="/register",
 *         "controller"= UserController::class,
 *     	   "normalization_context"={"groups"={"user"}},
 *     	   "denormalization_context"={"groups"={"register"}},
 *
 *         "openapi_context" = {
 *         		"summary" = "Register a new user",
 *         		"description" = "Register a new user ",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	},
 *             	"responses" = {
 *         			"201" = {
 *         				"description" = "User created"
 *         			},
 *         			"400" = {
 *         				"description" = "Ongeldige aanvraag"
 *         			}
 *            	}
 *         }
 *     },
 *     "login"={
 *         "method"="POST",
 *         "path"="/login_check",
 *         "controller"= UserController::class,
 *     	   "normalization_context"={"groups"={"login_check"}},
 *     	   "denormalization_context"={"groups"={"login"}},
 *
 *         "openapi_context" = {
 *         		"summary" = "Login",
 *         		"description" = "Log in a user",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	},
 *             	"responses" = {
 *         			"200" = {
 *         				"description" = "User loged in"
 *         			},
 *         			"401" = {
 *         				"description" = "User not loged in"
 *         			}
 *            	}
 *         }
 *     },
 *  },
 * 	itemOperations={
 *     "get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/appplicatie/{id}",
 *  		"openapi_context" = {
 *  		}
 *  	},
 *     "put"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/appplicatie/{id}",
 *  		"openapi_context" = {
 *  		}
 *  	},
 *     "delete"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/appplicatie/{id}",
 *  		"openapi_context" = {
 *  		}
 *  	},
 *     "log"={
 *         	"method"="GET",
 *         	"path"="/appplicatie/{id}/log",
 *          "controller"= UserController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Log",
 *         		"description" = "View the changelog for this object",
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
 *         				"description" = "Huwelijk of aanvraag niet gevonden"
 *         			}
 *            	}
 *         }
 *     }
 *  }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"naam", "organisatie"},
 *     message="De naam van een applicatie dient uniek te zijn voor een organisatie"
 * )
 * @ApiFilter(DateFilter::class, properties={"registratiedatum","wijzigingsdatum"})
 * @ApiFilter(OrderFilter::class, properties={"id", "identificatie","bronOrganisatie"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact","naam": "partial","bronOrganisatie": "exact"})
 */
class User implements UserInterface, StringableInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"read"})
	 */
	public $id;
	
	/**
	 * @Gedmo\Versioned
	 * @Groups({"user:write","read","register","login"})
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255,
	 *     unique=true
	 * )
	 * @Assert\Email(
	 *     message = "Het email addres '{{ value }}' is geen geldig email addres.",
	 *     checkMX = true
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 255,
	 *      minMessage = "The email needs to be at least {{ limit }} characters",
	 *      maxMessage = "The email cannot be more then {{ limit }} characters"
	 * )
	 * @Groups({"user:write","user"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="email",
	 *             "maxLength"=255,
	 *             "minLength"=8,
	 *             "example"="john@do.nl"
	 *         }
	 *     }
	 * )
	 */
	public $naam;
		
	/**
	 * Een door de organisatie opgegeven sleutel waarmee deze applicatie zich identificeerd bij het ophalen van en JWT token.
	 * 
	 * @Groups({"user:write","register","login"})
	 * @ORM\Column(type="string", length=500)
	 * @Assert\Length(
	 *      min = 5,
	 *      max = 16,
	 *      minMessage = "De leutel moet minimaal {{ limit }} tekens lang zijn",
	 *      maxMessage = "De leutel mag maximaal {{ limit }} tekens land zijn"
	 * )
	 * @ApiProperty(
	 * 	   iri="https://schema.org/accessCode",
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "maxLength"=16,
	 *             "minLength"=5,
	 *             "example"="NietZoGeheim"
	 *         }
	 *     }
	 * )
	 */
	public $sleutel;
	
	/**
	 * De scopes (rechten) die deze applicatie heeft.
	 *
	 * @Groups({"user:write","register"})
	 * @ORM\Column(type="string", length=500)
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="array",
	 *             "example"="[]"
	 *         }
	 *     }
	 * )
	 */
	public $scopes;
	
	/**
	 * Het RSIN van de organisatie waartoe deze applicatie behoord. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef.
	 *
	 * @var integer
	 * @ORM\Column(
	 *     type     = "integer",
	 *     length   = 9
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 9,
	 *      minMessage = "Het RSIN moet ten minste {{ limit }} karakters lang zijn",
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="123456789",
	 *             "required"="true",
	 *             "maxLength"=9,
	 *             "minLength"=8,
	 *             "description"="Het RSIN van deze organisatie. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef"
	 *         }
	 *     }
	 * )
	 */
	public $organisatie;	
	
	/**
	 * @Groups({"user:write","user"})
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	protected $isActief;
	
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
	 * De contactpersoon voor deze applicatie, die bijvoorbeeld word verwittigd bij misbruik.
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
	 *             "description"="URL-referentie naar de Ambtenaar verantwoordelijk voor deze applicatie"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $contactPersoon;
	
	
	/**
	 * API Specifieke parameters
	 *
	 * De onderstaande parameters worden alleen gebruikt bij api specifieke calls en hebben geen context tot het overige datamodel
	 */
	
	/**
	 * Een JWT Token waarmee de applicatie zich kan identificeren op de API
	 * 
	 * @Groups({"login_check"})
	 * @ApiProperty(
	 * 	   iri="https://schema.org/accessCode",
	 *     attributes={
	 *         "openapi_context"={
	 *             "description"="The security token, that needs to be set on the Authorization header, prefixed with with Bearer and a space (e.g.Authorization: Bearer [TOKEN]) in order to identify a request as being made by a specific user",
	 *             "type"="string",
	 *             "maxLength"=800,
	 *             "minLength"=850,
	 *             "example"="NotSoSecret"
	 *         }
	 *     }
	 * )
	 */
	private $token;
	
	/**
	 * Een refresh token die kan worden gebruikt om de geldigheid van een JWT token de verlengen
	 * 
	 * @Groups({"login_check"})
	 * @ApiProperty(
	 * 	   iri="https://schema.org/accessCode",
	 *     attributes={
	 *         "openapi_context"={
	 *             "description"="The refresh token, can be used on the token refresh action",
	 *             "type"="string",
	 *             "maxLength"=100,
	 *             "minLength"=130,
	 *             "example"="NotSoSecret"
	 *         }
	 *     }
	 * )
	 */
	private $refresh_token;	
	
	/**
	 * @return string
	 */
	public function toString(){
		return $this->name;
	}
	
	/**
	 * Vanuit rendering perspectief (voor bijvoorbeeld logging of berichten) is het belangrijk dat we een entiteit altijd naar string kunnen omzetten.
	 */
	public function __toString()
	{
		return $this->toString();
	}
	
	// We need a full name atribute for the loging bundle
	public function getFullname(): ?string
	{
		return $this->name;
	}
	
	public function isUser(?UserInterface $user = null): bool
	{
		return $user instanceof self && $user->id === $this->id;
	}
	
	public function __construct($username)
	{
		$this->isActive = true;
		$this->username = $username;
	}
	public function getUsername()
	{
		return $this->name;
	}	
	
	public function getPassword()
	{
		return $this->sleutel;
	}
	
	public function getSalt()
	{
		return null;
	}
	
	public function getRoles()
	{
		return array('ROLE_USER');
	}
	public function eraseCredentials()
	{
	}
}
