<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\SesionModel;
use App\Models\SesionMenuModel;

class Login extends BaseController
{
    public function index()//: string
    {
        return view('login');
    }

    public function auth()
    {        
        $rules = [ 
            'user' => 'required',
            'password' => 'required'            
        ];

        if(!$this->validate($rules)){            
           return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['user','password']);

        $user =  $userModel->validateUser($post['user'],$post['password']);

        if ($user !== null ){
            
            $token = bin2hex(random_bytes(16)); // Generar token único
            $empresaId = 1;
            $ip = $this->request->getIPAddress();
            $maquina = gethostname();
            //$ip_cliente = $_SERVER['REMOTE_ADDR'];
            //$maquina = gethostbyaddr($ip_cliente);
            
            $user['token'] = $token;
            $user['empresaId'] = $empresaId;
            $user['ip'] = $ip;
            $user['maquina'] = $maquina;
            
            $dataSs = [
                'IDEMPRESA' => $empresaId,
                'IDUSUARIO' => $user['id'],
                'TOKEN'     => $token,
                'IPADDRESS' => $ip,
                'MAQUINA'   => $maquina,
                'ESTADO'    => 'A',
                'USUCREA'    => $user['user']
            ];
            
            $sesionModel = new SesionModel();
            $sesionModel->insert($dataSs);
            $idSesion = $sesionModel->insertID(); 
            
            $user['idSesion'] = $idSesion;
            
            $sesionMenuModel = new SesionMenuModel();
            $resultado = $sesionMenuModel->poblarSesionMenu($empresaId, $user['id'], $idSesion);
            $userMenu = $sesionMenuModel->getMenuByUser($idSesion);
            $user['userMenu'] = $userMenu;

            $this->setSession($user);

            return redirect()->to(base_url('home'));
        }

        return redirect()->back()->withInput()->with('errors','usuario contraseña son incorrecto.');

    }

    private function setSession($userData)
    {
        $data = [
            'logged_in' => true,
            'idSesion' => $userData['idSesion'],
            'userMenu' => $userData['userMenu'],
            'userid' => $userData['id'],
            'username' => $userData['name'],
            'token' => $userData['token'],
            'empresaId' => $userData['empresaId'],
            'ip' => $userData['ip'],
            'maquina' => $userData['maquina'],
            'last_activity' => time(),
            'transaccionIn' =>false,
            'transaccionId' => '00000',
            'transaccionName'=> '',            
            'productoId'=>'0',
            'productoName'=>'', 
            'moduloId'=>'0',
            'moduloName'=>'', 
            'permiso' => 'NA'
        ];

        $this->session->set($data);
    }

    public function logout()
    {
        $sesionModel = new SesionModel(); // Asegúrate de cargar el modelo de sesión
        $userId = $this->session->get('userid'); // Obtén el ID del usuario actual de la sesión
        
        if ($this->session->get('logged_in')) {
            $sesionModel->closeUserSessions($userId);
            $this->session->destroy(); // Corregido: agregar paréntesis
        }

        return redirect()->to(base_url());
    }
}
