<?php 
namespace App\Controllers;
use App\Models\User;
use Respect\Validation\Validator as v;

class UsersController extends BaseController {
 
    public function createUserAction($request) {
        $responseMessage = null;
        if ($request->getMethod() == 'POST'){
            $postData = $request->getParsedBody();
            $userValidator = v::key('user_name', v::stringType()->notEmpty())
                  ->key('user_email', v::email())
                  ->key('user_password', v::stringType()->notEmpty());

            $securePassword = password_hash($postData['user_password'], PASSWORD_DEFAULT);
            try {
                $userValidator->assert($postData);
                $postData = $request->getParsedBody();
                $user = new User();
                $user->user_name = $postData['user_name'];
                $user->user_email = $postData['user_email'];
                $user->user_password = $securePassword;
                $user->save();
                $responseMessage = 'USER CREATED SUCCESFULLY';
            }
            catch (\Exception $e) {
                $responseMessage = $e->getMessage();

            }
 

         

        }
        return $this->renderHTML('createUser.twig', [
            'responseMessage'=> $responseMessage,
        ]);
    }
}
?>
