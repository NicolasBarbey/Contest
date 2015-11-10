<?php
/**
 * This class has been generated by TheliaStudio
 * For more information, see https://github.com/thelia-modules/TheliaStudio
 */

namespace Contest\Controller;

use Contest\Controller\Base\ParticipateController as BaseParticipateController;
use Contest\Event\MailEvent;
use Contest\Event\MailEvents;
use Contest\Model\GameQuery;
use Contest\Model\Participate;
use Contest\Model\ParticipateQuery;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ParticipateController
 * @package Contest\Controller
 */
class ParticipateController extends BaseParticipateController
{

    /**
     * Generate Winner for a game
     * @param $id
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function generateWinnerAction($id)
    {
        $participates = ParticipateQuery::create()->filterByWin(true)->filterByGameId($id)->find();
        if ($participates) {
            $winner_index = rand(0, count($participates) - 1);
            /** @var Participate $winner */
            $winner = $participates[$winner_index];

            return $this->render("winner", ["participate_id", $winner->getId()]);
        } else {
            return $this->render("games");
        }

    }

    public function processMailWinnerAction($game_id, $id)
    {
        $game = GameQuery::create()->filterById($game_id)->findOne();
        $participate = ParticipateQuery::create()->filterById($id)->findOne();

        if ($game && $participate) {
            $event = new MailEvent();

            $event->setGame($game);
            $event->setParticipate($participate);
            try {
                $this->dispatch(MailEvents::SEND, $event);
            } catch (\Exception $e) {

            }

            return $this->render("winner", ["participate_id", $id]);
        }

        return $this->render("games");
    }

}
