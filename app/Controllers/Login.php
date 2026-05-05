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
            'user'     => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $usuarioEmpresaModel = new \App\Models\UsuarioEmpresaModel();

        $post = $this->request->getPost(['user', 'password']);
        $user = $userModel->validateUser($post['user'], $post['password']);

        if ($user !== null) {

            $token = bin2hex(random_bytes(16));
            $ip = $this->request->getIPAddress();
            $maquina = gethostname();

            // Empresas del usuario
            $empresaLista = $usuarioEmpresaModel->getEmpresasUsuario($user['id']);
            $empresaDefault = $usuarioEmpresaModel->getEmpresaDefault($empresaLista);

            if (empty($empresaLista)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', 'El usuario no tiene empresas activas asignadas.');
            }

            $empresaId = $empresaDefault['IDEMPRESA'] ?? null;

            if (empty($empresaId)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', 'No se pudo determinar la empresa por defecto del usuario.');
            }

            $user['token']        = $token;
            $user['empresaId']    = $empresaId;
            $user['empresaLista'] = $empresaLista;
            $user['ip']           = $ip;
            $user['maquina']      = $maquina;

            $dataSs = [
                'IDEMPRESA' => $empresaId,
                'IDUSUARIO' => $user['id'],
                'TOKEN'     => $token,
                'IPADDRESS' => $ip,
                'MAQUINA'   => $maquina,
                'ESTADO'    => 'A',
                'USUCREA'   => $user['user']
            ];

            $sesionModel = new SesionModel();
            $sesionModel->insert($dataSs);
            $idSesion = $sesionModel->insertID();

            $user['idSesion'] = $idSesion;

            $sesionMenuModel = new SesionMenuModel();
            $sesionMenuModel->poblarSesionMenu($empresaId, $user['id'], $idSesion);

            $userMenu = $sesionMenuModel->getMenuByUser($idSesion);
            $user['userMenu'] = $userMenu;

            $this->setSession($user);

            //log_message('debug', 'Login-auth SESSION DATA: ' . print_r(session()->get(), true));

            return redirect()->to(base_url('home'));
        }

        return redirect()->back()->withInput()->with('errors', 'usuario contraseña son incorrecto.');
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
            'empresaId' => $userData['empresaId'] ?? null,
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
            'permiso' => 'NA',            
            'empresaLista'=> $userData['empresaLista'] ?? []
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

    public function cambiarEmpresa()
    {
        if (!session('logged_in')) {
            return $this->response->setJSON([
                'ok' => false,
                'msg' => 'Sesión no válida'
            ]);
        }

        $empresaIdNueva = $this->request->getPost('empresaId');
        $empresaLista = session('empresaLista') ?? [];
        $idUsuario = session('userid');
        $idSesion = session('idSesion');

        //log_message('debug', 'Login-cambiarEmpresa empresaIdNueva: ' . $empresaIdNueva);
        //log_message('debug', 'Login-cambiarEmpresa idSesion: ' . $idSesion);

        $permitida = false;
        foreach ($empresaLista as $empresa) {
            if ((string)$empresa['IDEMPRESA'] === (string)$empresaIdNueva) {
                $permitida = true;
                break;
            }
        }

        if (!$permitida) {
            return $this->response->setJSON([
                'ok' => false,
                'msg' => 'La empresa no pertenece al usuario'
            ]);
        }

        session()->set('empresaId', $empresaIdNueva);

        $sesionMenuModel = new \App\Models\SesionMenuModel();
        $sesionMenuModel->poblarSesionMenu($empresaIdNueva, $idUsuario, $idSesion);

        $userMenu = $sesionMenuModel->getMenuByUser($idSesion);
        session()->set('userMenu', $userMenu);

        //log_message('debug', 'Login-cambiarEmpresa SESSION DATA: ' . print_r(session()->get(), true));

        return $this->response->setJSON([
            'ok' => true,
            'msg' => 'Empresa actualizada',
            'empresaId' => $empresaIdNueva
        ]);
    }
}
