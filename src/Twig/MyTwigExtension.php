<?php
namespace App\Twig;

use App\Search\SearchFormGenerator;
use NumberFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MyTwigExtension extends AbstractExtension {

    private SearchFormGenerator $searchFormGenerator;

    /**
     * MyTwigExtension constructor.
     * @param SearchFormGenerator $searchFormGenerator
     */
    public function __construct(SearchFormGenerator $searchFormGenerator)
    {
        $this->searchFormGenerator = $searchFormGenerator;
    }

    public function getFilters() {
        return [
          new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function getFunctions() {
        return [
            new TwigFilter('randomBeatle', [$this, 'randomBeatle']),
            new TwigFunction('getSearchForm', [$this->searchFormGenerator,'getSearchForm'])
        ];
    }

    public function priceFilter(float $number): string{
        $fmt = new \NumberFormatter('fr_FR', \NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($number, "EUR");
    }

    public function randomBeatle(bool $withFamilyName = true): string {
        $beatles = [
            ["Paul", "McCartney"],
            ["John", "Lennon"],
            ["Ringo", "Starr"],
            ["George", "Harrison"],
            ["Bob", "Lennon"]
        ];

        $selected = rand(0, count($beatles) - 1);

        return $beatles[$selected][0] . $$withFamilyName ? ' ' .$beatles[$selected][1] : '';
    }

}