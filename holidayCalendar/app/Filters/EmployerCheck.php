<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class EmployerCheck implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
        $url = service('uri');
        if( strtolower($url->getSegment(1)) == 'employer'){
            if( $url->getSegment(2)=='')
                $segment='/';
            else
                $segment='/'.$url->getSegment(2);
            return redirect()->to($segment);
            

        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}