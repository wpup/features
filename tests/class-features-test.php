<?php

use WPUP\Features\Features;

class Features_Test extends \WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
		$this->class = Features::instance();
	}

	public function tearDown() {
		parent::tearDown();
		unset( $this->class );
    }

    public function test_enable_features() {
        features( [
            'log' => false,
            'checkout' => true,
            'startpage' => true
        ] );
       
        $this->assertFalse( features()->enabled( 'log' ) );
        $this->assertTrue( features()->enabled( 'checkout' ) );
        $this->assertTrue( features()->enabled( 'startpage' ) );

        $_SERVER ['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'features_nonce' => wp_create_nonce( 'features_update' ),
            'features' => [
                'log' => true,
                'checkout' => false
            ]
        ];

        $this->class->save_features();
        $this->class->enable_features();

        $this->assertTrue( features()->enabled( 'log' ) );
        $this->assertFalse( features()->enabled( 'checkout' ) );
        $this->assertTrue( features()->enabled( 'startpage' ) );
    }

    public function test_save_features() {
        $this->class->save_features();

        $this->assertEmpty( get_option( 'features' ) );

        $_SERVER ['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'features_nonce' => wp_create_nonce( 'features_update' ),
            'features' => [
                'log' => true,
                'checkout' => false
            ]
        ];

        $this->class->save_features();

        $this->assertNotEmpty( get_option( 'features' ) );

        delete_option( 'features' );
    }
}
