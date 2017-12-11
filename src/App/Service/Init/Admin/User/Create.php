<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Core\App\Service\Init\Admin\User;

/**
 * Simple process that creates new Admin User with given role.
 */
class Create
{
    const OPT_EMAIL = 'email';
    const OPT_NAME_FIRST = 'name_first';
    const OPT_NAME_LAST = 'name_last';
    const OPT_PASSWORD = 'password';
    const OPT_ROLE_ID = 'role_id';
    const OPT_USER_NAME = 'user_name';
    /* boolean: true - new user is created, 'false' - user with the same name already exists */
    const RES_CREATED_AS_NEW = 'created_as_new';

    /** @var \Magento\User\Model\UserFactory */
    protected $factoryUser;

    public function __construct(
        \Magento\User\Model\UserFactory $factoryUser
    ) {
        $this->factoryUser = $factoryUser;
    }

    public function exec(\Praxigento\Core\Data $ctx)
    {
        /* get input options from context */
        $username = $ctx->get(self::OPT_USER_NAME);
        $nameFirst = $ctx->get(self::OPT_NAME_FIRST);
        $nameLast = $ctx->get(self::OPT_NAME_LAST);
        $password = $ctx->get(self::OPT_PASSWORD);
        $email = $ctx->get(self::OPT_EMAIL);
        $roleId = $ctx->get(self::OPT_ROLE_ID);

        /* perform requested action */
        $userOdoo = $this->factoryUser->create();
        $userOdoo->loadByUsername($username);
        $userCreated = null;
        if ($username != $userOdoo->getUserName()) {
            $userOdoo->setFirstName($nameFirst);
            $userOdoo->setLastName($nameLast);
            $userOdoo->setUserName($username);
            $userOdoo->setPassword($password);
            $userOdoo->setEmail($email);
            $userOdoo->setRoleId($roleId);
            $userOdoo->save();
            $userCreated = true;
        } else {
            $userCreated = false;
        }

        /* place results back to context */
        $ctx->set(self::RES_CREATED_AS_NEW, $userCreated);
    }
}