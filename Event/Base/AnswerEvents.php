<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Contest\Event\Base;

use Contest\Event\Module\ContestEvents as ChildContestEvents;

/*
 * Class AnswerEvents
 * @package Contest\Event\Base
 * @author TheliaStudio
 */
class AnswerEvents
{
    const CREATE = ChildContestEvents::ANSWER_CREATE;
    const UPDATE = ChildContestEvents::ANSWER_UPDATE;
    const DELETE = ChildContestEvents::ANSWER_DELETE;
    const TOGGLE_VISIBILITY = ChildContestEvents::ANSWER_TOGGLE_VISIBILITY;
}