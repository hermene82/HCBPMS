<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $timeout = 300; // 5 minutos = 300 segundos

        if (!session()->get('logged_in')) {
            log_message('error', 'No está autenticado, redirigiendo...');
            return redirect()->to(base_url());
        }else{

            if (session()->has('last_activity')) {
                $inactiveTime = time() - session()->get('last_activity');
                if ($inactiveTime > $timeout) {
                    session()->destroy();
                    log_message('error', 'Sesión expirada por inactividad');
                    return redirect()->to(base_url());
        
                    //return redirect()->to('/login')->with('error', 'Sesión expirada por inactividad');
                }
            }
            
            session()->set('last_activity', time()); // Actualiza el tiempo de actividad

        }
    }

    public function after(RequestInterface $request,ResponseInterface $response,$arguments = null)
    {
        //
    }

}