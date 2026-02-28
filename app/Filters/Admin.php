<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}