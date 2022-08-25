<?php

use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{

    protected function setup(): void{
        if(session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
    }

    /**
     * @test
     * @return void
     */
    public function can_check_if_session_is_started(): void
    {
        // SETUP
        // Create a session object
        $session = new App\Session\Session();

        // Assert session is not started
        $this->assertFalse($session->isStarted());
    }

    /**
     * @test
     * @return void
     */
    public function a_session_can_be_started(): void
    {
        // SETUP
        // Create a session object
        $session = new App\Session\Session();

        // Start the session
        $sessionStatus = $session->start();

        // Assert session is started
        $this->assertTrue($session->isStarted());
        $this->assertTrue($sessionStatus);
    }

    /**
     * @test
     */
    public function can_add_items_to_the_session(): void
    {
        //SETUP TEST
        $productId1 = 1;
        $productId2 = 2;

        $session = new App\Session\Session();
        $session->start();

        //DO SOMETHING
        $session->set('cart.items',[
            $productId1 => ['quantity' => 2, 'price' => 1099],
            $productId2 => ['quantity' => 4, 'price' => 599],
        ]);

        //MAKE ASSERTIONS
        $this->assertArrayHasKeys($_SESSION['cart.items'], [$productId1,$productId2]);
    }

    public function assertArrayHasKeys(array $array, array $keys): void
    {
        $diff = array_diff($keys, array_keys($array));

         $this->assertTrue(
            !$diff,
            'The array does not contain the following key(s): '.implode('', $diff)
        );
    }

    /**
     * @return void
     * @test
     */
    public function can_check_that_a_item_exits_in_a_session(): void
    {
        //SETUP TEST
        $session = new App\Session\Session();
        $session->start();

        //DO SOMETHING
        $session->set('auth.id',1);

        //MAKE ASSERTIONS
        $this->assertTrue($session->has('auth.id'));
        $this->assertFalse($session->has('false.key'));
    }

    /**
     * @return void
     * @test
     */
    public function can_get_a_existing_item_from_the_session(): void
    {
        //SETUP TEST
        $session = new App\Session\Session();
        $session->start();

        //DO SOMETHING
        $session->set('auth.id',4);

        $id = $session->get('auth.id');
        $falseKey = $session->get('false.key');
        $retrievedDefault = $session->get('false.key','retrieved default');

        //MAKE ASSERTIONS
        $this->assertEquals(4,$id);
        $this->assertEquals('retrieved default',$retrievedDefault);
        $this->assertNull($falseKey);
    }

    /**
     * @return void
     * @test
     */
    public function can_clear_items_from_the_session(): void
    {
        //SETUP TEST
        $session = new App\Session\Session();
        $session->start();

        //DO SOMETHING
        $session->set('auth.id',4);
        $session->clear();

        //MAKE ASSERTIONS
        $this->assertCount(0, $_SESSION);
        $this->assertEmpty($_SESSION);
    }

    /**
     * @return void
     * @test
     */
    public function can_remove_by_key_a_given_item_from_the_session(): void
    {
        //SETUP TEST
        $session = new App\Session\Session();
        $session->start();

        //DO SOMETHING
        $session->set('auth.id',4);

        $id = $session->remove('auth.id');

        //MAKE ASSERTIONS
        $this->assertNull($id);
    }
}