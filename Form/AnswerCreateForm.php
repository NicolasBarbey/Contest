<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Contest\Form;

use Contest\Contest;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class AnswerCreateForm
 * @package Contest\Form\Base
 * @author TheliaStudio
 */
class AnswerCreateForm extends BaseForm
{
    const FORM_NAME = "answer_create";

    public function buildForm()
    {
        $translationKeys = $this->getTranslationKeys();
        $fieldsIdKeys = $this->getFieldsIdKeys();

        $this->addVisibleField($translationKeys, $fieldsIdKeys);
        $this->addCorrectField($translationKeys, $fieldsIdKeys);
        $this->addTitleField($translationKeys, $fieldsIdKeys);
        $this->addDescriptionField($translationKeys, $fieldsIdKeys);
        $this->addQuestionIdField($translationKeys, $fieldsIdKeys);
        $this->addLocaleField();
    }

    public function addLocaleField()
    {
        $this->formBuilder->add(
            'locale',
            HiddenType::class,
            [
                'constraints' => [ new NotBlank() ],
                'required'    => true,
            ]
        );
    }

    protected function addVisibleField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("visible", CheckboxType::class, array(
            "label" => $this->translator->trans($this->readKey("visible", $translationKeys), [], Contest::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("visible", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addCorrectField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("correct", CheckboxType::class, array(
            "label" => $this->translator->trans($this->readKey("correct", $translationKeys), [], Contest::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("correct", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addTitleField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("title", TextType::class, array(
            "label" => $this->translator->trans($this->readKey("title", $translationKeys), [], Contest::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("title", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addDescriptionField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("description", TextareaType::class, array(
            "label" => $this->translator->trans($this->readKey("description", $translationKeys), [], Contest::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("description", $fieldsIdKeys)],
            "required" => false,
            "constraints" => array(
            ),
            "attr" => array(
            )
        ));
    }

    protected function addQuestionIdField(array $translationKeys, array $fieldsIdKeys)
    {
        $this->formBuilder->add("question_id", IntegerType::class, array(
            "label" => $this->translator->trans($this->readKey("question_id", $translationKeys), [], Contest::MESSAGE_DOMAIN),
            "label_attr" => ["for" => $this->readKey("question_id", $fieldsIdKeys)],
            "required" => true,
            "constraints" => array(
                new NotBlank(),
            ),
            "attr" => array(
            )
        ));
    }

    public static function getName()
    {
        return static::FORM_NAME;
    }

    public function readKey($key, array $keys, $default = '')
    {
        if (isset($keys[$key])) {
            return $keys[$key];
        }

        return $default;
    }

    public function getTranslationKeys()
    {
        return array(
            "visible" => "Visible",
            "correct" => "Correct",
            "title" => "Title",
            "description" => "Description",
            "question_id" => "Question id",
        );
    }

    public function getFieldsIdKeys()
    {
        return array(
            "visible" => "answer_visible",
            "correct" => "answer_correct",
            "title" => "answer_title",
            "description" => "answer_description",
            "question_id" => "answer_question_id",
        );
    }
}
