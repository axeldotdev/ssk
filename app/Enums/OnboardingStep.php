<?php

namespace App\Enums;

enum OnboardingStep: string
{
    case Account = 'account';
    case Company = 'company';
    case Activities = 'activities';
    case Collaborators = 'collaborators';
    case Done = 'done';
}
