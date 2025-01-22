<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;

/**
 * @see https://symfony.com/doc/current/security/custom_authenticator.html
 */
class CustomAuthenticator extends AbstractAuthenticator
{

    private RouterInterface $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }


    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        // schaut als erstes, ob dieser authenticator zuständig ist → security.yaml
        $vonLogin = $request->getPathInfo() === '/login';
        $istPost = $request->getMethod() === 'POST';

        // kommt es von login und übermittelt etwas mit POST, dann TRUE und es geht weiter ->[authenticate()]
//        dd($request->request->all());
        return $istPost && $vonLogin;
//        return false;
//        dd('das ist die erste Methode');

        // return $request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {

        // wer bist du und kannst du das beweisen (Authentifizierung)?
        $email = $request->request->get('email');
        $password = $request->request->get('password');
//        dd($email, $password);

        return new Passport(
            // manuell erstellter User
//            new UserBadge($email, function() {
//                $user = new User();
//                $user->setEmail('hallo')
//                    ->setFName('Peter')
//                    ->setLName('Pan');
//                return $user;
//            }),
////


            new UserBadge($email),
            new CustomCredentials(function ($credentials, User $user) {
//                dd($credentials, $user);

                return $credentials === '123456';
            }
            , $password)
        );





        // $apiToken = $request->headers->get('X-AUTH-TOKEN');
        // if (null === $apiToken) {
        // The token header was empty, authentication fails with HTTP Status
        // Code 401 "Unauthorized"
        // throw new CustomUserMessageAuthenticationException('No API token provided');
        // }

        // implement your own logic to get the user identifier from `$apiToken`
        // e.g. by looking up a user in the database using its API key
        // $userIdentifier = /** ... */;

        // return new SelfValidatingPassport(new UserBadge($userIdentifier));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue

//        dd('er ist drin');
        return new RedirectResponse($this->router->generate('app_ticket_index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->router->generate('app_login'));

//        dd('er ist nicht drin', $exception);

//        $data = [
            // you may want to customize or obfuscate the message first
//            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),

//             or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
//        ];

//        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    // public function start(Request $request, ?AuthenticationException $authException = null): Response
    // {
    //     /*
    //      * If you would like this class to control what happens when an anonymous user accesses a
    //      * protected page (e.g. redirect to /login), uncomment this method and make this class
    //      * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
    //      *
    //      * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //      */
    // }
}
