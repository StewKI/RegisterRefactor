<?php

declare(strict_types=1);


namespace App\Validation\Validators;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Validation\RuleInterface;
use App\Contracts\Validation\Validators\UserRegistrationValidatorInterface;
use App\Validation\Rules\EmailFormatRule;
use App\Validation\Rules\EmailNotTakenRule;
use App\Validation\Rules\EqualsRule;
use App\Validation\Rules\PasswordRule;
use App\Validation\Rules\RequiredRule;

class UserRegistrationValidator implements UserRegistrationValidatorInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function validate(array $data): void
    {
        $rules = $this->getRules();

        $this->validateAllRules($rules, $data);
    }

    /**
     * @param RuleInterface[] $rules
     */
    private function validateAllRules(array $rules, array $data): void
    {
        foreach ($rules as $rule) {
            $rule->validate($data);
        }
    }

    /**
     * @return RuleInterface[]
     */
    private function getRules(): array
    {
        return [
            new RequiredRule(["email", "password", "password2"]),
            new PasswordRule(["password", "password2"]),
            new EmailFormatRule('email'),
            new EqualsRule("password", "password2", mismatchName: "password"),
            new EmailNotTakenRule("email", $this->userRepository),
        ];
    }
}