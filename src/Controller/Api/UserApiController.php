<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserApiController extends ApiController
{
    /**
     * 
     * @param array $roles
     * @return boolean
     */
    private function _isAdmin(array $roles)
    {
        return in_array('ROLE_ADMIN', $roles);
    }
    
    /**
     *
     * @param array $users
     * @return array
     */
    private function _setJson(array $users) 
    {
        $usersJSON = [];

        foreach ($users as $user) {
            
            if ($this->_isAdmin($user->getRoles())) {
                $role = "admin";
            } else {
                $role = "user";
            }

            $userInfo = [
                "name" => $user->getUsername(),
                "roles" => $role,
                "campsCount" => $user->getCampsCount(),
            ];

            array_push($usersJSON, $userInfo);
        };

        return $usersJSON;
    }

    /**
     * @param string $entityname
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allUsers = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();


        $response = new JsonResponse($this->_setJson($allUsers), 200);

        return $response;
    }
}
