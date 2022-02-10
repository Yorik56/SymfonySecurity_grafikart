<?php

namespace App\Security;

use App\DB_Factory\DBFactory;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

    public function refreshUser(UserInterface $user): UserInterface|User
    {
        // TODO: Implement refreshUser() method.
        // TODO VOIR EntityUserProvider::refreshUser
        #INFO On vérifie le type de class
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
        //-- On vérifie que l'utilisateur à un identifiant

        //-- On charge l'utilisateur depuis la base de données

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $db_mysql = DBFactory::create('mysql');
        $db_mysql_connexion = $db_mysql->connect([
            "HOSTNAME" =>  $_ENV['MYSQL_HOSTNAME'],
            "USERNAME" =>  $_ENV['MYSQL_USERNAME'],
            "PASSWORD" =>  $_ENV['MYSQL_PASSWORD'],
            "DATABASE" =>  $_ENV['MYSQL_DATABASE']
        ]);
        $data_mysql = $db_mysql->query($db_mysql_connexion, "SELECT * FROM user WHERE email= 'yorikmoreau@gmail.com'");
        $user = new User();
        $user->setId($data_mysql[0]['id']);
        $user->setEmail($data_mysql[0]['email']);
        $user->setRoles(json_decode($data_mysql[0]['roles']));
        $user->setPassword($data_mysql[0]['password']);

        return $user;
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);
    }
}