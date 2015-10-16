<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Contest\Action\Base;

use Contest\Model\Map\ParticipateTableMap;
use Contest\Event\ParticipateEvent;
use Contest\Event\ParticipateEvents;
use Contest\Model\ParticipateQuery;
use Contest\Model\Participate;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\ToggleVisibilityEvent;
use Thelia\Core\Event\UpdatePositionEvent;
use Propel\Runtime\Propel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\TheliaEvents;
use \Thelia\Core\Event\TheliaFormEvent;

/**
 * Class ParticipateAction
 * @package Contest\Action
 * @author TheliaStudio
 */
class ParticipateAction extends BaseAction implements EventSubscriberInterface
{
    public function create(ParticipateEvent $event)
    {
        $this->createOrUpdate($event, new Participate());
    }

    public function update(ParticipateEvent $event)
    {
        $model = $this->getParticipate($event);

        $this->createOrUpdate($event, $model);
    }

    public function delete(ParticipateEvent $event)
    {
        $this->getParticipate($event)->delete();
    }

    protected function createOrUpdate(ParticipateEvent $event, Participate $model)
    {
        $con = Propel::getConnection(ParticipateTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            if (null !== $id = $event->getId()) {
                $model->setId($id);
            }

            if (null !== $email = $event->getEmail()) {
                $model->setEmail($email);
            }

            if (null !== $win = $event->getWin()) {
                $model->setWin($win);
            }

            if (null !== $gameId = $event->getGameId()) {
                $model->setGameId($gameId);
            }

            if (null !== $customerId = $event->getCustomerId()) {
                $model->setCustomerId($customerId);
            }

            $model->save($con);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollback();

            throw $e;
        }

        $event->setParticipate($model);
    }

    protected function getParticipate(ParticipateEvent $event)
    {
        $model = ParticipateQuery::create()->findPk($event->getId());

        if (null === $model) {
            throw new \RuntimeException(sprintf(
                "The 'participate' id '%d' doesn't exist",
                $event->getId()
            ));
        }

        return $model;
    }

    public function beforeCreateFormBuild(TheliaFormEvent $event)
    {
    }

    public function beforeUpdateFormBuild(TheliaFormEvent $event)
    {
    }

    public function afterCreateFormBuild(TheliaFormEvent $event)
    {
    }

    public function afterUpdateFormBuild(TheliaFormEvent $event)
    {
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            ParticipateEvents::CREATE => array("create", 128),
            ParticipateEvents::UPDATE => array("update", 128),
            ParticipateEvents::DELETE => array("delete", 128),
            TheliaEvents::FORM_BEFORE_BUILD . ".participate_create" => array("beforeCreateFormBuild", 128),
            TheliaEvents::FORM_BEFORE_BUILD . ".participate_update" => array("beforeUpdateFormBuild", 128),
            TheliaEvents::FORM_AFTER_BUILD . ".participate_create" => array("afterCreateFormBuild", 128),
            TheliaEvents::FORM_AFTER_BUILD . ".participate_update" => array("afterUpdateFormBuild", 128),
        );
    }
}