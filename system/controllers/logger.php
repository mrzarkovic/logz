<?php

namespace Tourizm\Controller;

use \Tourizm\Model\User;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logger extends Core
{
   public function __construct()
   {
      parent::__construct();
      $this->page_name = "Login";
   }

   public function login()
   {
      if ( !empty( $_POST ) )
      {
         $this->_login_user();
      }
      $this->template = "login";
   }

   private function _login_user()
   {
      // Check input
      if ( ( $_POST['username'] == '' ) || ( $_POST['password'] == '' ) )
      {
        $this->msg_to_user = "Morate popuniti sva polja.";
      }
      else
      {
         $user = new User();
         if ( $user->login_user( $_POST['username'], $_POST['password'] ) )
         {
            header('Location: /admin/manage-destinations');
         }
         else
         {
           $this->msg_to_user = "Pogrešan username ili password.";
           return false;
         }
      }
   }

   public function logout()
   {
      $user = new User();
      $user->logout_user();
   }
}
