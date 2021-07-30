<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Contest\Controller\Base;

use Contest\Form\AnswerCreateForm;
use Contest\Form\AnswerUpdateForm;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\AbstractCrudController;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Tools\URL;
use Contest\Event\AnswerEvent;
use Contest\Event\AnswerEvents;
use Contest\Model\AnswerQuery;
use Thelia\Core\Event\ToggleVisibilityEvent;

/**
 * Class AnswerController
 * @package Contest\Controller\Base
 * @author TheliaStudio
 */
class AnswerController extends AbstractCrudController
{
    public function __construct()
    {
        parent::__construct(
            "answer",
            "id",
            "order",
            AdminResources::MODULE,
            AnswerEvents::CREATE,
            AnswerEvents::UPDATE,
            AnswerEvents::DELETE,
            AnswerEvents::TOGGLE_VISIBILITY,
            null,
            "Contest"
        );
    }

    /**
     * Return the creation form for this object
     */
    protected function getCreationForm()
    {
        return $this->createForm(AnswerCreateForm::FORM_NAME);
    }

    /**
     * Return the update form for this object
     */
    protected function getUpdateForm($data = array())
    {
        if (!is_array($data)) {
            $data = array();
        }

        return $this->createForm(AnswerUpdateForm::FORM_NAME, FormType::class, $data);
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
     *
     * @param mixed $object
     */
    protected function hydrateObjectForm(ParserContext $parserContext, $object)
    {
        $data = array(
            "id" => $object->getId(),
            "visible" => (bool) $object->getVisible(),
            "correct" => (bool) $object->getCorrect(),
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "question_id" => $object->getQuestionId(),
        );

        return $this->getUpdateForm($data);
    }

    /**
     * Creates the creation event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getCreationEvent($formData)
    {
        $event = new AnswerEvent();

        $event->setVisible($formData["visible"]);
        $event->setCorrect($formData["correct"]);
        $event->setTitle($formData["title"]);
        $event->setDescription($formData["description"]);
        $event->setQuestionId($formData["question_id"]);

        return $event;
    }

    /**
     * Creates the update event with the provided form data
     *
     * @param mixed $formData
     * @return \Thelia\Core\Event\ActionEvent
     */
    protected function getUpdateEvent($formData)
    {
        $event = new AnswerEvent();

        $event->setId($formData["id"]);
        $event->setCorrect($formData["correct"]);
        $event->setTitle($formData["title"]);
        $event->setDescription($formData["description"]);
        $event->setQuestionId($formData["question_id"]);

        return $event;
    }

    /**
     * Creates the delete event with the provided form data
     */
    protected function getDeleteEvent()
    {
        $event = new AnswerEvent();

        $event->setId($this->getRequest()->request->get("answer_id"));

        return $event;
    }

    /**
     * Return true if the event contains the object, e.g. the action has updated the object in the event.
     *
     * @param mixed $event
     */
    protected function eventContainsObject($event)
    {
        return null !== $this->getObjectFromEvent($event);
    }

    /**
     * Get the created object from an event.
     *
     * @param mixed $event
     */
    protected function getObjectFromEvent($event)
    {
        return $event->getAnswer();
    }

    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        return AnswerQuery::create()
            ->findPk($this->getRequest()->query->get("answer_id"))
        ;
    }

    /**
     * Returns the object label form the object event (name, title, etc.)
     *
     * @param mixed $object
     */
    protected function getObjectLabel($object)
    {
        return $object->getTitle();
    }

    /**
     * Returns the object ID from the object
     *
     * @param mixed $object
     */
    protected function getObjectId($object)
    {
        return $object->getId();
    }

    /**
     * Render the main list template
     *
     * @param mixed $currentOrder , if any, null otherwise.
     */
    protected function renderListTemplate($currentOrder)
    {
        $this->getParser()
            ->assign("order", $currentOrder)
        ;

        return $this->render("answers");
    }

    /**
     * Render the edition template
     */
    protected function renderEditionTemplate()
    {
        $this->getParserContext()
            ->set(
                "answer_id",
                $this->getRequest()->query->get("answer_id")
            )
        ;

        return $this->render("answer-edit");
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToEditionTemplate()
    {
        $id = $this->getRequest()->query->get("answer_id");

        return new RedirectResponse(
            URL::getInstance()->absoluteUrl(
                "/admin/module/Contest/answer/edit",
                [
                    "answer_id" => $id,
                ]
            )
        );
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToListTemplate()
    {
        return new RedirectResponse(
            URL::getInstance()->absoluteUrl("/admin/module/Contest/answer")
        );
    }

    protected function createToggleVisibilityEvent()
    {
        return new ToggleVisibilityEvent($this->getRequest()->query->get("answer_id"));
    }
}
