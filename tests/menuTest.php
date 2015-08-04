<?php


class MenuTest extends TestCase{

	/**
     * A basic functional test example.
     *
     * @return void
     */
    public function testMenulist()
    {
        $this->visit('/')
             ->see('Bienvenido');
    }
}