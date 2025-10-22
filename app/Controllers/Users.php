<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    public function index()//: string
    {
        return view('register');
    }

    public function create()
    {        
        $rules = [ 
            'user' => 'required|max_length[30]|is_unique[users.user]',
            'password' => 'required|max_length[50]|min_length[5]',
            'repassword' => 'matches[password]',
            'name' => 'required|max_length[100]',
            'email' => 'required|max_length[80]|valid_email|is_unique[users.email]'
        ];

        if(!$this->validate($rules)){            
           return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['user','password','name','email']);
        $token = bin2hex(random_bytes(20));

        $userModel->insert([
            'user'=>$post['user'],
            'password'=>password_hash($post['password'],PASSWORD_DEFAULT),
            'name'=>$post['name'],
            'email'=>$post['email'],
            'active'=> 0,
            'activation_token'=>$token
        ]);

        $email = \config\Services::email();
        $email->setTo($post['email']);
        $email->setSubject('Activa tu cuenta');

        $url = base_url('activate-user/'.$token);
        $body = '<p>Hola '. $post['name'] .'</p>';
        $body .= '<p>Para continuar con el proceso de registro, has click en el siguiente link <a href='.$url.'>ActivaCuenta</a></p>';
        $body .= 'Gracias!';

        $email->setMessage($body);
        $email->send();
        
        $title = 'Registro existoso';
        $message = 'Revisa tu correo electronico para activar tu cuenta.';

        return $this->showMessage($title,$message);
    }

    private function showMessage($title,$message){
        $data = [
            'title'=> $title,
            'message'=> $message,
        ];
        return view('message',$data);

    }

    public function activateUser($token){
        $userModel = new UsersModel();
        $user = $userModel->where(['activation_token'=>$token,'active'=>0])->first();

        if($user){
            $userModel->update(
                $user['id'],
                [
                    'active' => 1,
                    'activation_token' => ''
                ]
                );

                return $this->showMessage('Cuenta activa','Tu cuenta ha sido activada');
        }

        return $this->showMessage('Error','Intenta mas tarde.');
    }

    public function linkRequestForm(){
        return view('link_request');

    }

    public function sendRequestLinkEmail(){

        $rules = [ 
            'email' => 'required|max_length[80]|valid_email'
        ];

        if(!$this->validate($rules)){            
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
         }
 
         $userModel = new UsersModel();
         $post = $this->request->getPost(['email']);
         $user = $userModel->where(['email'=>$post['email'],'active' => 1])->first();

         if($user){
            $token = bin2hex(random_bytes(20));
            $expiresAt = new \DateTime();
            $expiresAt->modify('+1 hour');

            $userModel->update(
                $user['id'],
                [
                    'reset_token' => $token,
                    'reset_token_expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                ]);

                $email = \config\Services::email();
                $email->setTo($post['email']);
                $email->setSubject('Recupera contraseña');
        
                $url = base_url('password-reset/'.$token);
                $body = '<p>Estimado '. $user['name'] .'</p>';
                $body .= "<p>Se ha solicitado un reinicio de contraseña.<br>Para restaurar la contraseña, visita la siguiente direccion: <a href='$url'>$url</a></p>";                
        
                $email->setMessage($body);
                $email->send();
            }       
                $title = 'Reinicio de contrasña';
                $message = 'Revisa tu correo electronico para restablecer  tu contraseña.';
        
                return $this->showMessage($title,$message);
    }

    public function resetForm($token){
        $userModel = new UsersModel();
        $user = $userModel->where(['reset_token'=>$token])->first();

        if($user){
            $cdateTime = new \DateTime();
            $cdateTimestr = $cdateTime->format('Y-m-d H:i:s');

            if($cdateTimestr <= $user['reset_token_expires_at'] ){
                return view('reset_password',['token'=>$token]);
            }

            return $this->showMessage('Error','Enlace ha expirado');
        }

        return $this->showMessage('Error','Intenta mas tarde.');
    }

    public function resetPassword()
    {        
        $rules = [ 
            'password' => 'required|max_length[50]|min_length[5]',
            'repassword' => 'matches[password]',
        ];

        if(!$this->validate($rules)){            
           return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['token','password']);
        
        //print_r($this->request);
        //print_r($post);
        //return;

        $user = $userModel->where(['reset_token'=>$post['token'],'active'=>1])->first();

        if($user){
            $userModel->update(
                $user['id'],
                [
                    'passworrd' => password_hash($post['password'],PASSWORD_DEFAULT),
                    'reset_token' => '',
                    'reset_token_expires_at' => ''
                ]
                );

                return $this->showMessage('Contraseña Modificada','hemos actualizado tu contrasña');

        }

        return $this->showMessage('Error','Intenta mas tarde.');

    }


}
