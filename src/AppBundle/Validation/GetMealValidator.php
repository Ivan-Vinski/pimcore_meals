<?php


namespace AppBundle\Validation;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class GetMealValidator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data) : ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection([
            'lang' => new Assert\NotNull([
                'message' => 'Lang is required'
            ]),
            'per_page' => new Assert\Type([
                'message' => 'per_page must be number',
                'type' => 'numeric'
            ]),
            'page' => new Assert\Type([
                'message' => 'page must be number',
                'type' => 'numeric'
            ]),
            'diff_time' => new Assert\Type([
                'message' => 'diff_time must be numeric',
                'type' => 'numeric'
            ]),
            'with' => new Assert\Choice([
                'message' => 'bla',
                'multiple' => true,
                'choices' => ['category', 'ingredients', 'tags']
            ])
        ]);

        return $errors = $this->validator->validate($data, $constraint);
    }
}
