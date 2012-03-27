<?php
if ($this->Session->check('Message.auth'))
{
	echo $this->Session->flash('auth');
}

if ($this->Session->check('Message.error'))
{
	echo $this->Session->flash('error');
}

if ($this->Session->check('Message.flash'))
{
	echo $this->Session->flash();
}