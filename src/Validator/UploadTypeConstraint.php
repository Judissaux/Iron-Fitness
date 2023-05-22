<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints\File;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UploadTypeConstraint extends File
{    
}