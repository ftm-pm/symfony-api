<?php

namespace App\Handler;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class UserHandler
 * @package App\Handler
 */
class UserHandler
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * UserHandler constructor.
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param User $user
     */
    public function hashPassword(User $user)
    {
        $plainPassword = $user->getPassword();

        if (0 !== strlen($plainPassword)) {
            $encoder = $this->encoderFactory->getEncoder($user);

            if ($encoder instanceof BCryptPasswordEncoder) {
                $user->setSalt(null);
            } else {
                $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
                $user->setSalt($salt);
            }

            $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($hashedPassword);
            $user->eraseCredentials();
        }
    }
}