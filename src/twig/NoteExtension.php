<?php


namespace App\twig;


use App\Repository\GameRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NoteExtension extends AbstractExtension

{

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var Environment
     */
    private $twigEnvironement;

    /**
     * NoteExtension constructor.
     * @param GameRepository $gameRepository
     * @param Environment $twigEnvironement
     */
    public function __construct(GameRepository $gameRepository, Environment $twigEnvironement)
    {
        $this->gameRepository = $gameRepository;
        $this->twigEnvironement = $twigEnvironement;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_stars_note', [$this, 'getStarsNote'])
        ];
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getStarsNote()

    {
        $games = $this->gameRepository->findAll();
        return $this->twigEnvironement->render('home/index.html.twig',[
            'games'=>$games
        ]);

    }


}