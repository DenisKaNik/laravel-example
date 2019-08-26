<?php

namespace Tests\Unit;

use App\Http\Requests\AnketaPost;
use Faker\Factory;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AnketaTest extends TestCase
{
    public function testPostEmpty()
    {
        try {
            $request = new AnketaPost([]);
            $request
                ->setContainer(app())
                ->setRedirector(app(Redirector::class))
                ->validateResolved();
        } catch (ValidationException $e) {
            //
        }

        $this->assertTrue(isset($e));

        $this->assertTrue(array_key_exists('first_name', $e->errors()));
        $this->assertTrue(array_key_exists('last_name', $e->errors()));
        $this->assertTrue(array_key_exists('phone', $e->errors()));
        $this->assertTrue(array_key_exists('email', $e->errors()));
        $this->assertTrue(array_key_exists('education', $e->errors()));
    }

    public function testValidateEmailEducation()
    {
        $faker = Factory::create();

        $param = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->realText(),
            'education' => $faker->realText(10),
        ];

        try {
            $request = new AnketaPost($param);
            $request
                ->setContainer(app())
                ->setRedirector(app(Redirector::class))
                ->validateResolved();
        } catch (ValidationException $e) {
            //
        }

        $this->assertTrue(isset($e));

        $this->assertEquals(current($e->errors()['email']), 'The email must be a valid email address.');
        $this->assertEquals(current($e->errors()['education']), 'The selected education is invalid.');
    }

    public function testPostSuccess()
    {
        $faker = Factory::create();

        $param = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->email,
            'education' => 'Master',
        ];

        try {
            $request = new AnketaPost($param);
            $request
                ->setContainer(app())
                ->setRedirector(app(Redirector::class))
                ->validateResolved();
        } catch (ValidationException $e) {
            //
        }

        $this->assertFalse(isset($e));
    }
}
