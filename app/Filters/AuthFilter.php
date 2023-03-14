<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JWTCI4;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if( !$request->getHeader('Authorization') )
		{
			$response = service('response');
            $response->setJSON(['success' => false, 'message' => 'Unauthorized. Token is required!']);
            $response->setStatusCode(401);
            return $response;
		}

		//validasi JWT
		$token = $request->getHeader('Authorization');
		$jwt = new JWTCI4;
		$verifiy = $jwt->parse($token);
		if( !$verifiy['success'] )
		{
			$response = service('response');
            $response->setJSON($verifiy);
            $response->setStatusCode(401);
            return $response;
		}
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
