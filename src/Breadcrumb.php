<?php

namespace Yasiao\Breadcrumb;

use Exception;

class Breadcrumb
{

    private $callbacks = [];
    private $breadcrumbs = [];
    private $template;

    /**
     * Register a breadcrumb.
     *
     * @param string   $name
     * @param Callable $callback
     *
     * @throws Exception
     */
    public function register($name, $callback)
    {
        if (array_key_exists($name, $this->callbacks)) {
            throw new Exception("The breadcrumb ($name) has been registered.");
        }

        $this->callbacks[$name] = $callback;
    }

    /**
     * Render the breadcrumb.
     *
     * @param $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws Exception
     */
    public function render($name)
    {
        if (!array_key_exists($name, $this->callbacks)) {
            throw new Exception("Breadcrumb $name is not found.");
        }

        $parameters = array_slice(func_get_args(), 1);

        $breadcrumbs = $this->generate($name, $parameters);

        return $this->renderView($breadcrumbs);
    }

    /**
     * Setting the template to be used.
     *
     * @param $name
     *
     * @return $this
     */
    public function setTemplate($name)
    {
        $this->template = $name;

        return $this;
    }

    /**
     * Push a title and a URL into breadcrumbs
     *
     * @param      $title
     * @param null $url
     */
    public function push($title, $url = null)
    {
        $this->breadcrumbs[] = (object) [
            'title' => $title,
            'url' => $url
        ];
    }

    /**
     * Generate the breadcrumb.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return array
     */
    private function generate($name, $parameters)
    {
        $this->breadcrumbs = [];

        array_unshift($parameters, $this);

        call_user_func_array($this->callbacks[$name], $parameters);

        return $this->breadcrumbs;
    }

    /**
     * Render the breadcrumb into the template.
     *
     * @param $breadcrumbs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function renderView($breadcrumbs)
    {
        return view($this->template, compact('breadcrumbs'));
    }
}