// statesAndCities.js
const statesAndCities = {
    'Tunis': ['Le Bardo', 'Le Kram', 'La Goulette', 'Carthage', 'Sidi Bou Said', 'La Marsa', 'Sidi Hassine'],
    'Ariana': ['La Soukra', 'Raoued', 'Kalâat el-Andalous', 'Sidi Thabet', 'Ettadhamen-Mnihla'],
    // Add more states and cities as needed
};

export default statesAndCities;

/*
<?php

namespace App\Entity;

use App\Repository\StateAndCityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateAndCityRepository::class)]
class StateAndCity
{
    public const STATES = [
    'Tunis' => 'Tunis',
    'Ariana' => 'Ariana',
    'Ben Arous' => 'Ben Arous',
    'Manouba' => 'Manouba',
    'Nabeul' => 'Nabeul',
    'Zaghouan' => 'Zaghouan',
    'Bizerte' => 'Bizerte',
    'Béja' => 'Béja',
    'Jendouba' => 'Jendouba',
    'Kef' => 'Kef',
    'Siliana' => 'Siliana',
    'Sousse' => 'Sousse',
    'Monastir' => 'Monastir',
    'Mahdia' => 'Mahdia',
    'Sfax' => 'Sfax',
    'Kairouan' => 'Kairouan',
    'Kasserine' => 'Kasserine',
    'Sidi Bouzid' => 'Sidi Bouzid',
    'Gabès' => 'Gabès',
    'Medenine' => 'Medenine',
    'Tataouine' => 'Tataouine',
    'Gafsa' => 'Gafsa',
    'Tozeur' => 'Tozeur',
    'Kebili' => 'Kebili'
];
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
    private ?int $id = null;

#[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $state = [];

#[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $city = [];

    public function __construct()
{
    $this->state = ['Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Nabeul', 'Zaghouan', 'Bizerte', 'Béja', 'Jendouba', 'Kef', 'Siliana', 'Sousse', 'Monastir', 'Mahdia', 'Sfax', 'Kairouan', 'Kasserine', 'Sidi Bouzid', 'Gabès', 'Medenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kebili',]; // Add more states as needed
    $this->city = [
        'Tunis' => [
    'Le Bardo',
    'Le Kram',
    'La Goulette',
    'Carthage',
    'Sidi Bou Said',
    'La Marsa',
    'Sidi Hassine',
],
    'Ariana' => [
    'La Soukra',
    'Raoued',
    'Kalâat el-Andalous',
    'Sidi Thabet',
    'Ettadhamen-Mnihla',
],
    'Ben Arous' => [
    'El Mourouj',
    'Hammam Lif',
    'Hammam Chott',
    'Bou Mhel el-Bassatine',
    'Ezzahra',
    'Radès',
    'Mégrine',
    'Mohamedia-Fouchana',
    'Mornag',
    'Khalidia',
],
    'Manouba' => [
    'Den Den',
    'Douar Hicher',
    'Oued Ellil',
    'Mornaguia',
    'Borj El Amri',
    'Djedeida',
    'Tebourba',
    'El Battan',
],
    'Nabeul' => [
    'Dar Chaabane',
    'Béni Khiar',
    'El Maâmoura',
    'Somâa',
    'Korba',
    'Tazerka',
    'Menzel Temime',
    'Menzel Horr',
    'El Mida',
    'Kelibia',
    'Azmour',
    'Hammam Ghezèze',
    'Dar Allouch',
    'El Haouaria',
    'Takelsa',
    'Soliman',
    'Korbous',
    'Menzel Bouzelfa',
    'Béni Khalled',
    'Zaouiet Djedidi',
    'Grombalia',
    'Bou Argoub',
    'Hammamet',
],
    'Zaghouan' => [
    'Zriba',
    'Bir Mcherga',
    'Djebel Oust',
    'El Fahs',
    'Nadhour',
],
    'Bizerte' => [
    'Sejnane',
    'Mateur',
    'Menzel Bourguiba',
    'Tinja',
    'Ghar al Milh',
    'Aousja',
    'Menzel Jemil',
    'Menzel Abderrahmane',
    'El Alia',
    'Ras Jebel',
    'Metline',
    'Raf Raf',
],
    'Béja' => [
    'El Maâgoula',
    'Zahret Medien',
    'Nefza',
    'Téboursouk',
    'Testour',
    'Goubellat',
    'Majaz al Bab',
],
    'Jendouba' => [
    'Bou Salem',
    'Tabarka',
    'Aïn Draham',
    'Fernana',
    'Beni MTir',
    'Ghardimaou',
    'Oued Melliz',
],
    'Kef' => [
    'El Kef',
    'Nebeur',
    'Touiref',
    'Sakiet Sidi Youssef',
    'Tajerouine',
    'Menzel Salem',
    'Kalaat es Senam',
    'Kalâat Khasba',
    'Jérissa',
    'El Ksour',
    'Dahmani',
    'Sers',
],
    'Siliana' => [
    'Bou Arada',
    'Gaâfour',
    'El Krib',
    'Sidi Bou Rouis',
    'Maktar',
    'Rouhia',
    'Kesra',
    'Bargou',
    'El Aroussa',
],
    'Sousse' => [
    'Ksibet Thrayet',
    'Ezzouhour',
    'Zaouiet Sousse',
    'Hammam Sousse',
    'Akouda',
    'Kalâa Kebira',
    'Sidi Bou Ali',
    'Hergla',
    'Enfidha',
    'Bouficha',
    'Sidi El Hani',
    'Msaken',
    'Kalâa Seghira',
    'Messaadine',
    'Kondar',
],
    'Monastir' => [
    'Khniss',
    'Ouerdanin',
    'Sahline Moôtmar',
    'Sidi Ameur',
    'Zéramdine',
    'Beni Hassen',
    'Ghenada',
    'Jemmal',
    'Menzel Kamel',
    'Zaouiet Kontoch',
    'Bembla-Mnara',
    'Menzel Ennour',
    'El Masdour',
    'Moknine',
    'Sidi Bennour',
    'Menzel Farsi',
    'Amiret El Fhoul',
    'Amiret Touazra',
    'Amiret El Hojjaj',
    'Cherahil',
    'Bekalta',
    'Téboulba',
    'Ksar Hellal',
    'Ksibet El Mediouni',
    'Benen Bodher',
    'Touza',
    'Sayada',
    'Lemta',
    'Bouhjar',
    'Menzel Hayet',
],
    'Mahdia' => [
    'Rejiche',
    'Bou Merdes',
    'Ouled Chamekh',
    'Chorbane',
    'Hebira',
    'Essouassi',
    'El Djem',
    'Kerker',
    'Chebba',
    'Melloulèche',
    'Sidi Alouane',
    'Ksour Essef',
    'El Bradâa',
],
    'Sfax' => [
    'Sakiet Ezzit',
    'Chihia',
    'Sakiet Eddaïer',
    'Gremda',
    'El Ain',
    'Thyna',
    'Agareb',
    'Jebiniana',
    'El Hencha',
    'Menzel Chaker',
    'Ghraïba, Tunisia',
    'Bir Ali Ben Khélifa',
    'Skhira',
    'Mahares',
    'Kerkennah',
],
    'Kairouan' => [
    'Chebika',
    'Sbikha',
    'Oueslatia',
    'Aïn Djeloula',
    'Haffouz',
    'Alaâ',
    'Hajeb El Ayoun',
    'Nasrallah',
    'Menzel Mehiri',
    'Echrarda',
    'Bou Hajla',
],
    'Kasserine' => [
    'Sbeitla',
    'Sbiba',
    'Jedelienne',
    'Thala',
    'Haïdra',
    'Foussana',
    'Fériana',
    'Thélepte',
    'Magel Bel Abbès',
],
    'Sidi Bouzid' => [
    'Jilma',
    'Cebalet',
    'Bir El Hafey',
    'Sidi Ali Ben Aoun',
    'Menzel Bouzaiane',
    'Meknassy',
    'Mezzouna',
    'Regueb',
    'Ouled Haffouz',
],
    'Gabès' => [
    'Chenini Nahal',
    'Ghannouch',
    'Métouia',
    'Oudhref',
    'El Hamma',
    'Matmata',
    'Nouvelle Matmata',
    'Mareth',
    'Zarat',
],
    'Medenine' => [
    'Beni Khedache',
    'Ben Gardane',
    'Zarzis',
    'Houmt El Souk (Djerba)',
    'Midoun (Djerba)',
    'Ajim (Djerba)',
],
    'Tataouine' => [
    'Bir Lahmar',
    'Ghomrassen',
    'Dehiba',
    'Remada',
],
    'Gafsa' => [
    'El Ksar',
    'Moularès',
    'Redeyef',
    'Métlaoui',
    'Mdhila',
    'El Guettar',
    'Sened',
],
    'Tozeur' => [
    'Degache',
    'Hamet Jerid',
    'Nafta',
    'Tamerza',
],
    'Kebili' => [
    'Djemna',
    'Douz',
    'El Golâa',
    'Souk Lahad',
],
];
}

    public function getId(): ?int
{
    return $this->id;
}

    public function getState(): array
{
    return $this->state;
}

    public function setState(array $state): static
{
    $this->state = $state;

    return $this;
}

    public function getCity(): array
{
    return $this->city;
}

    public function setCity(array $city): static
{
    $this->city = $city;

    return $this;
}
}*/
