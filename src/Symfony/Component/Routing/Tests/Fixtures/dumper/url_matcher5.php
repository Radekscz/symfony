<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Tests\Fixtures\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        if ($ret = $this->doMatch($pathinfo, $allow)) {
            return $ret;
        }
        if ('/' !== $pathinfo && in_array($this->context->getMethod(), array('HEAD', 'GET'), true)) {
            $pathinfo = '/' !== $pathinfo[-1] ? $pathinfo.'/' : substr($pathinfo, 0, -1);
            if ($ret = $this->doMatch($pathinfo)) {
                return $this->redirect($pathinfo, $ret['_route']) + $ret;
            }
        }

        throw $allow ? new MethodNotAllowedException(array_keys($allow)) : new ResourceNotFoundException();
    }

    private function doMatch(string $rawPathinfo, array &$allow = array()): ?array
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $context = $this->context;
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        switch ($pathinfo) {
            default:
                $routes = array(
                    '/a/11' => array(array('_route' => 'a_first'), null, null, null),
                    '/a/22' => array(array('_route' => 'a_second'), null, null, null),
                    '/a/333' => array(array('_route' => 'a_third'), null, null, null),
                    '/a/44/' => array(array('_route' => 'a_fourth'), null, null, null),
                    '/a/55/' => array(array('_route' => 'a_fifth'), null, null, null),
                    '/a/66/' => array(array('_route' => 'a_sixth'), null, null, null),
                    '/nested/group/a/' => array(array('_route' => 'nested_a'), null, null, null),
                    '/nested/group/b/' => array(array('_route' => 'nested_b'), null, null, null),
                    '/nested/group/c/' => array(array('_route' => 'nested_c'), null, null, null),
                    '/slashed/group/' => array(array('_route' => 'slashed_a'), null, null, null),
                    '/slashed/group/b/' => array(array('_route' => 'slashed_b'), null, null, null),
                    '/slashed/group/c/' => array(array('_route' => 'slashed_c'), null, null, null),
                );

                if (!isset($routes[$pathinfo])) {
                    break;
                }
                list($ret, $requiredHost, $requiredMethods, $requiredSchemes) = $routes[$pathinfo];

                if ($requiredSchemes && !isset($requiredSchemes[$context->getScheme()])) {
                    if ('GET' !== $canonicalMethod) {
                        $allow['GET'] = 'GET';
                        break;
                    }

                    return $this->redirect($rawPathinfo, $ret['_route'], key($requiredSchemes)) + $ret;
                }

                if ($requiredMethods && !isset($requiredMethods[$canonicalMethod]) && !isset($requiredMethods[$requestMethod])) {
                    $allow += $requiredMethods;
                    break;
                }

                return $ret;
        }

        $matchedPathinfo = $pathinfo;
        $regexList = array(
            0 => '{^(?'
                    .'|/([^/]++)(*:16)'
                    .'|/nested/([^/]++)(*:39)'
                .')$}sD',
        );

        foreach ($regexList as $offset => $regex) {
            while (preg_match($regex, $matchedPathinfo, $matches)) {
                switch ($m = (int) $matches['MARK']) {
                    default:
                        $routes = array(
                            16 => array(array('_route' => 'a_wildcard'), array('param'), null, null),
                            39 => array(array('_route' => 'nested_wildcard'), array('param'), null, null),
                        );

                        list($ret, $vars, $requiredMethods, $requiredSchemes) = $routes[$m];

                        foreach ($vars as $i => $v) {
                            if (isset($matches[1 + $i])) {
                                $ret[$v] = $matches[1 + $i];
                            }
                        }

                        if ($requiredSchemes && !isset($requiredSchemes[$context->getScheme()])) {
                            if ('GET' !== $canonicalMethod) {
                                $allow['GET'] = 'GET';
                                break;
                            }

                            return $this->redirect($rawPathinfo, $ret['_route'], key($requiredSchemes)) + $ret;
                        }

                        if ($requiredMethods && !isset($requiredMethods[$canonicalMethod]) && !isset($requiredMethods[$requestMethod])) {
                            $allow += $requiredMethods;
                            break;
                        }

                        return $ret;
                }

                if (39 === $m) {
                    break;
                }
                $regex = substr_replace($regex, 'F', $m - $offset, 1 + strlen($m));
                $offset += strlen($m);
            }
        }

        return null;
    }
}
