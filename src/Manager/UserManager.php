<?php


namespace App\Manager;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
   protected $entityManager;
    /**
     * @var UserRepository
     */
   protected $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
   protected $passwordEncoder;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
   public function __construct(
       EntityManagerInterface $entityManager,
       UserRepository $userRepository,
       UserPasswordEncoderInterface $passwordEncoder
   )
   {
       $this->entityManager = $entityManager;
       $this->passwordEncoder = $passwordEncoder;
       $this->userRepository = $userRepository;
   }

    /**
     * @param string $username
     * @return $user|null
     */
   public function findUsername(string $username)
   {
       $user = $this->userRepository->findByUsername($username);

       if ($user)
       {
           return $user[0];
       }

       return null;
   }
    /**
     * @param User $user
     * @return array
     * @throws \Exception
     */
   public function registerUser(User $user)
   {
       if($this->findUsername($user->getUsername()))
       {
           throw new BadRequestException("Cet utilisateur existe déjà");
       }
       //Encode User Password
       $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
       $user->setPassword($password);

       //Set Date
       $user->setCreatedAt(new \DateTimeImmutable());
       $user->setUpdatedAt(new \DateTimeImmutable());

       //Persist & save
       $this->entityManager->persist($user);
       $this->entityManager->flush();

       return [
              'statut'=>'SUCCESS',
             'Message'=>"Utilisateur crée avec succès",
             'user'=>$user
       ];

   }

    /**
     * @param User $user
     * @return array
     * @throws \Exception
     */
   public function updateUser(User $user)
   {
       if($this->findUsername($user->getUsername()))
       {
           throw new BadRequestException("Cet utilisateur existe déjà");
       }
       $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
       $user->setPassword($password);

       //Set Date
       $user->setUpdatedAt(new \DateTimeImmutable());

       //Persist & save
       $this->entityManager->persist($user);
       $this->entityManager->flush();

       return [
           'statut'=>'SUCCESS',
           'Message'=>"Utilisateur modifié avec succès",
           'user'=>$user
       ];

   }

    /**
     * @return User[]
     */
    public function showUser()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showOneUser($id)
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @param User $data
     * @return array
     */
    public function loginUser(User $data)
    {
        $user = $this->findUsername($data->getUsername());
        if($user)
        {
            $password = $this->passwordEncoder->encodePassword($user,$data->getPassword());
            if($this->passwordEncoder->isPasswordValid($user,$data->getPassword()))
                return [
                    'statut'=>'SUCCESS',
                    'message'=>"Utilisateur authentifié avec succès",
                    'user'=>$user
                ];
            return [
                'statut'=>'PROGRESS',
                'message'=>"Les mots de passe ne correspondent pas"
            ];

        }
        return [
            'statut'=>'FAIL',
            'message'=>"Utilisateur inexistant"
        ];

    }
    public function passwordReset(User $data)
    {
        $user = $this->findUsername($data->getUsername());
        if($user)
        {
            //Encode User Password
            $password = $this->passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            return [
                'status'=>'SUCCESS',
                'message'=>'Mot de passe modifié avec succès'
            ];
        }
        return [
            'statut'=>'FAIL',
            'message'=>"Utilisateur inexistant"
        ];

    }
}