<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use App\Entity\Ambtenaar;

class AmbtenaarFixtureLoader extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$ambtenaar = new Ambtenaar();
		$ambtenaar->setBronOrganisatie('123456789');
		$ambtenaar->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
		$ambtenaar->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$ambtenaar->setVoornamen('Erik');
		$ambtenaar->setVoorvoegselGeslachtsnaam('');
		$ambtenaar->setGeslachtsnaam('Hendrik');
		$ambtenaar->setAanhef('Dhr.');
		$ambtenaar->setSamenvatting('<p>Als Buitengewoon Ambtenaar van de Burgerlijke Stand geef ik, in overleg met het bruidspaar, invulling aan de huwelijksceremonie.</p>');
		$ambtenaar->setBeschrijving('<p>Daarbij is mijn uitgangspunt dat het bruidspaar bepaalt in welke sfeer het huwelijk voltrokken gaat worden. Indien mogelijk streef ik tijdens de ceremonie naar interactie met het bruidspaar en met de gasten. Het is het mooiste als het bruidspaar zelf vertelt wat zij in elkaar zien en waarom zij met elkaar het leven willen delen.</p>  <p>Met een passende speech wil ik een goed beeld schetsen van het bruidspaar en van hun beweegredenen, maar ook van wat trouwen nou eigenlijk precies betekent. De speech probeer ik altijd aan een bij het paar passend thema te koppelen, iets wat als een rode draad door het verhaal loopt. Dat maakt iedere ceremonie passend bij het bruidspaar en dus uniek.</p>  <p>Tegenwoordig komt het steeds vaker voor, vanwege buitenlandse gasten bijvoorbeeld, dat er in het Engels gesproken moet worden. Dat is voor mij geen enkel probleem.</p>  <p>In de huwelijksenquete van de gemeente Utrecht over 2018 waarderen de bruidsparen mij op een 9,5 gemiddeld.</p>');
		
		$manager->persist($ambtenaar);
		
		$ambtenaar = new Ambtenaar();
		$ambtenaar->setBronOrganisatie('123456789');
		$ambtenaar->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/ike.jpg');
		$ambtenaar->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$ambtenaar->setVoornamen('Ike ');
		$ambtenaar->setVoorvoegselGeslachtsnaam('van den');
		$ambtenaar->setGeslachtsnaam('Pol');
		$ambtenaar->setAanhef('Mvr.');
		$ambtenaar->setSamenvatting('<p>Elkaar het Ja-woord geven, de officiele ceremonie. Vaak is dit het romantische hoogtepunt van de trouwdag. Een bijzonder moment, gedeeld met de mensen die je lief zijn. Een persoonlijke ceremonie, passend bij jullie relatie. Alles is bespreekbaar en maatwerk. Een originele trouwplechtigheid waar muziek, sprekers en kinderen een rol kunnen spelen. Een ceremonie met inhoud, ernst en humor, een traan en een lach, stijlvol, spontaan en ontspannen.</p>');
		$ambtenaar->setBeschrijving('');
		
		$manager->persist($ambtenaar);
		$ambtenaar = new Ambtenaar();
		$ambtenaar->setBronOrganisatie('123456789');
		$ambtenaar->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/rene.jpg');
		$ambtenaar->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$ambtenaar->setVoornamen('Rene');
		$ambtenaar->setVoorvoegselGeslachtsnaam('');
		$ambtenaar->setGeslachtsnaam('Gulje');
		$ambtenaar->setAanhef('Dhr.');
		$ambtenaar->setSamenvatting('<p>Ik ben Rene Gulje, in 1949 in Amsterdam geboren. Ik studeerde Nederlands aan de UVA en journalistiek aan de HU.</p>');
		$ambtenaar->setBeschrijving('<p>Het is voor mij iedere keer weer een eer om twee mensen te trouwen. De ceremonie vergt inhoudelijk en qua vorm een degelijke voorbereiding. Zo&rsquo;n voorbereidingsgesprek is voor mij altijd een belangrijke gebeurtenis: een trouwtoespraak moet diepgaand en luchtig van aard te zijn. In de combinatie van geest en geestig schuilt vaak het succes.</p>');
		
		$manager->persist($ambtenaar);
		$ambtenaar = new Ambtenaar();
		$ambtenaar->setBronOrganisatie('123456789');
		$ambtenaar->setAfbeelding('https://utrecht.trouwplanner.online/images/content/elements/Trouwambtenaren.png');
		$ambtenaar->setFilm('https://www.youtube.com/embed/RkBZYoMnx5w');
		$ambtenaar->setVoornamen('Toegewezen');
		$ambtenaar->setVoorvoegselGeslachtsnaam('');
		$ambtenaar->setGeslachtsnaam('Trouwambtenaar');
		$ambtenaar->setAanhef('');
		$ambtenaar->setSamenvatting('Uw trouwambtenaar wordt toegewezen, over enkele dagen krijgt u bericht van uw toegewezen trouwambtenaar!');
		$ambtenaar->setBeschrijving('Uw trouwambtenaar wordt toegewezen, over enkele dagen krijgt u bericht van uw toegewezen trouwambtenaar!');
		
		$manager->persist($ambtenaar);
		
		$manager->flush();
	}
}
