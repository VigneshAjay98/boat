<?php

namespace App\Components;

trait FlashMessages
{
    /**
     * @var Store
     */
    protected $session;

    /**
     * @var array
     */
    protected $alert = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $notifications = [];

    /**
     * Custom error methods
     *
     * @param  [type] $name      [description]
     * @param  [type] $arguments [description]
     * @return [type]            [description]
     */
    public function __call($name, $arguments)
    {
        return $this->alert($name, $arguments);
    }

    /**
     * Set custom alert
     *
     * @param array $message
     * @param string $type
     * @return $this
     */
    public function alert($type, $message)
    {
        if (!is_array($message)) {
            $message = [$message];
        }

        return $this->message($message, $type);
    }

    /**
     * Set information alert
     *
     * @return $this
     */
    public function info()
    {
        return $this->message(func_get_args(), "info");
    }

    /**
     * Set success alert
     *
     * @return $this
     */
    public function success()
    {
        return $this->message(func_get_args(), "success");
    }

    /**
     * Set warning alert
     *
     * @return $this
     */
    public function warning()
    {
        return $this->message(func_get_args(), "warning");
    }

    /**
     * Set danger alert
     *
     * @return $this
     */
    public function error()
    {
        return $this->message(func_get_args(), "error");
    }

    /**
     * Push notifications array to session
     */
    public function push()
    {
        $this->alert['params'] = $this->params;
        $this->notifications[] = $this->alert;
        // store in session
        session()->flash('toastr.alerts', $this->notifications);
        // $this->session->flash();
        // unset
        $this->alert = [];
        $this->params = [];
    }

    /**
     * Expand $args and set alert to notify table
     *
     * @param array $args
     * @param string $type
     * @return $this
     */
    protected function message($args, $type)
    {
        switch (count($args)) {
            case 2:
                $title = $args[0];
                $message = $args[1];
                break;
            case 1:
                $title = '';
                $message = $args[0];
                break;
            default:
                throw new \InvalidArgumentException('Cannot resolve arguments. Please provide one parameter as `message` or two parameters as `title` and `message`.');
        }

        $this->alert = [
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ];

        return $this;
    }
}
