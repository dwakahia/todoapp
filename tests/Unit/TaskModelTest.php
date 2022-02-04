<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_task_model()
    {
        $task = new Task();
        $task->name = 'task one';
        $task->description = 'new desc';

        $this->assertEquals($task->name, 'task one');

        $this->assertNotNull($task->description);
    }
}
