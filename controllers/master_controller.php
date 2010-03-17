<?php


class MasterController extends AppController
{

    public function index()
    {
        //string $s;
        //$p = new PagesController();
        //$p->display();
        $this->redirect(array('controller' => 'pages', 'action' => 'display', 'index'));
    }

    public function event()
    {
        $this->redirect(array('controller' => 'events'));
    }

    public function admin()
    {
        $this->redirect(array('controller' => 'events', 'action' => 'index', 'admin' => true));
    }

    public function admin_admin()
    {
        $this->admin();
    }

}



?>