<?php


namespace App\Upload;


use App\Entity\User;

class UserImage
{

    public function save($file, User $user, $directory){

        $newFileName = $user->getNom() . '-' . uniqid() . '.' . $file->guessExtension();
        $file->move($directory, $newFileName);
        $user->setPhoto($newFileName);

    }



}