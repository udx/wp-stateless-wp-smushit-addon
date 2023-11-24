<?php

namespace WPSL\Smush;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use wpCloud\StatelessMedia\WPStatelessStub;

/**
 * Class ClassSmushTest
 */
class ClassSmushTest extends TestCase {
  // Adds Mockery expectations to the PHPUnit assertions count.
  use MockeryPHPUnitIntegration;

  public function setUp(): void {
		parent::setUp();
		Monkey\setUp();
  }
	
  public function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

  public function testShouldInitHooks() {
    $smush = new Smush();

    $smush->module_init([]);

    self::assertNotFalse( has_filter('delete_attachment', [ $smush, 'remove_backup' ]) );
    self::assertNotFalse( has_filter('smush_backup_exists', [ $smush, 'backup_exists_on_gcs' ]) );
    self::assertNotFalse( has_action('wp_smush_image_optimised', [ $smush, 'image_optimized' ]) );
    self::assertNotFalse( has_action('smush_file_exists', [ $smush, 'maybe_download_file' ]) );
    self::assertNotFalse( has_action('sm:synced::image', [ $smush, 'sync_backup' ]) );
  }
}
