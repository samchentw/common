<?php

namespace Samchentw\Common\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Samchentw\Common\Tests\TestCase;
use Samchentw\Common\Helpers\DictionaryHelper;
use Samchentw\Common\Objects\Dictionary;

class DictionaryTest extends TestCase
{

    /**
     * test dictionary helper
     *
     * @return void
     */
    public function test_dictionary()
    {
        $item = [
            [
                "name" => "sam",
                "age" => 25
            ],
            [
                "name" => "vivian",
                "age" => 24
            ]
        ];

        $dict = DictionaryHelper::toDictionary($item, 'name', 'age');

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                "sam" => 25,
                "vivian" => 24
            ]),
            json_encode($dict)
        );
    }
}
